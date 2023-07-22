<?php

namespace App\Orchid\Layouts;

use App\Models\TenantRoom;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class TenantsListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'tenants';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('tenant.first_name', 'First name'),
            TD::make('tenant.sir_name', 'Last name'),
            TD::make('tenant.national_id', 'National ID'),
            TD::make('tenant.phone_number', 'Phonenumber'),
            TD::make('room.name', 'Room'),
            TD::make('room.apartment.name', 'Apartment'),
            TD::make('', 'Action')->render(function (TenantRoom $tenantRoom) {
                return Link::make('View')->icon('notebook')->route('platform.tenant-details', $tenantRoom->tenant->id)->type(Color::PRIMARY());
            })
        ];
    }
}
