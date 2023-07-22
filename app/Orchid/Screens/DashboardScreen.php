<?php

namespace App\Orchid\Screens;

use App\Models\Apartment;
use App\Models\Defaulter;
use App\Models\Payment;
use App\Models\Room;
use App\Models\TenantRoom;
use App\Orchid\Layouts\ApartmentsListLayout;
use App\Orchid\Layouts\DefaultersChart;
use App\Orchid\Layouts\Examples\ChartBarExample;
use App\Orchid\Layouts\Examples\ChartLineExample;
use App\Orchid\Layouts\PaymentsChart;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class DashboardScreen extends Screen
{
    /**
     * Fish text for the table.
     */
    public const TEXT_EXAMPLE = 'Lorem ipsum at sed ad fusce faucibus primis, potenti inceptos ad taciti nisi tristique
    urna etiam, primis ut lacus habitasse malesuada ut. Lectus aptent malesuada mattis ut etiam fusce nec sed viverra,
    semper mattis viverra malesuada quam metus vulputate torquent magna, lobortis nec nostra nibh sollicitudin
    erat in luctus.';

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $monthName = strtolower(Carbon::now()->format('F'));
        $current_year = date('Y');

        $rent_collected = Payment::where([['month', $monthName], ['year', $current_year], ['is_collected', true]])->sum('amount');
        $pending_rent = Payment::notDefaulted()->inCompleteTransaction()->sum('amount');
        $defaulters_count = Defaulter::where('has_paid', false)->count();
        $defaulters_amount = Defaulter::where('has_paid', false)->sum('amount');

        $tenants_count = TenantRoom::distinct('tenant_id')->count();
        $apartments_count = Apartment::count();
        $rooms_count = Room::count();
        $vaccant_rooms = Room::where('is_vaccant', true)->count();

        $payments = Payment::select('month', DB::raw('sum(amount) as total'))
            ->groupBy('month')
            ->where('created_at', '>=', now()->subMonths(7))->get();
        $paymentsMonths = [];
        $paymentsTotal = [];

        foreach ($payments as $detail) {
            array_push($paymentsMonths, ucwords($detail['month']));
            array_push($paymentsTotal, $detail['total']);
        }

        $defaultersTotals = Defaulter::select('month', DB::raw('sum(amount) as total'))
            ->groupBy('month')
            ->where('created_at', '>=', now()->subMonths(7))->get();
        $defaultersTotalMonths = [];
        $defaultersTotalTotal = [];

        foreach ($defaultersTotals as $detail) {
            array_push($defaultersTotalMonths, ucwords($detail['month']));
            array_push($defaultersTotalTotal, $detail['total']);
        }

        $defualtersCount = Defaulter::select('month', DB::raw('count(*) as total'))
            ->groupBy('month')
            ->where('created_at', '>=', now()->subMonths(7))->get();
        $defualtersCountMonths = [];
        $defualtersCountTotal = [];

        foreach ($defualtersCount as $detail) {
            array_push($defualtersCountMonths, ucwords($detail['month']));
            array_push($defualtersCountTotal, $detail['total']);
        }

        return [
            'metrics' => [
                'rent_collected' => ['value' => number_format($rent_collected)],
                'pending_rent' => ['value' => number_format($pending_rent)],
                'defaulters_count' => ['value' => number_format($defaulters_count)],
                'defaulters_amount' => number_format($defaulters_amount),
            ],

            'metrics2' => [
                'tenants_count' => ['value' => number_format($tenants_count)],
                'apartments_count' => ['value' => number_format($apartments_count)],
                'rooms_count' => ['value' => number_format($rooms_count)],
                'vaccant_rooms' => number_format($vaccant_rooms),
            ],


            'payments' => [[
                'values' => $paymentsTotal,
                'labels' => $paymentsMonths,
            ]],

            'defaulters' => [
                [
                    'values' => $defaultersTotalTotal,
                    'name' => 'Defaulted amount',
                    'labels' => $defaultersTotalMonths,
                ],
                [
                    'values' => $defualtersCountTotal,
                    'name' => 'Defaulters',
                    'labels' => $defualtersCountMonths,
                ]
            ],

            'apartments' => Apartment::with('image', 'landlord')->withCount('rooms')->latest()->take(15)->get(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Dashboard';
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'The administrators dashboard';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return string[]|\Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        $monthName = Carbon::now()->format('F');
        return [
            // Layout::metrics([
            //     'Total Sales'    => 'metrics.sales',
            //     'Landlords' => 'metrics.visitors',
            //     'Tenants' => 'metrics.orders',
            //     'Payments' => 'metrics.total',
            // ]),

            Layout::metrics([
                'Rent Collected (' . $monthName . ')' => 'metrics.rent_collected',
                'Pending payments' => 'metrics.pending_rent',
                'Defaulters' => 'metrics.defaulters_count',
                'Defauters amount' => 'metrics.defaulters_amount',
            ]),

            Layout::metrics([
                'Tenants' => 'metrics2.tenants_count',
                'Apartments' => 'metrics2.apartments_count',
                'Total rooms' => 'metrics2.rooms_count',
                'Vacant rooms' => 'metrics2.vaccant_rooms',
            ]),

            Layout::columns([
                PaymentsChart::make('payments', 'Last Payments Chart')
                    ->description('Payments trend for the last 7 months'),

                DefaultersChart::make('defaulters', 'Defualters Chart')
                    ->description('The defualters trend in the last 7 months'),
            ]),


            ApartmentsListLayout::class
        ];
    }

    /**
     * @param Request $request
     */
    public function showToast(Request $request): void
    {
        Toast::warning($request->get('toast', 'Hello, world! This is a toast message.'));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export()
    {
        return response()->streamDownload(function () {
            $csv = tap(fopen('php://output', 'wb'), function ($csv) {
                fputcsv($csv, ['header:col1', 'header:col2', 'header:col3']);
            });

            collect([
                ['row1:col1', 'row1:col2', 'row1:col3'],
                ['row2:col1', 'row2:col2', 'row2:col3'],
                ['row3:col1', 'row3:col2', 'row3:col3'],
            ])->each(function (array $row) use ($csv) {
                fputcsv($csv, $row);
            });

            return tap($csv, function ($csv) {
                fclose($csv);
            });
        }, 'File-name.csv');
    }
}
