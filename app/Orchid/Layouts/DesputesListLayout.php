<?php

namespace App\Orchid\Layouts;

use App\Models\Dispute;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class DesputesListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'disputes';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('tenant.first_name', 'Tenant firstname'),
            TD::make('tenant.sir_name', 'Tenant sirname'),
            TD::make('tenant.phone_number', 'Tenant phonenumber'),
            TD::make('room.apartment.name', 'Tenant Apartment'),
            TD::make('room.name', 'Tenant room'),
            TD::make('', 'Status')->render(function(Dispute $dispute) {
                return $dispute->is_solved ? '<div class="badge bg-success">Resolved</div>' : '<div class="badge bg-danger">Pending</div>';
            }),
        ];
    }
}
