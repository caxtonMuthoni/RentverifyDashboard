<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Payment extends Model
{
    use HasFactory, AsSource;

    public function scopeCompleteTransaction($query)
    {
        return $query->where('is_collected', true);
    }

    public function scopeInCompleteTransaction($query)
    {
        return $query->where('is_collected', false);
    }

    public function scopeLandlordPayments($query)
    {
        return $query->where('landlord_id', Landlord::where('user_id', auth()->id())->value('id'));
    }

    public function scopeTenantPayments($query)
    {
        return $query->where('tenant_id', Tenant::where('user_id', auth()->id())->value('id'));
    }

    public function scopeNotDefaulted($query)
    {
        return $query->where('has_defualted', false);
    }

    public function landlord()
    {
        return $this->belongsTo(Landlord::class);
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
        return $this->belongsTo(Apartment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
