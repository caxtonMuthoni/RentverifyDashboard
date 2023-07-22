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
        $path = $this->physicalPath();
        if ($path) {
            $url = env('BASE_APP_URL') . '/storage/' . $path;
            return $url;
        }

        return '';
    }
}
