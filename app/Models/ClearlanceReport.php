<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class ClearlanceReport extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $appends = ['unsigned_url', 'signed_url'];

    public function getUnsignedUrlAttribute()
    {
        return Storage::url($this->attributes['unsigned_clearlance_report_path']);
    }

    public function getSignedUrlAttribute()
    {
        if (isset($this->attributes['clearlance_report_path'])) {
            return Storage::url($this->attributes['clearlance_report_path']);
        }

        return null;
    }

    public function scopeLandlordClearlanceReports($query)
    {
        return $query->where('landlord_id', Landlord::where('user_id', auth()->id())->value('id'));
    }

    public function scopeTenantClearlanceReports($query)
    {
        return $query->where('tenant_id', Tenant::where('user_id', auth()->id())->value('id'));
    }


    public function scopeNotProcessed($query)
    {
        return $query->where('is_processed', false);
    }



    public function tenant_room()
    {
        return $this->belongsTo(TenantRoom::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function apartment()
    {
        return $this->hasOneThrough(Apartment::class, Room::class, 'id', 'id', 'room_id', 'apartment_id');
    }
}
