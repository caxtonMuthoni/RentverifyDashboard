<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class TenantRoom extends Model
{
    use HasFactory, AsSource, Filterable;

    public function scopeLandlordTenants($query)
    {
        $landlord_id = Landlord::where('user_id', auth()->id())->value('id');
        return $query->where('landlord_id', $landlord_id);
    }

    public function scopeTenantRooms($query)
    {
        $tenant_id = Tenant::where('user_id', auth()->id())->value('id');
        return $query->where('tenant_id', $tenant_id);
    }

    public function room()
    {
        return  $this->belongsTo(Room::class);
    }

    public function apartment()
    {
        return $this->hasOneThrough(Apartment::class, Room::class, 'id', 'id', 'room_id', 'apartment_id');
    }

    public function tenant()
    {
        return  $this->belongsTo(Tenant::class);
    }

    public function landlord()
    {
        return  $this->belongsTo(Landlord::class);
    }

    public function clearance_report()
    {
        return $this->hasOne(ClearlanceReport::class);
    }
}
