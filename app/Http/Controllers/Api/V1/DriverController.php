<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Service\Parcel\Enums\ParcelStatusEnum;
use App\Service\Parcel\ParcelService;
use App\Service\Parcel\ParcelStatusService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DriverController extends Controller
{

    private ParcelService $parcelService;
    private ParcelStatusService $parcelStatusService;

    public function __construct(ParcelService $parcelService, ParcelStatusService $parcelStatusService)
    {
        $this->parcelService = $parcelService;
        $this->parcelStatusService = $parcelStatusService;
    }

    public function accept($id, Request $request)
    {
        $driverId = Driver::accessToken($request->header('Authorization'))->first()?->id;

        $this->parcelService->accept($id, $driverId);

        ApiResponse::noContent();
    }

    /**
     * @throws \App\Service\Parcel\Exception\ParcelIsNotCancelableException
     * @throws \App\Service\Parcel\Exception\ParcelNotExistsException
     * @throws \App\Exceptions\AuthenticationException
     */
    public function cancel($id, Request $request)
    {
        $this->parcelService->cancelByDriver($id, $request->header('Authorization'));
    }

    /**
     * @throws \App\Service\Parcel\Exception\ParcelStatusExistsException
     */
    public function updateParcelStatus($id, Request $request): Response
    {

        $statuses = [
            ParcelStatusEnum::CANCEL_BY_SOURCE->value,
            ParcelStatusEnum::REGISTERED->value,
        ];

        if (in_array($request->input('status'), $statuses)) {
            throw new \Exception('cannot set this state');
        }

        $this->parcelStatusService->createStatusById($id, ParcelStatusEnum::from($request->input('status')));

        return ApiResponse::noContent();
    }

}
