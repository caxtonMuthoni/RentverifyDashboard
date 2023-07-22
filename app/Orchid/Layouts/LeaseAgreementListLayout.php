<?php

namespace App\Orchid\Layouts;

use App\Models\LeaseAgreement;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class LeaseAgreementListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'leaseAgreements';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('_', 'Tenant')
                ->render(fn (LeaseAgreement $leaseAgreement) => $leaseAgreement->tenant->first_name . ' ' . $leaseAgreement->tenant->sir_name),
            TD::make('room.apartment.name', 'Apartmment'),
            TD::make('room.name', 'Room'),
            TD::make('', 'Status')->render(function (LeaseAgreement $leaseAgreement) {
                return $leaseAgreement->is_approved ? '<div class="badge bg-success">Approved</div>' : '<div class="badge bg-danger">Pending</div>';
            }),

            TD::make('', 'Action')->render(function (LeaseAgreement $leaseAgreement) {
                return Link::make('Download')
                    ->type(Color::PRIMARY())
                    ->icon('cloud-download')
                    ->target('_blank')
                    ->href($leaseAgreement->unsigned_url);
            })
        ];
    }
}
