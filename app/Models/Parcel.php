<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 *
 * @method  static activeStatus
 */
class Parcel extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at'];


    public function statuses(): HasMany
    {
        return $this->hasMany(ParcelStatus::class);
    }

    public function status(): HasOne
    {
        return $this->hasOne(ParcelStatus::class)->active()->limit(1);
    }

    public function driver()
    {
        $this->belongsTo(Driver::class);
    }

}
