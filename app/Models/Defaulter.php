<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Defaulter extends Model
{
    use HasFactory, AsSource;

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

    public function scopeLandlordDefaulter($query)
    {
        return $query->where('landlord_id', Landlord::where('user_id', auth()->id())->value('id'));
    }

    public function scopeNotPaid($query)
    {
        return $query->where('has_paid', false);
    }
}
