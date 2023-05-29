<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class TenantRoom extends Model
{
    use HasFactory, AsSource;

    public function scopeLandlordTenants($query)
    {
        $landlord_id = Landlord::where('user_id', auth()->id())->value('id');
        return $query->where('landlord_id', $landlord_id);
    }

    public function room()
    {
        return  $this->belongsTo(Room::class);
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
