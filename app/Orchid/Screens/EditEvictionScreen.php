<?php

namespace App\Orchid\Screens\Landlord;

use App\Models\Eviction;
use App\Models\Landlord;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\TenantRoom;
use App\Orchid\Layouts\TenantEvictionLister;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class EditEvictionScreen extends Screen
{
    private $exists = false;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Eviction $eviction): iterable
    {
        $eviction->load('tenant', 'tenant_room.room');
        $this->exists = $eviction->exists;
        return [
            'eviction' => $eviction,
            'tenant_id' => $eviction?->tenant_id,
            'tenant' => $eviction?->tenant,
            'tenant_room_id' => $eviction?->tenant_room_id,
            'room' => $eviction?->tenant_room,
            'reason' => $eviction->reason,
            'unpaid_rent' => $eviction->unpaid_rent,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->exists ? 'Edit eviction' : 'Create new eviction';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Evict')
                ->type(Color::SUCCESS())
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make('Remove')
                ->type(Color::DANGER())
                ->icon('trash')
                ->method('remove')
                ->canSee($this->exists),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            TenantEvictionLister::class
        ];
    }

    public function asyncGetTenant($tenant_id, $tenant_room_id)
    {
        return [
            'tenant_id' => $tenant_id,
            'tenant' => Tenant::find($tenant_id),
            'tenant_room_id' => $tenant_room_id,
            'room' => TenantRoom::with('room.apartment')->find($tenant_room_id)
        ];
    }


    public function createOrUpdate(Request $request, Eviction $eviction)
    {
        $this->validate($request, [
            'tenant_id' => 'required',
            // 'tenant_room_id' => 'required',
            'reason' => 'required | string | max:500',
        ]);


        $eviction = Eviction::where([['tenant_id', $request->tenant_id], ['tenant_room_id', $request->tenant_room_id]])->first();
        if (!isset($eviction)) {
            $eviction = new Eviction();
        }

        if (isset($request->tenant_room_id)) {
            $eviction->tenant_room_id = $request->tenant_room_id;
        }
        $eviction->tenant_id = $request->tenant_id;
        $eviction->reason = $request->reason;
        $eviction->landlord_id = Landlord::where('user_id', auth()->id())->value('id');
        $eviction->unpaid_rent = $request->unpaid_rent;
        $eviction->save();

        // Clear the room empty
        $tenantRoom = TenantRoom::with('room')->find($eviction->tenant_room_id);
        if (isset($tenantRoom)) {
            if ($tenantRoom?->room) {
                $room = Room::find($tenantRoom->room_id);
                $room->is_vaccant = true;
                $room->save();
            }
            $tenantRoom->is_active = false;
            $tenantRoom->save();
        }



        Alert::success('The eviction was processed successfully!');
        return redirect()->route('landlord-evictions');
    }


    public function remove(Eviction $eviction)
    {
        $eviction->delete();
        Alert::success('The eviction was deleted successfully!');
        return redirect()->route('landlord-evictions');
    }
}
