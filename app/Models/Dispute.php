<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Dispute extends Model
{
    use HasFactory, AsSource;

    public function scopeLandlordDisputes($query)
    {
        return $query->where('landlord_id', Landlord::where('user_id', auth()->id())->value('id'));
    }

    public function scopeTenantDisputes($query)
    {
        return $query->where('tenant_id', Tenant::where('user_id', auth()->id())->value('id'));
    }


    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function landlord()
    {
        return $this->belongsTo(Landlord::class);
    }
}
