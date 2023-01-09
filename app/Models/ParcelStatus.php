<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 *
 * @property string $status
 * @property string $is_active
 *
 * @method static active
 * @method static parcelId
 */
class ParcelStatus extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'parcel_id', 'is_active'];

    public function parcel()
    {
        return $this->belongsTo(Parcel::class, 'parcel_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeParcelId(Builder $query, int $parcelId): Builder
    {
        return $query->where('parcel_id', '=', $parcelId);
    }
}
