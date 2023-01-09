<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Parcel extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at'];


    public function statuses(): HasMany
    {
        return $this->hasMany(ParcelStatus::class);
    }


}
