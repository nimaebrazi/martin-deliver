<?php

namespace App\Service\Parcel;

use App\Models\Parcel;
use Illuminate\Support\Facades\Log;

class StatusWebhookService
{
    public function dispatchStatusToCompany(Parcel $parcel)
    {
        // TODO: fetch webhook from Customer model
        Log::info('send by curl to company webhook');
    }
}
