<?php

namespace App\Imports;

use App\Models\County;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CountyImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $countyTitle = trim(ucfirst(strtolower($row['county'])));
            // Create county
            $county = County::updateOrCreate(["title" => $countyTitle], ["title" => $countyTitle]);
        }
    }
}
