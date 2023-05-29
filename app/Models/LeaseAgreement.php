<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Orchid\Screen\AsSource;

class LeaseAgreement extends Model
{
    use HasFactory, AsSource;

    protected $appends = ['unsigned_url', 'signed_url', 'landlord_signed_url'];

    public function scopeLandlordAgreements($query)
    {
        return $query->where('landlord_id', Landlord::where('user_id', auth()->id())->value('id'));
    }

    public function scopeTenantAgreements($query)
    {
        return $query->where('tenant_id', Tenant::where('user_id', auth()->id())->value('id'));
    }

    public function getUnsignedUrlAttribute()
    {
        return Storage::url($this->attributes['unsigned_pdf_path']);
    }

    public function getSignedUrlAttribute()
    {
        if (isset($this->attributes['signed_pdf_path'])) {
            return Storage::url($this->attributes['signed_pdf_path']);
        }

        return null;
    }

    public function getLandlordSignedUrlAttribute()
    {
        if (isset($this->attributes['landlord_signed_pdf_path'])) {
            return Storage::url($this->attributes['landlord_signed_pdf_path']);
        }

        return null;
    }



    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
