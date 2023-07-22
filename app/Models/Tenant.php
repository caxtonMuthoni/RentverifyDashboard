<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Tenant extends Model
{
    use HasFactory, AsSource;

    protected $appends = ['details'];

    public function getDetailsAttribute()
    {
        return $this->attributes['national_id'] . ' (' . $this->attributes['first_name'] . ' ' . $this->attributes['sir_name'] . ' - ' . $this->attributes['phone_number'] . ')';
    }

    public function scopeLandlordTenants($query)
    {
        $landlord_id = Landlord::where('user_id', auth()->id())->value('id');
        return $query->where('landlord_id', $landlord_id);
    }

    public function scopeTenantHasRoom($query)
    {
        return $query->whereNotNull('room_id');
    }


    public function idfrontimages()
    {
        return $this->hasMany(Attachment::class, 'id', 'national_id_front_id');
    }
    public function idbackimages()
    {
        return $this->hasMany(Attachment::class, 'id', 'national_id_back_id');
    }

    public function room()
    {
        return  $this->belongsTo(Room::class);
    }

    public function rooms()
    {
        return  $this->hasMany(TenantRoom::class);
    }

    public function active_rooms()
    {
        return  $this->hasMany(TenantRoom::class)->whereIsActive();
    }
}
