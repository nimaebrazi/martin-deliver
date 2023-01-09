<?php


namespace App\Service\Parcel\Exception;


class ParcelException
{
    public static function parcelStatusExists(): ParcelStatusExistsException
    {
        return new ParcelStatusExistsException('Status exists and cannot create same status for parcel', 422);
    }

    public static function parcelnotExists(): ParcelNotExistsException
    {
        return new ParcelNotExistsException('Parcel not found.', 404);
    }

    public static function parcelIsNotCancelable(): ParcelIsNotCancelableException
    {
        return new ParcelIsNotCancelableException('You can not cancel parcel.', 422);
    }

}
