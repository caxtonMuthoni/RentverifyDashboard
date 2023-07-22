<?php

namespace App\Orchid\Layouts;

use App\Models\ClearlanceReport;
use App\Services\DateFormatService;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class ClearanceReportListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'clearanceReports';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('tenant.first_name', 'Tenant First Name'),
            TD::make('tenant.sir_name', 'Tenant Last Name'),
            TD::make('room.apartment.name', 'Apartment Name'),
            TD::make('room.name', 'Room'),
            TD::make('', 'Request At')->render(function (ClearlanceReport $clearlanceReport) {
                $formatDateService = new DateFormatService($clearlanceReport->created_at);
                return $formatDateService->dateFormat_dMYHis();
            }),

            TD::make('', 'Status')->render(function (ClearlanceReport $clearlanceReport) {
                return $clearlanceReport->is_processed ? '<div class="badge bg-success">Approved</div>' : '<div class="badge bg-danger">Pending</div>';
            }),
            TD::make('', 'Download unsigned')->render(function (ClearlanceReport $clearlanceReport) {
                return Link::make('Download')
                    ->type(Color::PRIMARY())
                    ->icon('cloud-download')
                    ->target('_blank')
                    ->href($clearlanceReport->unsigned_url);
            }),
        ];
    }
}
