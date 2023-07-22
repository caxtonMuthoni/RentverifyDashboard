<?php

namespace App\Orchid\Layouts;

use App\Models\Room;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class RoomsListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'rooms';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('string_code', 'Room Code'),
            TD::make('name', 'Room name'),
            TD::make('apartment.name', 'Apartment'),
            TD::make('room_type.name', 'Room type'),
            TD::make('price', 'Room price (KSH)'),
            TD::make('is_vaccant', 'Room status')->render(function(Room $room) {
                return $room->is_vaccant ?' <div class="badge bg-danger">vaccant</div>' : '<div class="badge bg-success">occupied</div>';
            }),
        ];
    }
}
