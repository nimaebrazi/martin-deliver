<?php


namespace App\Service\Parcel\Exception;


class ParcelException
{
    public static function parcelStatusExists(): ParcelStatusExistsException
    {
        return new ParcelStatusExistsException('Status exists and cannot create same status for parcel');
    }

    public static function parcelnotExists(): ParcelNotExistsException
    {
        return new ParcelNotExistsException('Parcel not found.');
    }

    public static function parcelIsNotCancelable(): ParcelIsNotCancelableException
    {
        return new ParcelIsNotCancelableException('You can not cancel parcel.');
    }

}
