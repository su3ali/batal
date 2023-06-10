<?php

namespace App\Http\Controllers\Dashboard\Visits;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\BannerImage;
use App\Models\Booking;
use App\Models\BookingSetting;
use App\Models\ContractPackage;
use App\Models\OrderService;
use App\Models\Service;
use App\Models\Visit;
use App\Traits\imageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class VisitsController extends Controller
{
    protected function index()
    {
        if (request()->ajax()) {
            $visit = Visit::all();
            return DataTables::of($visit)
                ->addColumn('visite_id', function ($row) {
                    return $row->visite_id;
                })
                ->addColumn('date', function ($row) {
                    return $row->booking?->date;
                })
                ->addColumn('group_name', function ($row) {
                    return $row->group?->name;
                })
                ->addColumn('start_time', function ($row) {
                    return $row->start_time;
                })
                ->addColumn('end_time', function ($row) {
                    return $row->end_time;
                })
                ->addColumn('duration', function ($row) {
                    return $row->duration;
                })
                ->addColumn('status', function ($row) {
                    return $row->status->name;
                })
                ->addColumn('control', function ($row) {

                    $html = '
                    <a href="#" class="mr-2 btn btn-outline-primary btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-navigation"><polygon points="3 11 22 2 13 21 11 13 3 11"></polygon></svg>

                                <a href="' . route('dashboard.visits.show', $row->id) . '" class="mr-2 btn btn-outline-primary btn-sm">
                            <i class="far fa-eye fa-2x"></i>

                    </a>
                                ';

                    return $html;
                })
                ->rawColumns([
                    'visite_id',
                    'date',
                    'group_name',
                    'start_time',
                    'end_time',
                    'duration',
                    'status',
                    'control',
                ])
                ->make(true);
        }
        return view('dashboard.visits.index');
    }

    protected function store(Request $request)
    {
        $rules = [
            'booking_id' => 'required|exists:bookings,id',
            'assign_to_id' => 'required|exists:groups,id',
            'note' => 'nullable',
            'visits_status_id' => 'required|exists:visits_statuses,id',
        ];
        $validated = Validator::make($request->all(), $rules);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated->errors());
        }
        $validated = $validated->validated();

        $booking = Booking::with('service.category')->where('id', $request->booking_id)->first();
        $semiBookings = Booking::query()->where('category_id', $booking->category_id)
            ->where('order_id', $booking->order_id)->get();
        $service_ids = $semiBookings->pluck('service_id')->toArray();
        if ($booking->type == 'contract') {
            $package = ContractPackage::query()->where('id', $booking->package_id)->first();
            $bookingSettings = BookingSetting::query()->where('service_id', $package->service_id)->get();
        } else {
            $bookingSettings = BookingSetting::query()->whereIn('service_id', $service_ids)->get();
        }

        $start_time = Carbon::parse($booking->time);
        $end_time = Carbon::parse($booking->end_time);
        $validated['start_time'] = $start_time;
        $validated['end_time'] = $end_time;
        $validated['duration'] = $end_time->diffInMinutes($start_time);
        $validated['visite_id'] = rand(1111, 9999) . '_' . date('Ymd');
        Visit::query()->create($validated);
//
//        $booking->update([
//            'booking_status_id'=> 2
//        ]);

        session()->flash('success');
        return redirect()->back();
    }

    public function show($id)
    {
        $visits = Visit::where('id', $id)->first();
        $service_ids = OrderService::where('order_id',$visits->booking->order_id)->where('category_id',$visits->booking->category_id)->get()->pluck('service_id');
        $services = Service::whereIn('id',$service_ids)->get()->pluck('title');

        return view('dashboard.visits.show', compact('visits','services'));
    }


    public function getLocation(Request $request)
    {
        $visits = Visit::where('id', $request->id)->first();

        $latUser = $visits->booking?->address?->lat;
        $longUser = $visits->booking?->address?->long;
        $latTechn = $visits->lat??0;
        $longTechn = $visits->long??0;

        $locations = [
            ['lat'=>(int)$latUser,'lng'=>(int)$longUser],
            ['lat'=>(int)$latTechn,'lng'=>(int)$longTechn],
        ];

        return response()->json($locations);
    }

}
