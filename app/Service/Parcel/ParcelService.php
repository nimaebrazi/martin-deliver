<?php

namespace App\Service\Parcel;

use App\Exceptions\AuthenticationException;
use App\Models\Customer;
use App\Models\Parcel;
use App\Models\ParcelStatus;
use App\Service\Parcel\Enums\ParcelStatusEnum;
use App\Service\Parcel\Events\ParcelRegistered;
use App\Service\Parcel\Exception\ParcelException;
use App\Service\Parcel\Exception\ParcelIsNotCancelableException;
use App\Service\Parcel\Exception\ParcelNotExistsException;
use App\Service\Parcel\Exception\ParcelStatusExistsException;
use Exception;
use Illuminate\Contracts\Events\Dispatcher as EventsDispatcher;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ParcelService
{
    private ParcelStatusService $parcelStatusService;
    private EventsDispatcher $eventsDispatcher;

    public function __construct(ParcelStatusService $parcelStatusService, EventsDispatcher $eventsDispatcher)
    {
        $this->parcelStatusService = $parcelStatusService;
        $this->eventsDispatcher = $eventsDispatcher;
    }

    /**
     * @throws Exception
     * @throws ParcelStatusExistsException
     */
    public function register(array $data)
    {
        DB::beginTransaction();

        try {
            $customer = $this->getCustomerByToken($data['token']);

            unset($data['token']);
            $data['customer_id'] = $customer->id;

            $parcel = Parcel::create($data);

            $this->parcelStatusService->createRegisteredStatus($parcel);

            DB::commit();

            $this->eventsDispatcher->dispatch(new ParcelRegistered($parcel));

            return $parcel;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param mixed $parcelId
     * @return mixed
     * @throws ParcelIsNotCancelableException
     * @throws ParcelNotExistsException
     */
    public function cancelBySource(mixed $parcelId): mixed
    {
        $parcel = Parcel::find($parcelId);
        if (is_null($parcel)) {
            throw ParcelException::parcelnotExists();
        }

        return $this->cancel($parcelId, ParcelStatusEnum::CANCEL_BY_SOURCE);
        // TODO: handle event. remove from broker or some thing
    }

    /**
     * @param mixed $parcelId
     * @param $token
     * @return mixed $token
     * @throws AuthenticationException
     * @throws ParcelIsNotCancelableException
     * @throws ParcelNotExistsException
     */
    public function cancelByDriver(mixed $parcelId, $token): mixed
    {
        // TODO: instead pass token to should use  AuthFactory contract.

        $parcel = Parcel::find($parcelId);
        if (is_null($parcel)) {
            throw ParcelException::parcelnotExists();
        }

        $driver = $parcel->driver()->first();
        if ($driver->access_token !== $token) {
            throw new AuthenticationException();
        }

        return $this->cancel($parcel, ParcelStatusEnum::CANCEL_BY_DRIVER);
        // TODO: handle event. dispatch to broker or some thing
    }

    /**
     * @param Parcel $parcel
     * @param ParcelStatusEnum $statusEnum
     * @return bool
     * @throws ParcelIsNotCancelableException
     */
    protected function cancel(Parcel $parcel, ParcelStatusEnum $statusEnum)
    {
        /** @var ParcelStatus $parcelStatus */
        $parcelStatus = $parcel->status()->first();

        if (!$this->parcelIsCancelable($parcel, $parcelStatus)) {
            throw ParcelException::parcelIsNotCancelable();
        }

        return $parcelStatus->update(['status' => $statusEnum->value]);
    }

    public function parcelStatus($parcelId): ?Collection
    {
        return ParcelStatus::parcelId($parcelId)->get();
    }

    /**
     * @throws ParcelStatusExistsException
     */
    public function accept($parcelId, $driverId)
    {
        DB::transaction(function () use ($parcelId, $driverId) {

            /** @var Parcel $parcel */
            $parcel = Parcel::lockForUpdate()->find($parcelId);

            $status = $parcel->status;
            if ((int)$status->status != ParcelStatusEnum::REGISTERED->value) {
                throw new \Exception('You can not accept this parcel.');
            }

            // Handle race condition
            $parcel->update([
                'driver_id' => $driverId
            ]);

            $this->parcelStatusService->createAcceptByDriverStatus($parcel);

        });

        // TODO: dispatch event to webhooks which accepted driver
    }

    /**
     * @param Parcel $parcel
     * @param ParcelStatus $parcelStatus
     * @return bool
     */
    protected function parcelIsCancelable(Parcel $parcel, ParcelStatus $parcelStatus): bool
    {
        if ($parcelStatus->status == ParcelStatusEnum::DELIVERY_FROM_SOURCE->value ||
            $parcelStatus->status == ParcelStatusEnum::GO_TO_DESTINATION->value ||
            $parcelStatus->status == ParcelStatusEnum::DELIVERY_TO_DESTINATION->value) {

            return false;
        }

        return true;
    }

    /**
     * @param $token
     * @return Customer|null
     */
    protected function getCustomerByToken($token): ?Customer
    {
        return Customer::accessToken($token)->first();
    }
}
