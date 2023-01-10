<?php

namespace App\Service\Parcel;

use App\Models\ParcelStatus;
use App\Service\Parcel\Jobs\StatusWebhook;

class ParcelStatusObserver
{

    public function created(ParcelStatus $parcelStatus)
    {
        dispatch(new StatusWebhook($parcelStatus->parcel()->first()));
    }
}
