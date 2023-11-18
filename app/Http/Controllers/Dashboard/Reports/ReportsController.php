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
    protected function sales(Request $request)
    {
        if (request()->ajax()) {
            $date = $request->date;
            $date2 = $request->date2;
            $service = $request->service;
            $payment_method = $request->payment_method;
            $order = Order::where(function ($query) {
                $query->where('status_id', '!=', 5)->orWhereHas('transaction', function ($q) {
                    $q->where('payment_method', '!=', 'cache');
                });
            });


            if ($date) {
                error_log($date);
                $carbonDate = \Carbon\Carbon::parse($date)->timezone('Asia/Riyadh');
                $formattedDate = $carbonDate->format('Y-m-d H:i:s');
                $order = $order->where('created_at', '>=', $formattedDate);
            }
            if ($date2) {

                $carbonDate2 = \Carbon\Carbon::parse($date2)->timezone('Asia/Riyadh');
                $formattedDate2 = $carbonDate2->format('Y-m-d H:i:s');
                $order = $order->where('created_at', '<=', $formattedDate2);
            }
            if ($payment_method) {
                $order = $order->whereHas('transaction', function ($q) use ($payment_method) {
                    $q->where('payment_method', $payment_method);
                });
            }
            if ($service) {

                $orders_ids = OrderService::where('service_id', $service)->get()->pluck('order_id')->toArray();
                $order = $order->whereIn('id', $orders_ids);
            }


            $order = $order->where('is_active', 1)->get();

            return DataTables::of($order)
                ->addColumn('order_number', function ($row) {
                    return $row->id;
                })
                ->addColumn('user_name', function ($row) {
                    return $row->user?->first_name . '' . $row->user?->last_name;
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at;
                })
                ->addColumn('service', function ($row) {
                    $services_ids = OrderService::where('order_id', $row->id)->get()->pluck('service_id')->toArray();
                    $services = Service::whereIn('id', $services_ids)->get();
                    $html = '';
                    foreach ($services as $item) {
                        $html .= '<button class="btn-sm btn-primary">' . $item->title_ar . '</button>';
                    }
                    // $category_ids = OrderService::where('order_id',$row->id)->get()->pluck('category_id')->toArray();
                    // $category_ids = array_unique($category_ids);
                    // $categories = Category::whereIn('id',$category_ids)->get();
                    // $html = '';
                    // foreach ($categories as $item) {
                    //     $html.='<button class="btn-sm btn-primary">'.$item->title.'</button>';
                    // }
                    return $html;
                })
                ->addColumn('service_number', function ($row) {
                    //  $service_ids = OrderService::where('order_id',$row->id)->get()->pluck('service_id')->toArray();
                    $service_count = OrderService::where('order_id', $row->id)->count();

                    return $service_count;
                })
                ->addColumn('price', function ($row) {
                    return $row->total;
                })
                ->addColumn('payment_method', function ($row) use ($payment_method) {
                    $payment_methodd = $row->transaction?->payment_method;
                    if ($payment_method)
                        $payment_methodd = $payment_method;
                    if ($payment_methodd == "cache" || $payment_methodd == "cash")
                        return "شبكة";
                    else if ($payment_methodd == "wallet")
                        return "محفظة";
                    else
                        return "فيزا";
                })->addColumn('total', function ($row) {
                    return $row->total;
                })

                ->rawColumns([
                    'order_number',
                    'user_name',
                    'created_at',
                    'service',
                    'service_number',
                    'price',
                    'payment_method',
                    'total'
                ])
                ->make(true);
        }

        $total = Order::where('is_active', 1)->where(function ($query) {
            $query->Where('status_id', '<>', 6)->orWhereHas('transaction', function ($q) {
                $q->where('payment_method', '!=', 'cahce');
            });
        })->sum('total');
        error_log($total);
        $tax = ($total * 15) / 100 ?? 0;
        $services = Service::all()->pluck('title', 'id');
        return view('dashboard.reports.sales', compact('total', 'tax', 'services'));
    }

    protected function updateSummary(Request $request)
    {
        $date = $request->date;
        $date2 = $request->date2;
        $payment_method = $request->payment_method;
        $service = $request->service;
        $orderQuery = Order::query();

        if ($date) {

            $carbonDate = \Carbon\Carbon::parse($date)->timezone('Asia/Riyadh');
            $formattedDate = $carbonDate->format('Y-m-d H:i:s');
            $orderQuery->where('created_at', '>=', $formattedDate);
        }

        if ($date2) {

            $carbonDate2 = \Carbon\Carbon::parse($date2)->timezone('Asia/Riyadh');
            $formattedDate2 = $carbonDate2->format('Y-m-d H:i:s');
            $carbonDate = \Carbon\Carbon::parse($date)->timezone('Asia/Riyadh');
            $formattedDate = $carbonDate->format('Y-m-d H:i:s');
            $orderQuery->where([['created_at', '>=', $formattedDate], ['created_at', '<=', $formattedDate2]]);
        }

        if ($payment_method && $payment_method != 'all') {

            $orderQuery->whereHas('transaction', function ($q) use ($payment_method) {
                $q->where('payment_method', $payment_method);
            });
        }
        if ($service && $service != 'all') {

            $orders_ids = OrderService::where('service_id', $service)->get()->pluck('order_id')->toArray();
            $orderQuery->whereIn('id', $orders_ids);
        }

        // Calculate the total, tax, and tax-subtotal
        $total = $orderQuery->where('is_active', 1)->sum('total');
        $taxRate = 0.15; // 15% tax rate
        $tax = $total * $taxRate;
        $taxTotal = $total + $tax;



        // Return the summary values as JSON
        return response()->json([
            'total' => $total,
            'tax' => $tax,
            'taxTotal' => $taxTotal,
        ]);
    }


    protected function contractSales(Request $request)
    {
        if (request()->ajax()) {
            $order = Contract::query();
            $date = $request->date;
            if ($date) {
                $carbonDate = \Carbon\Carbon::parse($date)->timezone('Asia/Riyadh');
                $formattedDate = $carbonDate->format('Y-m-d H:i:s');
                $order = $order->where('created_at', '=', $formattedDate);
            }

            $order = $order->get();
            return DataTables::of($order)
                ->addColumn('contract_number', function ($row) {
                    return $row->id;
                })
                ->addColumn('user_name', function ($row) {
                    return $row->user?->first_name . '' . $row->user?->last_name;
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
                    return $row->first_name . '' . $row->last_name;
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
                    $order_ids = $row->orders()->with('transaction', function ($q) {
                        $q->where('payment_result', 'success');
                    })->pluck('id');

                    $services_count = OrderService::whereIn('order_id', $order_ids)->count();
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
                    $booking_ids = Visit::where('assign_to_id', $row->group_id)->where('visits_status_id', 5)->pluck('booking_id')->toArray();
                    $order_ids = Booking::where('id', $booking_ids)->pluck('order_id')->toArray();

                    $services_count = OrderService::whereIn('order_id', $order_ids)->count();
                    return $services_count;
                })->addColumn('point', function ($row) {
                    return $row->point;
                })->addColumn('rate', function ($row) {

                    return number_format($row->rates->pluck('rate')->avg(), '2');
                })
                ->addColumn('late', function ($row) {
                    $visits = Visit::where('assign_to_id', $row->group_id)->where('visits_status_id', 5)->get();
                    $booking_ids = $visits->pluck('booking_id')->toArray();
                    $order_ids = Booking::where('id', $booking_ids)->pluck('order_id')->toArray();
                    $service_ids = OrderService::whereIn('order_id', $order_ids)->pluck('service_id')->toArray();
                    if ($service_ids != []) {
                        $service = BookingSetting::whereIn('service_id', $service_ids)->pluck('service_duration')->toArray();
                        $SumServiceDuration = array_sum($service);
                        $duration = 0;
                        foreach ($visits as $visit) {
                            $start_time = Carbon::parse($visit->start_time)->timezone('Asia/Riyadh')->format('H:i:s');
                            $end_time = Carbon::parse($visit->end_time)->timezone('Asia/Riyadh')->format('H:i:s');
                            $duration += Carbon::parse($end_time)->diffInMinutes(Carbon::parse($start_time));
                        }
                        $sum = $SumServiceDuration - $duration;
                        $total = $sum / count($service_ids);
                    }

                    return $total ?? 0;
                })

                ->rawColumns([
                    'user_name',
                    'phone',
                    'email',
                    'group',
                    'service_count',
                    'point',
                    'rate',
                    'late',

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
                    $services_count = OrderService::whereHas('orders', function ($q) {
                        $q->whereHas('bookings', function ($q) {
                            $q->whereHas('visit', function ($q) {
                                $q->where('visits_status_id', 5);
                            });
                        });
                    })->where('service_id', $row->id)->count();
                    return $services_count;
                })->addColumn('rate', function ($row) {
                    return number_format($row->rates->pluck('rate')->avg(), '2');
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
