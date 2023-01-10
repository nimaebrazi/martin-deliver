<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    public function scopeAccessToken(Builder $query, string $accessToken)
    {
        return $query->where('access_token', '=', $accessToken);
    }
}
