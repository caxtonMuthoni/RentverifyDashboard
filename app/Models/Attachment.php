<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Models\Attachment as OrchidAttachment;

class Attachment extends OrchidAttachment
{
    use HasFactory;

    public function getUrlAttribute(): ?string
    {
        $url = env('BASE_APP_URL') . '/storage/' . $this->physicalPath();
        return $url;
    }
}
