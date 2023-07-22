<?php

namespace App\Orchid\Layouts;

use App\Models\Defaulter;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SingleTenantDefaultedPaymentsListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'defaults';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {

        return [
            TD::make('room.name', 'Room'),
            TD::make('apartment.name', 'Apartment'),
            TD::make('landlord.name', 'Landlord'),
            TD::make('status', 'Defualted At')->render(function (Defaulter $defaulter) {
                return $defaulter->created_at;
            }),
            TD::make('status', 'Status')->render(function (Defaulter $defaulter) {
                return $defaulter->has_paid ? '<div class="badge bg-success">paid</div>' : '<div class="badge bg-danger">Not paid</div>';
            }),
            TD::make('status', 'Paid At')->render(function (Defaulter $defaulter) {
                return $defaulter->paid_at;
            })
        ];
    }

    protected function textNotFound(): string
    {
        return __('The tenant has never defaulted any rent payment');
    }
}
