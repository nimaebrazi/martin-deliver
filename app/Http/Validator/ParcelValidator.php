<?php

namespace App\Http\Validator;

use App\Infrastructure\Validator\AbstractValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ParcelValidator extends AbstractValidator
{
    public function rules(): array
    {
        return [

            // source rules
            'source.name' => 'required|min:3',
            'source.address' => 'required|min:3',
            'source.lat' => 'required|between:-90,90',
            'source.long' => 'required|between:-180,180',
            'source.mobile' => ['required', 'regex:/(0|\+98)?([]|[()]){0,2}9[0-9]([]|[()]){0,2}(?:[0-9]([]|[()]){0,2}){8}/i'],

            // destination rules
            'destination.name' => 'required|min:3',
            'destination.address' => 'required|min:3',
            'destination.lat' => 'required|between:-90,90',
            'destination.long' => 'between:-180,180',
            'destination.mobile' => ['required', 'regex:/(0|\+98)?([]|[()]){0,2}9[0-9]([]|[()]){0,2}(?:[0-9]([]|[()]){0,2}){8}/i'],

        ];

    }
}
