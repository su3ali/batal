<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingSetting;
use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\City;
use App\Models\Group;
use App\Models\Order;
use App\Models\OrderService;
use App\Models\Service;
use App\Models\User;
use App\Models\UserAddresses;
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
                ->addColumn('category', function ($row) {
                    $qu = OrderService::where('order_id',$row->id)->get()->pluck('category_id')->toArray();
                    $cat_ids = array_unique($qu);
                    $categorys = Category::whereIn('id',$cat_ids)->get();
                    $html ='';
                    foreach ($categorys as $category){
                        $html.='<button class="btn-sm btn-primary">'.$category->title.'</button>' ;
                    }

                    return $html;
                })
                ->addColumn('quantity', function ($row) {
                    $qu = OrderService::where('order_id',$row->id)->get()->pluck('quantity')->toArray();

                    return array_sum($qu);
                })
                ->addColumn('status', function ($row) {
                    return $row->status?->name;
                })
                ->addColumn('control', function ($row) {

                    $html = '';
                    if ($row->status_id == 2){
                        $html .= '<a href="' . route('dashboard.order.confirmOrder','id='.$row->id) . '" class="mr-2 btn btn-outline-primary btn-sm">
                            <i class="far fa-thumbs-up fa-2x mx-1"></i> تأكيد
                        </a>';
                    }
                    $html .= '
                        <a href="' . route('dashboard.order.showService','id='.$row->id) . '" class="mr-2 btn btn-outline-primary btn-sm">
                            <i class="far fa-eye fa-2x"></i>
                        </a>
                                <a data-table_id="html5-extension" data-href="'.route('dashboard.orders.destroy', $row->id).'" data-id="' . $row->id . '" class="mr-2 btn btn-outline-danger btn-sm btn-delete btn-sm delete_tech">
                            <i class="far fa-trash-alt fa-2x"></i>
                    </a>
                                ';

                    return $html;
                })
                ->rawColumns([
                    'user',
                    'category',
                    'quantity',
                    'status',
                    'control',
                ])
                ->make(true);
        }

        return view('dashboard.orders.index');
    }

    public function showService()
    {

        if (request()->ajax()) {

            $orders = OrderService::where('order_id',request()->query('id'))->get();
            return DataTables::of($orders)
                ->addColumn('service', function ($row) {
                    return $row->service?->title;
                })
                ->addColumn('quantity', function ($row) {
                    return $row->quantity;
                })
                ->addColumn('price', function ($row) {
                    return $row->price;
                })

                ->rawColumns([
                    'service',
                    'quantity',
                    'price',
                ])
                ->make(true);
        }

        return view('dashboard.orders.showService');
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
            'service_id' => 'array|required|exists:services,id',
            'service_id.*' => 'required',
            'price' => 'required',
            'payment_method' => 'required|in:visa,cache',
            'notes' => 'nullable|String',
            'quantity' => 'array|required',
            'quantity.*' => 'required',
            'day' => 'array|required',
            'day.*' => 'required',
            'start_time' => 'array|required',
            'start_time.*' => 'required',
            'total' => 'required',
            'all_quantity' => 'required',
        ];
        $validated = Validator::make($request->all(), $rules);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated->errors());
        }
dd($request->all());
        $data = [
            'user_id' => $request->user_id,
            'total' => $request->sub_total ?? 0,
            'sub_total' => $request->total,
            'discount' => 0,
            'status_id' => 1,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
            'quantity' => $request->all_quantity,
            'user_address_id' => UserAddresses::where('user_id',$request->user_id)->where('is_default',1)->first()->id,

        ];

        $order = Order::query()->create($data);
        foreach ($request->service_id as $key => $service_id) {
            $service = Service::where('id',$request->service_id)->first('category_id');
            $order_service = [
                'order_id' => $order->id,
                'service_id' => $service_id,
                'price' => $request->price[$key],
                'quantity' => $request->quantity[$key],
                'category_id' => $service->category_id,
            ];

            OrderService::create($order_service);
        }
//        $category_ids = Service::whereIn('id',$request->service_id)->get()->pluck('category_id');
        $category_ids = array_unique($request->category_id);
        foreach ($category_ids as $key => $category_id) {
            $last = Booking::query()->latest()->first()?->id;
            $booking_no = 'dash2023/' . $last ? $last + 1 : 1;

            foreach (Service::with('BookingSetting')->whereIn('id', $request->service_id)->get() as $service){
                $serviceMinutes = ($service->BookingSetting->buffering_time + $service->BookingSetting->service_duration)
                    * OrderService::where('service_id', $service->id)->where('order_id',$order->id)->first()->quantity;
                $minutes += $serviceMinutes;
            }

            $booking = [
                'booking_no' => $booking_no,
                'user_id' => $request->user_id,
//                'service_id' => $request->service_id[$key],
                'order_id' => $order->id,
                'user_address_id' => $order->user_address_id,
                'booking_status_id' => 1,
                'category_id' => $category_id,
//            'group_id' => current($groups),
                'notes' => $request->notes,
//                'quantity' => $request->quantity[$key],
                'date' => $request->day[$category_id],
                'type' => 'service',
                'time' => Carbon::createFromTimestamp($request->start_time[$category_id])->toTimeString(),
                'end_time' => Carbon::parse($request->start_time[$category_id])->addMinutes($minutes)->toTimeString(),
            ];
            Booking::query()->create($booking);

        }

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

        $rules = [
            'date' => 'required|date',
            'service_ids' => 'required|array',
            'service_ids.*' => 'required|exists:services,id',
        ];
        $request->validate($rules, $request->all());
        $itr = $request->itr;

        $day = Carbon::parse($request->date)->locale('en')->dayName;

        $times = [];
        foreach ($request->service_ids as $service_id) {
            $bookSetting = BookingSetting::where('service_id', $service_id)->first();
            if ($bookSetting) {
                $get_time = $this->getTime($day, $bookSetting);
                if ($get_time == true) {
                    $times[] = CarbonInterval::minutes($bookSetting->service_duration + $bookSetting->buffering_time)
                        ->toPeriod(
                            \Carbon\Carbon::now()->setTimeFrom($bookSetting->service_start_time ?? Carbon::now()->startOfDay()),
                            Carbon::now()->setTimeFrom($bookSetting->service_end_time ?? Carbon::now()->endOfDay())
                        );
                }

            }
        }
        $finalAvailTimes = [];
        $oldMemory = [];
        foreach ($times as $time) {
            $allTimes = [];
            foreach ($time as $t) {
                $allTimes[] = $t;
            }
            if (isset($oldMemory[0])) {
                $finalAvailTimes = array_intersect($allTimes, $oldMemory);
            } else {
                $oldMemory = $allTimes;
                $finalAvailTimes = $allTimes;
            }
        }
        $notAvailable = Booking::whereIn('service_id',$request->service_ids)->where('date',$request->date)->where('booking_status_id', 1)->get();

        $service = Service::whereIn('id',$request->service_ids)->get();


        return view('dashboard.orders.schedules-times-available', compact('finalAvailTimes','notAvailable','service','itr'));
    }
    protected function confirmOrder(){
        Order::query()->findOrFail(\request()->id)->update([
            'status_id' => 1
        ]);
        session()->flash('success');
        return redirect()->back();
    }

}
