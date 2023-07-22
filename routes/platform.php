<?php

declare(strict_types=1);

use App\Orchid\Screens\ApartmentsScreen;
use App\Orchid\Screens\ClearanceReportsScreen;
use App\Orchid\Screens\CountiesScreen;
use App\Orchid\Screens\DashboardScreen;
use App\Orchid\Screens\DefaultersScreen;
use App\Orchid\Screens\DisputesScreen;
use App\Orchid\Screens\EditSubscriptionPackageScreen;
use App\Orchid\Screens\LandlordsScreen;
use App\Orchid\Screens\LeaseAgreementsScreen;
use App\Orchid\Screens\PaymentsScreen;
use App\Orchid\Screens\PlacesScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\RoomsScreen;
use App\Orchid\Screens\SubscriptionFeaturesScreen;
use App\Orchid\Screens\SubscriptionPackagesScreen;
use App\Orchid\Screens\TenantDetailsScreen;
use App\Orchid\Screens\TenantsScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn (Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Users'), route('platform.systems.users')));

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn (Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Roles'), route('platform.systems.roles')));


Route::screen('/dashbord', DashboardScreen::class)->name('platform.dashbord');
Route::screen('/landlords', LandlordsScreen::class)->name('platform.landlords');
Route::screen('/tenants', TenantsScreen::class)->name('platform.tenants');
Route::screen('/tenant/{tenant}', TenantDetailsScreen::class)->name('platform.tenant-details');
Route::screen('/apartments', ApartmentsScreen::class)->name('platform.apartments');
Route::screen('/rooms', RoomsScreen::class)->name('platform.rooms');
Route::screen('/payments', PaymentsScreen::class)->name('platform.payments');
Route::screen('/defaulters', DefaultersScreen::class)->name('platform.defaulters');
Route::screen('/lease/agreements', LeaseAgreementsScreen::class)->name('platform.lease-agreements');
Route::screen('/clearance/reports', ClearanceReportsScreen::class)->name('platform.clearance-reports');
Route::screen('/disputes', DisputesScreen::class)->name('platform.disputes');

Route::screen('/counties', CountiesScreen::class)->name('platform.counties');
Route::screen('/places', PlacesScreen::class)->name('platform.places');
// Route::screen('/disputes', DisputesScreen::class)->name('platform.disputes');

Route::screen('/subscriptions', SubscriptionPackagesScreen::class)->name('platform.packages');
Route::screen('/subscription/{package?}', EditSubscriptionPackageScreen::class)->name('platform.package-edit');
Route::screen('/features/subscription/{package?}', SubscriptionFeaturesScreen::class)->name('platform.package-features');
