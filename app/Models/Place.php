<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Place extends Model
{
    use HasFactory, AsSource;

    public function county()
    {
        return $this->belongsTo(County::class);
    }
}
