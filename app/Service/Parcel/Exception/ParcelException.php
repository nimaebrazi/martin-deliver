<?php


namespace App\Service\Parcel\Exception;


class ParcelException
{
    public static function parcelStatusExists(): ParcelStatusExistsException
    {
        return new ParcelStatusExistsException('Status exists and cannot create same status for parcel');
    }
}
