<?php

namespace App\Orchid\Layouts;

use App\Models\Subscriber;
use App\Services\DateFormatService;
use Carbon\Carbon;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SubscriptionsListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'subscriptions';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('user.name', 'User'),
            TD::make('user.account_type', 'Account type'),
            TD::make('subscription.name', 'Package'),
            TD::make('subscription.price', 'Price')->render(function (Subscriber $subscriber) {
                return "KSH " . number_format($subscriber->subscription?->price, 2);
            }),
            TD::make('is_complete', 'Status')->render(function (Subscriber $subscriber) {
                return !$subscriber->is_active ? ' <div class="badge bg-danger">Expired</div>' : '<div class="badge bg-success">Active</div>';
            }),
            TD::make('', 'Created At')->render(function (Subscriber $subscriber) {
                $formatDateService = new DateFormatService($subscriber->created_at);
                return $formatDateService->dateFormat_dMYHis();
            }),
            TD::make('', 'Expires At')->render(function (Subscriber $subscriber) {
                $createdAT = new Carbon($subscriber->created_at);
                $expiresAt = $createdAT->addDays(30);
                $formatDateService = new DateFormatService($expiresAt);
                return $formatDateService->dateFormat_dMYHis();
            }),
        ];
    }
}
