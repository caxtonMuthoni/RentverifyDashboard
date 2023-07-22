<?php

namespace App\Services;

use Carbon\Carbon;

class DateFormatService
{
    public $date;

    public function __construct($date)
    {
        $this->date = $date;
    }

    public function dateFormat_dMYHis()
    {
        $createdAt = Carbon::parse($this->date);
        return $createdAt->format('d M, Y H:i:s');
    }

    public function dateFormat_dMY()
    {
        $createdAt = Carbon::parse($this->date);
        return $createdAt->format('d M, Y');
    }
}
