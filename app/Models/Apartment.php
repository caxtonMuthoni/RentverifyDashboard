<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Apartment extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $fillable = [
        'name',
        'location',
        'description',
        'user_id',
        'landlord_id',
        'image_id',
    ];

    protected $appends = ['string_code'];

    public function scopeLandlordApartments($query)
    {
        return $query->where('landlord_id', Landlord::where('user_id', auth()->id())->value('id'));
    }


    protected function stringCode(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn ($value) =>  'APT-' . $value
        );
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
