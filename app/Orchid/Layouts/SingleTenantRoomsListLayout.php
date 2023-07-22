<?php

namespace App\Orchid\Layouts;

use App\Models\TenantRoom;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SingleTenantRoomsListLayout extends Table
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
            TD::make('room.name', 'Room'),
            TD::make('room.apartment.name', 'Apartment'),
            TD::make('landlord.name', 'Landlord'),
            TD::make('status', 'Joined On')->render(function (TenantRoom $tenantRoom) {
                return $tenantRoom->created_at;
            }),
        ];
    }

    protected function textNotFound(): string
    {
        return __('The tenant don\'t have active houses');
    }
}
