<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Validator\ParcelValidator;
use App\Infrastructure\Validator\ValidationException;
use App\Models\Parcel;
use App\Models\ParcelStatus;
use App\Service\Parcel\Exception\ParcelIsNotCancelableException;
use App\Service\Parcel\Exception\ParcelNotExistsException;
use App\Service\Parcel\Exception\ParcelStatusExistsException;
use App\Service\Parcel\ParcelService;
use App\Service\Parcel\ParcelStatusService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\FlareClient\Api;
use Symfony\Component\HttpFoundation\Response;

class ParcelController extends Controller
{

    private ParcelService $parcelService;

    public function __construct(ParcelService $parcelService)
    {
        $this->parcelService = $parcelService;
    }

    /**
     * @throws ValidationException
     * @throws ParcelStatusExistsException
     */
    public function register(Request $request, ParcelValidator $parcelValidator): JsonResponse
    {
        $parcelValidator->make($request->all())->validate();

        $parcel = $this->parcelService->register($this->getParcelData($request));

        return ApiResponse::success(['id' => $parcel?->id]);

    }


    /**
     * @throws ParcelNotExistsException
     * @throws ParcelIsNotCancelableException
     */
    public function cancel($parcelId): JsonResponse|Response
    {
        $this->parcelService->cancel($parcelId);

        return ApiResponse::noContent();

    }

    public function status($parcelId): JsonResponse
    {
        return ApiResponse::success($this->parcelService->parcelStatus($parcelId));
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function getParcelData(Request $request): array
    {
        return [
            'source_name' => $request->input('source.name'),
            'source_address' => $request->input('source.address'),
            'source_mobile' => $request->input('source.mobile'),
            'source_lat' => $request->input('source.lat'),
            'source_long' => $request->input('source.long'),

            'destination_name' => $request->input('destination.name'),
            'destination_address' => $request->input('destination.address'),
            'destination_mobile' => $request->input('destination.mobile'),
            'destination_lat' => $request->input('destination.lat'),
            'destination_long' => $request->input('destination.long'),
        ];
    }
}
