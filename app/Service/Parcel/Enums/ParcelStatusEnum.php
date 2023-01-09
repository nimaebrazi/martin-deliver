<?php


namespace App\Service\Parcel\Enums;


enum ParcelStatusEnum: int
{
    case REGISTERED = 0;
    case ACCEPT_BY_DRIVER = 1;
    case DELIVERY_FROM_SOURCE = 2;
    case GO_TO_DESTINATION = 3;
    case DELIVERY_TO_DESTINATION = 4;
    case CANCEL_BY_SOURCE = 5;
    case CANCEL_BY_DRIVER = 6;
}
