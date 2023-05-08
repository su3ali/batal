<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingSetting;
use App\Models\Category;
use App\Models\City;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use App\Traits\schedulesTrait;
use Carbon\CarbonInterval;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;


class OrderController extends Controller
{
    use schedulesTrait;
    public function index()
    {

        if (request()->ajax()) {
            $orders = Order::all();
            return DataTables::of($orders)
                ->addColumn('user', function ($row) {
                    return $row->user?->first_name .' ' . $row->user?->last_name;
                })
                ->addColumn('service', function ($row) {
                    return $row->service?->title;
                })
                ->addColumn('control', function ($row) {

                    $html = '


                                <a data-table_id="html5-extension" data-href="'.route('dashboard.orders.destroy', $row->id).'" data-id="' . $row->id . '" class="mr-2 btn btn-outline-danger btn-sm btn-delete btn-sm delete_tech">
                            <i class="far fa-trash-alt fa-2x"></i>
                    </a>
                                ';

                    return $html;
                })
                ->rawColumns([
                    'user',
                    'service',
                    'day',
                    'start_time',
                    'status',
                    'control',
                ])
                ->make(true);
        }

        return view('dashboard.orders.index');
    }


    public function create()
    {
        $users = User::all();
        $categories = Category::all();
        $services = Service::all();

        $cities = City::where('active',1)->get()->pluck('title','id');

        return view('dashboard.orders.create', compact('users','cities', 'categories', 'services'));
    }


    /**
     * @throws ValidationException
     */
    protected function store(Request $request): RedirectResponse
    {
        $rules = [
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'price' => 'required|Numeric',
            'payment_method' => 'required|in:visa,cache',
            'notes' => 'nullable|String',
            'quantity' => 'required|Numeric',
            'day' => 'required',
            'start_time' => 'required'
        ];
        $validated = Validator::make($request->all(), $rules);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated->errors());
        }


        $data = [
            'user_id' => $request->user_id,
            'service_id' => $request->service_id,
            'price' => $request->price,
            'status_id' => 1,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
            'quantity' => $request->quantity,
        ];


        $order = Order::query()->create($data);
        $last = Booking::query()->latest()->first()?->id;
        $booking_no = 'dash2023/'.$last?$last+1: 1;
        $booking = [
            'booking_no' => $booking_no,
            'user_id' => $request->user_id,
            'service_id' => $request->service_id,
            'order_id' => $order->id,
            'booking_status_id' => 1,
            'notes' => $request->notes,
            'quantity' => $request->quantity,
            'date' => $request->day,
            'time' => Carbon::createFromTimestamp($request->start_time)->toTimeString(),
        ];

        Booking::query()->create($booking);

        session()->flash('success');
        return redirect()->back();
    }

    public function edit($id)
    {
        $order = Order::where('id',$id)->first();
        $users = User::all();
        $categories = Category::all();
        $services = Service::all();
        return view('dashboard.core.services.edit', compact( 'order','users','services','categories'));
    }

    protected function update(Request $request, $id){
        $order = Order::query()->where('id', $id)->first();
        $rules = [
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'service_id' => 'required|exists:services,id',
            'price' => 'required|Numeric',
            'payment_method' => 'required|in:visa,cache',
            'notes' => 'nullable|String'
        ];
        $validated = Validator::make($request->all(), $rules);
        if ($validated->fails()) {
            return redirect()->back()->with('errors', $validated->errors());
        }
        $validated = $validated->validated();
        $order->update($validated);
        session()->flash('success');
        return redirect()->back();
    }

    protected function destroy($id)
    {
        $order = Order::find($id);
        $order->delete();
        return [
            'success' => true,
            'msg' => __("dash.deleted_success")
        ];
    }

    protected function customerStore(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|numeric|unique:users,phone',
            'password' => ['required', 'confirmed', Password::min(4)],
            'city_id' => 'required|exists:cities,id',
        ]);

        $data=$request->except('_token','password_confirmation');

        $customer = User::query()->create($data);

        session()->flash('success');
        return [
            'success' => true,
            'data' =>$customer,
            'msg' => __("dash.operation_success")
        ];
    }

    protected function autoCompleteCustomer(Request $request)
    {
        $customers = [];
        if ($request->has('q')) {

            $search = $request->q;
            $customers = User::where('email', 'LIKE', "%$search%")
                ->orWhere('last_name', 'LIKE', "%$search%")
                ->orWhere('first_name', 'LIKE', "%$search%")
                ->get();

        }

            return response()->json($customers);

    }

    protected function autoCompleteService(Request $request)
    {
        $services = [];
        if ($request->has('q')) {

            $search = $request->q;
            if (app()->getLocale() == 'ar'){
                $services = Service::where('title_ar', 'LIKE', "%$search%")->get();

            }else{
                $services = Service::where('title_en', 'LIKE', "%$search%")->get();
            }

        }

        return response()->json($services);

    }

    protected function getServiceById(Request $request)
    {
        $service = Service::where('id',$request->service_id)->first();

        return response()->json($service);

    }


    protected function getAvailableTime(Request $request)
    {
        $day = Carbon::parse($request->date)->locale('en')->dayName;

        $bookSetting = BookingSetting::where('service_id', $request->id)->first();

        $get_time = $this->getTime($day,$bookSetting);

        $times = [];
        if($get_time == true){
            $times = CarbonInterval::minutes($bookSetting->service_duration + $bookSetting->buffering_time)
                ->toPeriod(
                    \Carbon\Carbon::now()->setTimeFrom($bookSetting->service_start_time ?? Carbon::now()->startOfDay()),
                    Carbon::now()->setTimeFrom($bookSetting->service_end_time ?? Carbon::now()->endOfDay())
                );
        }

        $notAvailable = Booking::where('service_id',$request->id)->where('date',$request->date)->where('booking_status_id', 1)->get();

        $service = Service::where('id',$request->id)->first();

        return view('dashboard.orders.schedules-times-available', compact('times','notAvailable','service'));
    }

}
