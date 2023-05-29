<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Landlord extends Model
{
    use HasFactory, AsSource;

    protected $fillable = [
        'name',
        'phone_number',
        'is_phone_number_visible',
        'email',
        'allowed_rent_payment_days',
        'office_location',
        'security_deposit_percentage',
        'user_id'
    ];

    public function scopeBelongsToAuthUser($query)
    {
        return $query->where('user_id', auth()->id());
    }
}
