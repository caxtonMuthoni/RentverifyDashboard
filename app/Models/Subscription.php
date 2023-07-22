<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Subscription extends Model
{
    use HasFactory, AsSource;

    public function features()
    {
        return $this->hasMany(SubscriptionFeature::class);
    }
}
