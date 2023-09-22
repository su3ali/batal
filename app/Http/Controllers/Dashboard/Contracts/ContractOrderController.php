<?php

namespace App\Http\Controllers\Dashboard\Contracts;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingSetting;
use App\Models\BookingStatus;
use App\Models\City;
use App\Models\Contract;
use App\Models\ContractPackage;
use App\Models\Group;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use App\Traits\schedulesTrait;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\ValidationException;


class ContractOrderController extends Controller
{
    use schedulesTrait;
    public function index()
    {
        if (request()->ajax()) {
            $contracts = Contract::all();
            return DataTables::of($contracts)
                ->addColumn('name', function ($row) {
                    return $row->user?->first_name .' '. $row->user?->last_name;
                })
                ->addColumn('package_name', function ($row) {
                    return $row->package?->name;
                })

                ->addColumn('control', function ($row) {
                    $html = '

                                <a data-table_id="html5-extension" data-href="' . route('dashboard.contracts.destroy', $row->id) . '" data-id="' . $row->id . '" class="mr-2 btn btn-outline-danger btn-sm btn-delete btn-sm delete_tech">
                            <i class="far fa-trash-alt fa-2x"></i>
                    </a>';
                    return $html;
                })
                ->rawColumns([
                    'name',
                    'package_name',
                    'control'
                ])
                ->make(true);
        }

        return view('dashboard.contract_order.index');
    }

    protected function create()
    {
        $cities = City::where('active',1)->get()->pluck('title','id');

        return view('dashboard.contract_order.create',compact('cities'));
    }

    /**
     * @throws ValidationException
     */
    protected function store(Request $request): RedirectResponse
    {



        $rules = [
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:contract_packages,id',
            'price' => 'required|Numeric',
            'payment_method' => 'required|in:visa,cache',
            'notes' => 'nullable|String',
            'quantity' => 'required|Numeric',
            'day' => 'array|required',
            'day.*' => 'required',
            'start_time' => 'array|required',
            'start_time.*' => 'required',
        ];
        $validated = Validator::make($request->all(), $rules);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated->errors());
        }


        $data = [
            'user_id' => $request->user_id,
            'package_id' => $request->service_id,
            'price' => $request->price,
            'status_id' => 2,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
            'quantity' => $request->quantity,
        ];


        $order = Contract::query()->create($data);
        $last = Booking::query()->latest()->first()?->id;
        $num = $last ? $last + 1 : 1;
        $booking_no = 'dash2023/' . $num;

        foreach ($request->day as $key => $item){
            $booking = [
                'booking_no' => $booking_no,
                'user_id' => $request->user_id,
                'package_id' => $request->service_id,
                'contract_order_id' => $order->id,
                'booking_status_id' => 1,
                'notes' => $request->notes,
                'quantity' => 1,
                'date' => $item,
                'type' => 'contract',
                'time' => \Illuminate\Support\Carbon::createFromTimestamp($request->start_time[$key])->toTimeString(),
            ];
            Booking::query()->create($booking);

        }




        session()->flash('success');
        return redirect()->back();
    }

    protected function autoCompleteContract(Request $request)
    {
        $contract = [];
        if ($request->has('q')) {

            $search = $request->q;
            if (app()->getLocale() == 'ar'){
                $contract = ContractPackage::where('name_ar', 'LIKE', "%$search%")->get();

            }else{
                $contract = ContractPackage::where('name_en', 'LIKE', "%$search%")->get();
            }

        }

        return response()->json($contract);

    }

    protected function getContractById(Request $request)
    {
        $contract = ContractPackage::where('id',$request->contract_id)->first();

        return response()->json($contract);

    }


    protected function getAvailableTime(Request $request)
    {
        $itr = $request->itr;
        $day = \Illuminate\Support\Carbon::parse($request->date)->locale('en')->dayName;

        $package = ContractPackage::where('id',$request->id)->first();

        $bookSetting = BookingSetting::where('service_id', $package->service_id)->first();

        $get_time = $this->getTime($day,$bookSetting);

        $times = [];
        if($get_time == true){
            $times = CarbonInterval::minutes($bookSetting->service_duration + $bookSetting->buffering_time)
                ->toPeriod(
                    \Carbon\Carbon::now()->setTimeFrom($bookSetting->service_start_time ?? Carbon::now()->startOfDay()),
                    Carbon::now()->setTimeFrom($bookSetting->service_end_time ?? Carbon::now()->endOfDay())
                );
        }

        $notAvailable = Booking::where('type','contract')->where('package_id',$request->id)->where('date',$request->date)->where('booking_status_id', 1)->get();

        return view('dashboard.contract_order.schedules-times-available', compact('times','notAvailable','package','itr'));
    }


    protected function showBookingDiv(Request $request)
    {

        $package = ContractPackage::where('id',$request->id)->first('visit_number');

        return view('dashboard.contract_order.time', compact('package'));
    }

    protected function destroy($id)
    {
        $contract = Contract::query()->find($id);
        $contract->delete();
        return [
            'success' => true,
            'msg' => __("dash.deleted_success")
        ];
    }


}
