<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Room extends Model
{
    use HasFactory, AsSource;

    protected $guarded = [];

    public function scopeLandlordRooms($query)
    {
        return $query->where('landlord_id', Landlord::where('user_id', auth()->id())->value('id'));
    }


    public function scopeApartmentRooms($query, $apartmentID)
    {
        return $query->where('apartment_id', $apartmentID);
    }

    public function tenant() {
        return $this->hasOneThrough(Tenant::class, TenantRoom::class, 'room_id', 'id' , 'id', 'tenant_id');
    }


    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    public function room_type()
    {
        return $this->belongsTo(RoomType::class);
    }
}
