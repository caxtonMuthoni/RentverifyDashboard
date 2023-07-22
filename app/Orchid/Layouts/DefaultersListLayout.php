<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class DefaultersListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'defaulters';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('month', 'Month'),
            TD::make('tenant.first_name', 'Tenant First Name'),
            TD::make('tenant.sir_name', 'Tenant Last Name'),
            TD::make('amount', 'Amount'),
            TD::make('apartment.name', 'Apartment'),
            TD::make('room.name', 'Room'),
        ];
    }
}
