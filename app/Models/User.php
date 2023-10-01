<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Model
{
    protected $fillable = ['email', 'otp'];

    function customerProfile(): HasOne
    {
        return $this->hasOne(CustomerProfile::class);
    }
}