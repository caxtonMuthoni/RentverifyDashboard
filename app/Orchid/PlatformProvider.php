<?php

declare(strict_types=1);

namespace App\Orchid;

use App\Models\ClearlanceReport;
use App\Models\Defaulter;
use App\Models\Dispute;
use App\Models\LeaseAgreement;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        return [
            Menu::make('Dashboard')
                ->icon('grid')
                ->route('platform.dashbord'),

            Menu::make('Landlords')
                ->icon('user')
                ->route('platform.landlords'),

            Menu::make('Tenants')
                ->icon('people')
                ->route('platform.tenants'),


            Menu::make('Apartments')
                ->icon('building')
                ->route('platform.apartments'),


            Menu::make('Rooms')
                ->icon('layers')
                ->route('platform.rooms'),

            Menu::make('Locations')
                ->icon('map')
                ->list([
                    Menu::make('Counties')
                        ->icon('circle_thin')
                        ->route('platform.counties'),

                    Menu::make('Places')
                        ->icon('circle_thin')
                        ->route('platform.places'),
                ]),

            Menu::make('Payments')
                ->icon('money')
                ->route('platform.payments'),

            Menu::make('Defaulters')
                ->icon('unfollow')
                ->badge(fn () => Defaulter::notPaid()->count(), Color::DANGER())
                ->route('platform.defaulters'),

            Menu::make('Lease Agreements')
                ->icon('book-open')
                ->route('platform.lease-agreements')
                ->badge(fn () => LeaseAgreement::where('is_approved', false)->count(), Color::DANGER()),

            Menu::make('Clearance Reports')
                ->icon('notebook')
                ->route('platform.clearance-reports')
                ->badge(fn () => ClearlanceReport::notProcessed()->count(), Color::DANGER()),


            Menu::make('Disputes')
                ->icon('support')
                ->badge(fn () => Dispute::where('is_solved', false)->count(), Color::WARNING())
                ->route('platform.disputes'),

            Menu::make('Billing & packages')
                ->icon('present')
                ->list([
                    Menu::make('Subscription packages')
                        ->icon('circle_thin')
                        ->route('platform.packages'),
                    Menu::make('Subscribers')
                        ->icon('circle_thin')
                        ->route('platform.subscriptions'),
                    Menu::make('Transactions')
                        ->icon('circle_thin')
                        ->route('platform.transactions'),
                ]),


            Menu::make(__('Users'))
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access rights')),

            Menu::make(__('Roles'))
                ->icon('lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles'),
        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make(__('Profile'))
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }
}
