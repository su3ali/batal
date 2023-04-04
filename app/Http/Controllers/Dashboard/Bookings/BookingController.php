<?php

namespace App\Http\Controllers\Dashboard\Bookings;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingStatus;
use App\Models\Group;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\ValidationException;


class BookingController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            $bookings = Booking::query()->with(['order', 'customer', 'service', 'group', 'booking_status'])->get();
            return DataTables::of($bookings)
                ->addColumn('order', function ($row) {
                    return $row->order?->id;
                })
                ->addColumn('customer', function ($row) {
                    return $row->customer?->name;
                })
                ->addColumn('service', function ($row) {
                    return $row->service?->title;
                })
                ->addColumn('group', function ($row) {
                    return $row->group?->name;
                })
                ->addColumn('status', function ($row) {
                    return $row->booking_status?->name;
                })
                ->addColumn('control', function ($row) {
                    $html = '
                    <button type="button" id="edit-booking" class="btn btn-primary btn-sm card-tools edit" data-id="' . $row->id . '"
                          >
                            <i class="far fa-edit fa-2x"></i>
                       </button>

                                <a data-table_id="html5-extension" data-href="' . route('dashboard.booking_statuses.destroy', $row->id) . '" data-id="' . $row->id . '" class="mr-2 btn btn-outline-danger btn-sm btn-delete btn-sm delete_tech">
                            <i class="far fa-trash-alt fa-2x"></i>
                    </a>';
                    return $html;
                })
                ->rawColumns([
                    'order',
                    'customer',
                    'service',
                    'group',
                    'status',
                    'control'
                ])
                ->make(true);
        }

        return view('dashboard.bookings.index');
    }

    protected function create()
    {
        $orders = Order::all();
        $customers = User::all();
        $services = Service::all();
        $groups = Group::all();
        $statuses = BookingStatus::all();
        return view('dashboard.bookings.create', compact('orders', 'customers', 'services', 'groups', 'statuses'));
    }

    /**
     * @throws ValidationException
     */
    protected function store(Request $request): RedirectResponse
    {
        $rules = [
            'order_id' => 'required|exists:orders,id',
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'group_id' => 'required|exists:groups,id',
            'booking_status_id' => 'required|exists:booking_statuses,id',
            'notes' => 'nullable|String',
            'date' => 'required|Date',
            'time' => 'required|date_format:H:i',
        ];
        $validated = Validator::make($request->all(), $rules);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated->errors());
        }
        $validated = $validated->validated();
        $last = Booking::query()->latest()->first()->id;
        $validated['booking_no'] = 'dash2023/'.$last+1;
        Booking::query()->create($validated);
        session()->flash('success');
        return redirect()->route('dashboard.bookings.index');
    }

    protected function update(Request $request, $id)
    {
        $bookingStatus = BookingStatus::query()->where('id', $id)->first();
        $rules = [
            'name_ar' => 'required|unique:order_statuses,name_ar,' . $id,
            'name_en' => 'required|unique:order_statuses,name_en,' . $id,
            'description_ar' => 'nullable|String',
            'description_en' => 'nullable|String',
        ];
        $validated = Validator::make($request->all(), $rules);
        if ($validated->fails()) {
            return redirect()->back()->with('errors', $validated->errors());
        }
        $validated = $validated->validated();
        $bookingStatus->update($validated);
        session()->flash('success');
        return redirect()->back();
    }

    protected function destroy($id)
    {
        $bookingStatus = BookingStatus::find($id);
        if (in_array($id, Booking::query()->pluck('booking_status_id')->toArray())) {
            return response()->json(['success' => false,
                'msg' => 'حذف الحالة غير متاح لارتباطها بطلب'
            ]);
        }
        $bookingStatus->delete();
        return [
            'success' => true,
            'msg' => __("dash.deleted_success")
        ];
    }

    protected function change_status(Request $request)
    {
        $bookingStatus = BookingStatus::query()->where('id', $request->id)->first();
        if ($request->active == "false") {
            $bookingStatus->active = 0;
        } else {
            $bookingStatus->active = 1;
        }
        $bookingStatus->save();
        return response('success');
    }

}
