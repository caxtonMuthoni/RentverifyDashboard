<?php

namespace App\Imports;

use App\Models\County;
use App\Models\Place;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class PlaceImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        try {

            foreach ($rows as $row) {
                $countyName = $row['county'];
                $county = County::where('title', $countyName)->first();
                if (isset($county)) {
                    $latitude = $row['latitude'];
                    $longitude = $row['longitude'];
                    $place = Place::where([['latitude', $latitude], ['longitude', $longitude]])->first();
                    if (!isset($place)) {
                        $place = new Place();
                        $place->title = $row['title'];
                        $place->county_id = $county->id;
                        $place->latitude = $latitude;
                        $place->longitude = $longitude;
                        $place->save();
                    }
                } else {
                    throw new Exception('County ' . $countyName . '  does not exist.');
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
