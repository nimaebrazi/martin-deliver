<?php

namespace App\Service\Parcel;

use App\Models\Parcel;
use App\Service\Parcel\Exception\ParcelStatusExistsException;
use Exception;
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

    public function cancel()
    {
    }

    public function parcelStatus()
    {
    }
}
