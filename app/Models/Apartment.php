<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Apartment extends Model
{
    use HasFactory, AsSource;

    protected $fillable = [
        'name',
        'location',
        'description',
        'user_id',
        'landlord_id',
        'image_id',
    ];

    public function scopeLandlordApartments($query)
    {
        return $query->where('landlord_id', Landlord::where('user_id', auth()->id())->value('id'));
    }

    public function image()
    {
        return $this->hasOne(Attachment::class, 'id', 'image_id')->withDefault();
    }

    public function images()
    {
        return $this->hasMany(Attachment::class, 'id', 'image_id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function landlord()
    {
        return $this->belongsTo(Landlord::class);
    }
}
