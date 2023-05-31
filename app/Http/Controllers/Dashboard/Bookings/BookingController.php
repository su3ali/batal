<?php

namespace App\Http\Controllers\Dashboard\Bookings;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingStatus;
use App\Models\CategoryGroup;
use App\Models\Contract;
use App\Models\ContractPackage;
use App\Models\Group;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use App\Models\VisitsStatus;
use Carbon\Carbon;
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
            $bookings = Booking::query()->groupBy('bookings.category_id')->where('type','service')->with(['order', 'customer', 'service', 'group', 'booking_status'])->get();

            if (\request()->query('type') == 'package'){
                $bookings = Booking::query()->where('type','contract')->with(['order', 'customer', 'service', 'group', 'booking_status'])->get();
            }

            return DataTables::of($bookings)
                ->addColumn('order', function ($row) {
                    $order = $row->order?->id;
                    if (\request()->query('type') == 'package') {
                        $order = $row->contract?->id;
                    }
                    return $order;
                })
                ->addColumn('customer', function ($row) {
                    return $row->customer?->first_name . ' ' . $row->customer?->last_name;
                })
                ->addColumn('customer_phone', function ($row) {
                    return $row->customer?->phone;
                })
                ->addColumn('service', function ($row) {

                    $service = $book->service?->title;

                    if (\request()->query('type') == 'package'){
                        $service = $row->package?->name;
                    }

                    return $service;

                })
                ->addColumn('time', function ($row) {
                    return Carbon::createFromTimestamp($row->time)->toTimeString();
                })
                ->addColumn('group', function ($row) {
                    return $row->group?->name;
                })
                ->addColumn('status', function ($row) {
                    return $row->booking_status?->name;
                })
                ->addColumn('control', function ($row) {
                    $data = $row->service_id;
                    if (\request()->query('type') == 'package'){
                        $data = $row->package_id;
                    }

                    $html = '

                        <button type="button" id="add-work-exp" class="btn btn-sm btn-primary card-tools edit" data-id="' . $row->id . '"  data-service_id="' . $data . '" data-type="'.\request()->query('type').'"
                                  data-toggle="modal" data-target="#addGroupModel">
                            اضافة فريق
                       </button>
                                <a data-table_id="html5-extension" data-href="' . route('dashboard.bookings.destroy', $row->id) . '" data-id="' . $row->id . '" class="mr-2 btn btn-outline-danger btn-sm btn-delete btn-sm delete_tech">
                            <i class="far fa-trash-alt fa-2x"></i>
                    </a>';
                    return $html;
                })
                ->rawColumns([
                    'order',
                    'customer',
                    'customer_phone',
                    'service',
                    'group',
                    'status',
                    'control'
                ])
                ->make(true);
        }
        $visitsStatuses = VisitsStatus::query()->get()->pluck('name','id');

        return view('dashboard.bookings.index',compact('visitsStatuses'));
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
        $last = Booking::query()->latest()->first()?->id;
        $validated['booking_no'] = 'dash2023/'.$last?$last+1: 1;
        Booking::query()->create($validated);
        session()->flash('success');
        return redirect()->route('dashboard.bookings.index');
    }

    protected function edit($id){
        $booking = Booking::query()->where('id', $id)->first();
        $orders = Order::all();
        $customers = User::all();
        $services = Service::all();
        $groups = Group::all();
        $statuses = BookingStatus::all();
        return view('dashboard.bookings.edit', compact('booking','orders', 'customers', 'services', 'groups', 'statuses'));

    }
    protected function update(Request $request, $id)
    {
        $inputs = $request->only('order_id', 'user_id', 'service_id', 'group_id', 'date', 'notes', 'booking_status_id');
        $inputs['time'] = Carbon::parse($request->time)->format('H:i');
        $booking = Booking::query()->where('id', $id)->first();
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
        $validated = Validator::make($inputs, $rules);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated->errors());
        }
        $validated = $validated->validated();
        $booking->update($validated);
        session()->flash('success');
        return redirect()->route('dashboard.bookings.index');
    }

    protected function destroy($id)
    {
        $booking = Booking::query()->find($id);
        $booking->delete();
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


    protected function getGroupByService(Request $request)
    {



        if ($request->type =='package'){

            $package = ContractPackage::where('id',$request->service_id)->first();

            $service= Service::where('id',$package->service_id)->first('category_id');

            $groupIds = CategoryGroup::where('category_id',$service->category_id)->pluck('group_id')->toArray();

            $group = Group::whereIn('id',$groupIds)->get()->pluck('name','id')->toArray();
        }else{
            $service= Service::where('id',$request->service_id)->first('category_id');

            $groupIds = CategoryGroup::where('category_id',$service->category_id)->pluck('group_id')->toArray();

            $group = Group::whereIn('id',$groupIds)->get()->pluck('name','id')->toArray();
        }

        return response($group);

    }

}
