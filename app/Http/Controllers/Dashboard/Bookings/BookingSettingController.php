<?php

namespace App\Http\Controllers\Dashboard\Bookings;

use App\Http\Controllers\Controller;
use App\Models\BookingSetting;
use App\Models\CustomerWallet;
use App\Models\Service;
use Illuminate\Http\Request;
use function Symfony\Component\String\title;
use Yajra\DataTables\Facades\DataTables;


class BookingSettingController extends Controller
{
    protected function index(){
        if (request()->ajax()) {

            $bookings = BookingSetting::query()->get();
            return DataTables::of($bookings)
                ->addColumn('service_name', function ($row) {
                    return $row->service?->title;
                })
                ->addColumn('service_start_date', function ($row) {

                    if($row->service_start_date == 'Saturday'){
                        $day = 'السبت';
                    }elseif ($row->service_start_date == 'Sunday'){
                        $day = 'الأحد';

                    }elseif ($row->service_start_date == 'Monday'){
                        $day = 'الإثنين';

                    }elseif ($row->service_start_date == 'Tuesday'){
                        $day = 'الثلاثاء';

                    }elseif ($row->service_start_date == 'Wednesday'){
                        $day = 'الأربعاء';

                    }elseif ($row->service_start_date == 'Thursday'){
                        $day = 'الخميس';

                    }elseif ($row->service_start_date == 'Friday'){
                        $day = 'الجمعه';

                    }

                    return $day??'';



                })
                ->addColumn('service_end_date', function ($row) {
                    if($row->service_end_date == 'saturday'){
                        $day = 'السبت';
                    }elseif ($row->service_end_date == 'Sunday'){
                        $day = 'الأحد';

                    }elseif ($row->service_end_date == 'Monday'){
                        $day = 'الإثنين';

                    }elseif ($row->service_end_date == 'Tuesday'){
                        $day = 'الثلاثاء';

                    }elseif ($row->service_end_date == 'Wednesday'){
                        $day = 'الأربعاء';

                    }elseif ($row->service_end_date == 'Thursday'){
                        $day = 'الخميس';

                    }elseif ($row->service_end_date == 'Friday'){
                        $day = 'الجمعه';

                    }

                    return $day??'';
                })
                ->addColumn('available_service', function ($row) {
                    return $row->available_service;
                })
                ->addColumn('service_start_time', function ($row) {
                    return $row->service_start_time;
                })
                ->addColumn('service_end_time', function ($row) {
                    return $row->service_end_time;
                })
                ->addColumn('service_duration', function ($row) {
                    return $row->service_duration;
                })
                ->addColumn('buffering_time', function ($row) {
                    return $row->buffering_time;
                })
                ->addColumn('control', function ($row) {
                    $html = '
                    <a href="'.route('dashboard.booking_setting.edit', $row->id).'"  id="edit-booking" class="btn btn-primary btn-sm card-tools edit" data-id="' . $row->id . '"
                          >
                            <i class="far fa-edit fa-2x"></i>
                       </a>

                                <a data-table_id="html5-extension" data-href="' . route('dashboard.booking_setting.destroy', $row->id) . '" data-id="' . $row->id . '" class="mr-2 btn btn-outline-danger btn-sm btn-delete btn-sm delete_tech">
                            <i class="far fa-trash-alt fa-2x"></i>
                    </a>';
                    return $html;
                })
                ->rawColumns([
                    'service_name',
                    'service_start_date',
                    'service_end_date',
                    'available_service',
                    'service_start_time',
                    'service_end_time',
                    'service_duration',
                    'buffering_time',
                    'control'
                ])
                ->make(true);
        }
        return view('dashboard.booking_settings.index');
    }

    protected function create()
    {

        $services = Service::where('active',1)->get();

        return view('dashboard.booking_settings.create', compact('services'));
    }

    protected function store(Request $request){
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'service_start_date' => 'required|String',
            'service_end_date' => 'required|String',
            'available_service' => 'required|numeric',
            'service_start_time' => 'required',
            'service_end_time' => 'required',
            'service_duration' => 'required|String',
            'buffering_time' => 'required',
        ]);

        $data=$request->except('_token');


        BookingSetting::query()->create($data);
        session()->flash('success');
        return redirect()->route('dashboard.booking_setting.index');
    }

    protected function edit($id){
        $bookingSetting = BookingSetting::query()->where('id', $id)->first();
        $services = Service::where('active',1)->get();

        return view('dashboard.booking_settings.edit', compact('bookingSetting','services'));

    }

    protected function update(Request $request){
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'service_start_date' => 'required|String',
            'service_end_date' => 'required|String',
            'available_service' => 'required|numeric',
            'service_start_time' => 'required',
            'service_end_time' => 'required',
            'service_duration' => 'required|String',
            'buffering_time' => 'required',
        ]);


        $data=$request->except('_token');


        BookingSetting::query()->first()->update($data);
        session()->flash('success');
        return redirect()->route('dashboard.booking_setting.index');
    }

    protected function destroy($id)
    {
        $booking = BookingSetting::query()->find($id);
        $booking->delete();
        return [
            'success' => true,
            'msg' => __("dash.deleted_success")
        ];
    }

}
