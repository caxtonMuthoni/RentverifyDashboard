<?php

namespace App\Services;

use App\Models\Apartment;
use App\Models\Room;

class CodeGeneratorService
{
    public static function getApartmentCode(Apartment $apartment)
    {
        $code = $apartment->code;
        if (!$code) {
            $code = Apartment::max('code') + 1;
            if ($code < 1000) {
                $code = 1000;
            }
        }

        return $code;
    }

    public static function getRoomCode(Room $room)
    {
        $code = $room->code;
        if (!$code) {
            $code = Room::max('code') + 1;
            if ($code < 1000) {
                $code = 1000;
            }
        }

        return $code;
    }
}
