<?php

namespace App\Http\Controllers\Dashboard\Reports;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\BannerImage;
use App\Models\Booking;
use App\Models\BookingSetting;
use App\Models\Category;
use App\Models\Contract;
use App\Models\ContractPackage;
use App\Models\Order;
use App\Models\OrderService;
use App\Models\Service;
use App\Models\Technician;
use App\Models\User;
use App\Models\Visit;
use App\Models\VisitsStatus;
use App\Notifications\SendPushNotification;
use App\Traits\imageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ReportsController extends Controller
{
    protected function sales()
    {
        if (request()->ajax()) {
            $order = Order::all();
            return DataTables::of($order)
                ->addColumn('order_number', function ($row) {
                    return $row->id;
                })
                ->addColumn('user_name', function ($row) {
                    return $row->user?->first_name .''.$row->user?->last_name;
                })
                ->addColumn('category', function ($row) {

                    $category_ids = OrderService::where('order_id',$row->id)->get()->pluck('category_id')->toArray();
                    $category_ids = array_unique($category_ids);
                    $categories = Category::whereIn('id',$category_ids)->get();
                    $html = '';
                    foreach ($categories as $item) {
                        $html.='<button class="btn-sm btn-primary">'.$item->title.'</button>';
                    }
                    return $html;
                })
                ->addColumn('service_number', function ($row) {
                    $service_ids = OrderService::where('order_id',$row->id)->get()->pluck('service_id')->toArray();

                    return array_sum($service_ids);
                })
                ->addColumn('price', function ($row) {
                    return $row->sub_total;
                })
                ->addColumn('payment_method', function ($row) {
                    return $row->payment_method;
                })

                ->rawColumns([
                    'order_number',
                    'user_name',
                    'category',
                    'service_number',
                    'price',
                    'payment_method',
                ])
                ->make(true);
        }
        return view('dashboard.reports.sales');
    }

    protected function contractSales()
    {
        if (request()->ajax()) {
            $order = Contract::all();
            return DataTables::of($order)
                ->addColumn('contract_number', function ($row) {
                    return $row->id;
                })
                ->addColumn('user_name', function ($row) {
                    return $row->user?->first_name .''.$row->user?->last_name;
                })
                ->addColumn('package', function ($row) {
                    return $row->package?->name;
                })
                ->addColumn('price', function ($row) {
                    return $row->price;
                })
                ->addColumn('payment_method', function ($row) {
                    return $row->payment_method;
                })

                ->rawColumns([
                    'contract_number',
                    'user_name',
                    'category',
                    'price',
                    'payment_method',
                ])
                ->make(true);
        }
        return view('dashboard.reports.contractSales');
    }


    protected function customers()
    {
        if (request()->ajax()) {
            $order = User::all();
            return DataTables::of($order)
                ->addColumn('user_name', function ($row) {
                    return $row->first_name .''.$row->last_name;
                })
                ->addColumn('city', function ($row) {
                    $city = $row->address->first();
                    return $city->address ?? '';
                })
                ->addColumn('phone', function ($row) {
                    return $row->phone;
                })
                ->addColumn('email', function ($row) {
                    return $row->email;
                })->addColumn('service_count', function ($row) {
                    $order_ids = $row->orders()->with('transaction',function($q){
                        $q->where('payment_result','success');
                    })->pluck('id');

                    $services_count = OrderService::whereIn('order_id',$order_ids)->count();
                    return $services_count;
                })->addColumn('point', function ($row) {
                    return $row->point;
                })

                ->rawColumns([
                    'user_name',
                    'city',
                    'phone',
                    'email',
                    'service_count',
                    'point',

                ])
                ->make(true);
        }
        return view('dashboard.reports.customers');
    }

    protected function technicians()
    {
        if (request()->ajax()) {
            $order = Technician::all();
            return DataTables::of($order)
                ->addColumn('user_name', function ($row) {
                    return $row->name;
                })
                ->addColumn('phone', function ($row) {
                    return $row->phone;
                })
                ->addColumn('email', function ($row) {
                    return $row->email;
                })->addColumn('group', function ($row) {
                    return $row->group?->name;
                })->addColumn('service_count', function ($row) {
                    $booking_ids = Visit::where('assign_to_id',$row->group_id)->where('visits_status_id',5)->pluck('booking_id')->toArray();
                    $order_ids = Booking::where('id',$booking_ids)->pluck('order_id')->toArray();

                    $services_count = OrderService::whereIn('order_id',$order_ids)->count();
                    return $services_count;
                })->addColumn('point', function ($row) {
                    return $row->point;
                })->addColumn('rate', function ($row) {

                    return number_format($row->rates->pluck('rate')->avg(),'2');
                })
//                ->addColumn('late', function ($row) {
//                    $visit = Visit::where('assign_to_id',$row->group_id)->where('visits_status_id',5);
//
//
//                    return $services_count;
//                })

                ->rawColumns([
                    'user_name',
                    'phone',
                    'email',
                    'group',
                    'service_count',
                    'point',
                    'rate',

                ])
                ->make(true);
        }
        return view('dashboard.reports.technicians');
    }

    protected function services()
    {
        if (request()->ajax()) {
            $order = Service::all();
            return DataTables::of($order)
                ->addColumn('name', function ($row) {
                    return $row->title;
                })
                ->addColumn('category', function ($row) {
                    return $row->category?->title;
                })
                ->addColumn('service_count', function ($row) {
                    $services_count = OrderService::whereHas('orders',function ($q){
                        $q->whereHas('bookings',function($q){
                            $q->whereHas('visit',function($q){
                                $q->where('visits_status_id',5);
                            });
                        });
                    })->where('service_id',$row->id)->count();
                    return $services_count;
                })->addColumn('rate', function ($row) {
                    return number_format($row->rates->pluck('rate')->avg(),'2');
                })

                ->rawColumns([
                    'name',
                    'category',
                    'service_count',
                    'rate',

                ])
                ->make(true);
        }
        return view('dashboard.reports.services');
    }


}
