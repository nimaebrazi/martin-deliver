<?php

namespace App\Service\Parcel;

use App\Models\Parcel;
use App\Models\ParcelStatus;
use App\Service\Parcel\Enums\ParcelStatusEnum;
use App\Service\Parcel\Exception\ParcelException;
use App\Service\Parcel\Exception\ParcelIsNotCancelableException;
use App\Service\Parcel\Exception\ParcelNotExistsException;
use App\Service\Parcel\Exception\ParcelStatusExistsException;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ParcelService
{
    private ParcelStatusService $parcelStatusService;

    public function __construct(ParcelStatusService $parcelStatusService)
    {
        $this->parcelStatusService = $parcelStatusService;
    }

    /**
     * @throws Exception
     * @throws ParcelStatusExistsException
     */
    public function register(array $data)
    {
        DB::beginTransaction();

        try {
            $parcel = Parcel::create($data);

            $this->parcelStatusService->createRegisteredStatus($parcel);

            DB::commit();

            // TODO: event dispatch order registered
            // listen drivers for accept it

            return $parcel;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param mixed $parcelId
     * @throws ParcelNotExistsException
     * @throws ParcelIsNotCancelableException
     */
    public function cancel(mixed $parcelId)
    {
        $parcel = Parcel::find($parcelId);

        if (is_null($parcel)) {
            throw ParcelException::parcelnotExists();
        }

        $parcelStatus = $parcel->status()->first();
        if (!$this->parcelIsCancelable($parcel, $parcelStatus)) {
            throw ParcelException::parcelIsNotCancelable();
        }

        $result = $parcelStatus->update(['status' => ParcelStatusEnum::CANCEL_BY_SOURCE->value]);

        // TODO: handle event. remove from broker or some thing


        return $result;
    }

    public function parcelStatus($parcelId): ?Collection
    {
        return ParcelStatus::parcelId($parcelId)->get();
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
}
