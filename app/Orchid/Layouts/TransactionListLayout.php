<?php

namespace App\Orchid\Layouts;

use App\Models\Transaction;
use App\Services\DateFormatService;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class TransactionListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'transactions';

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
            TD::make('transaction_id', 'TransactionID'),
            TD::make('type', 'Transaction Type'),
            TD::make('amount', 'Amount'),
            TD::make('subscription.name', 'Package'),
            TD::make('is_complete', 'Status')->render(function (Transaction $transaction) {
                return !$transaction->is_complete ? ' <div class="badge bg-danger">Unprocessed</div>' : '<div class="badge bg-success">Processed</div>';
            }),
            TD::make('result', 'Result'),
            TD::make('', 'Created At')->render(function (Transaction $transaction) {
                $formatDateService = new DateFormatService($transaction->created_at);
                return $formatDateService->dateFormat_dMYHis();
            }),
        ];
    }
}
