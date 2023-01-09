<?php


namespace App\Service\Parcel;

use App\Models\Parcel;
use App\Models\ParcelStatus;
use App\Service\Parcel\Enums\ParcelStatusEnum;
use App\Service\Parcel\Exception\ParcelException;
use App\Service\Parcel\Exception\ParcelStatusExistsException;
use Illuminate\Database\Eloquent\Collection;


class ParcelStatusService
{

    /**
     * @param Parcel $parcel
     * @return Parcel|null
     *
     * @throws ParcelStatusExistsException
     */
    public function createRegisteredStatus(Parcel $parcel): ?ParcelStatus
    {
        return $this->createStatus($parcel, ParcelStatusEnum::REGISTERED);
    }

    /**
     * @param Parcel $parcel
     * @param ParcelStatusEnum $statusEnum
     * @return Parcel|null
     *
     * @throws ParcelStatusExistsException
     */
    protected function createStatus(Parcel $parcel, ParcelStatusEnum $statusEnum): ?ParcelStatus
    {

        $statuses = $parcel->statuses()->get();

        if ($statuses->isNotEmpty()) {

            if ($this->isExistsStatus($parcel, $statuses, $statusEnum)) {
                throw ParcelException::parcelStatusExists();
            }

            $this->deActiveExistsStatusesForParcel($parcel);

        }

        return ParcelStatus::create([
            'status' => $statusEnum->value,
            'parcel_id' => $parcel->id,
            'is_active' => true,
        ]);
    }


    protected function deActiveExistsStatusesForParcel(Parcel $parcel)
    {
        return ParcelStatus::parcelId($parcel->id)->update('is_active', false);
    }

    protected function isExistsStatus(Parcel $parcel, Collection $parcelStatuses, ParcelStatusEnum $statusEnum): bool
    {
        foreach ($parcelStatuses as $status) {
            if ($status->status == $statusEnum->value) {
                return true;
            }
        }

        return false;
    }
}
