<?php

namespace App\Orchid\Layouts;

use App\Models\Apartment;
use App\Models\Room;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ApartmentsListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'apartments';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'Image')
                ->width('150')
                ->render(function (Apartment $apartment) {
                    $url = $apartment->image?->url ? $apartment->image?->url : 'https://s.gravatar.com/avatar/e42bafdc0b76671537f94040a959a7b80846048e1ca662b93765a6383ac9170b?s=80';
                    return   "<img src='{$url}'
                alt='sample'
                style='height:70px; width:auto; margin: 0 auto;'
                class='mw-100 d-block img-fluid rounded-1'>";
                }),
            TD::make('name', 'Apartment Name'),
            TD::make('location', 'Apartment Location'),
            TD::make('rooms_count', 'Total rooms'),
            TD::make('landlord.name', 'Owned By')
        ];
    }
}

Room::where('apartment_id', 1)->chunk(100, function ($rooms) {
    foreach ($rooms as $room) {
        $room->landlord_id = 1;
        $room->save();
    }
});
