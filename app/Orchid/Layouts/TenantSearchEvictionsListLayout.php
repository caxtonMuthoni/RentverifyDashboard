<?php

namespace App\Orchid\Layouts\Landlord;

use App\Models\Eviction;
use App\Services\DateFormatService;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class TenantSearchEvictionsListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'evictions';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('tenant_room.room.apartment.name', 'Apartment'),
            TD::make('tenant_room.room.name', 'Room'),
            TD::make('unpaid_rent', 'Unpaid amount'),
            TD::make('reason', 'Eviction Reason'),
            TD::make('', 'Evicted At')->render(function (Eviction $eviction) {
                $formatDateService = new DateFormatService($eviction->created_at);
                return $formatDateService->dateFormat_dMYHis();
            }),
        ];
    }

    protected function textNotFound(): string
    {
        return __('The tenant has never been evicted');
    }
}
