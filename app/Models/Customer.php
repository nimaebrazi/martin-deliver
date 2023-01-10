<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 *
 * @method static accessToken()
 * @method static companyIdentity()
 *
 */
class Customer extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at'];

    public function scopeCompanyIdentity(Builder $query, string $id)
    {
        return $query->where('company_identity', '=', $id);
    }


    public function scopeAccessToken(Builder $query, string $accessToken)
    {
        return $query->where('access_token', '=', $accessToken);
    }
}
