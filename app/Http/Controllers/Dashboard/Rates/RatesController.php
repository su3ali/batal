<?php

namespace App\Http\Controllers\Dashboard\Rates;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\BannerImage;
use App\Models\Booking;
use App\Models\BookingSetting;
use App\Models\ContractPackage;
use App\Models\RateService;
use App\Models\RateTechnician;
use App\Models\Visit;
use App\Traits\imageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class RatesController extends Controller
{
    protected function rateTechnicians()
    {
        if (request()->ajax()) {
            $visit = RateTechnician::all();
            return DataTables::of($visit)
                ->addColumn('user_phone', function ($row) {
                    return $row->user?->phone;
                })
                ->addColumn('technician_name', function ($row) {
                    return $row->technician?->name;
                })
                ->addColumn('order_nu', function ($row) {
                    return $row->order?->id;
                })
                ->addColumn('rate', function ($row) {
                    return $row->rate;
                })
                ->addColumn('note', function ($row) {
                    return $row->note;
                })
                ->addColumn('control', function ($row) {

                    $html = '
                               <a href="' . route('dashboard.rates.showTechnician', $row->id) . '" class="mr-2 btn btn-outline-primary btn-sm">
                            <i class="far fa-eye fa-2x"></i>

                    </a>
                                ';

                    return $html;
                })
                ->rawColumns([
                    'user_phone',
                    'technician_name',
                    'order_nu',
                    'rate',
                    'note',
                    'control',
                ])
                ->make(true);
        }
        return view('dashboard.rate.rateTechnicians');
    }

    protected function showTechnicians($id)
    {
        $tech = RateTechnician::where('id',$id)->first();
        return view('dashboard.rate.showTechnicians',compact('tech'));

    }


    protected function rateServices()
    {
        if (request()->ajax()) {
            $visit = RateService::all();
            return DataTables::of($visit)

                ->addColumn('category_name', function ($row) {
                    return $row->service?->category?->title;
                })
                ->addColumn('service_name', function ($row) {
                    return $row->service?->title;
                })

                ->addColumn('user_phone', function ($row) {
                    return $row->user?->phone;
                })
                ->addColumn('order_nu', function ($row) {
                    return $row->order?->id;
                })
                ->addColumn('rate', function ($row) {
                    return $row->rate;
                })
                ->addColumn('note', function ($row) {
                    return $row->note;
                })
                ->addColumn('control', function ($row) {

                    $html = '
                               <a href="' . route('dashboard.rates.showService', $row->id) . '" class="mr-2 btn btn-outline-primary btn-sm">
                            <i class="far fa-eye fa-2x"></i>

                    </a>
                                ';

                    return $html;
                })
                ->rawColumns([
                    'category_name',
                    'service_name',
                    'user_phone',
                    'order_nu',
                    'rate',
                    'note',
                    'control',
                ])
                ->make(true);
        }
        return view('dashboard.rate.rateServices');
    }

    protected function showServices($id)
    {
        $serv = RateService::where('id',$id)->first();
        return view('dashboard.rate.showServices',compact('serv'));
    }



}
