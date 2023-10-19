<?php

namespace App\Http\Controllers\Dashboard;

use App\Charts\CommonChart;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Order;
use App\Models\Technician;
use App\Models\User;
use Yajra\DataTables\DataTables;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class IndexController extends Controller
{
    public function getCurrentFinancialYear()
    {
        $start_month = 1;
        $end_month = $start_month - 1;
        if ($start_month == 1) {
            $end_month = 12;
        }

        $start_year = date('Y');
        //if current month is less than start month change start year to last year
        if (date('n') < $start_month) {
            $start_year = $start_year - 1;
        }

        $end_year = date('Y');
        //if current month is greater than end month change end year to next year
        if (date('n') > $end_month) {
            $end_year = $start_year + 1;
        }
        $start_date = $start_year.'-'.str_pad($start_month, 2, 0, STR_PAD_LEFT).'-01';
        $end_date = $end_year.'-'.str_pad($end_month, 2, 0, STR_PAD_LEFT).'-01';
        $end_date = date('Y-m-t', strtotime($end_date));

        $output = [
            'start' => $start_date,
            'end' => $end_date,
        ];

        return $output;
    }

    public function getSellsCurrentFy($start, $end)
    {
        // $start = Carbon::parse($start)->timestamp;
        // $end = Carbon::parse($end)->timestamp;
        $query = Transaction::leftjoin('orders','transactions.order_id','=','orders.id')
                            ->where('transactions.payment_result','success')->whereBetween('transactions.created_at', [$start, $end]);

        $query->select(
            DB::raw("DATE_FORMAT(transactions.created_at, '%m-%Y') as yearmonth"),
            DB::raw('SUM( orders.total - COALESCE(orders.total, 0)) as total_sells'),
            DB::raw("DATE_FORMAT(transactions.created_at, '%Y-%m-%d') as date"),
        )->groupBy(DB::raw('date(transactions.created_at)'));

        $sells = $query->get();
        return $sells;
    }
    protected function index(){
        $customers = User::count();
        $orders = Order::count();
        $technicians = Technician::count();
        $booking = Booking::count();

        $now=Carbon::now('Asia/Riyadh')->toDateString();

        $orders_today = Order::whereDate('created_at','=',$now)->count();
        $booking_today = Booking::whereDate('created_at','=',$now)->count();
        $fy = $this->getCurrentFinancialYear();
        $least_7_days = Carbon::parse($fy['start'])->subDays(7)->format('Y-m-d');
     

        $all_sell_values = Transaction::select(\DB::raw("COUNT(*) as count"))

        ->whereBetween('transactions.created_at', [ $least_7_days, $fy['end']])

        ->groupBy(DB::raw('date(transactions.created_at)'))

        ->pluck('count');

        //Chart for sells last 7 days
        $labels = [];
    
        $dates = [];
        for ($i = 6; $i >= 0; $i--) {
             $date = Carbon::now('Asia/Riyadh')->subDays($i)->format('Y-m-d');
             $dates[] = $date;
 
             $labels[] = date('j M Y', strtotime($date));
 
        }

        $sells_chart_1 = new CommonChart;
    
        $sells_chart_1->labels($labels)->options($this->__chartOptions(
            __(
                __('dash.orders'),
                ['currency' => 'SAR']
            )));
        $sells_chart_1->dataset(__('dash.orders'), 'line', $all_sell_values);
        return view('dashboard.home',compact('booking_today','orders_today','sells_chart_1','customers','orders','technicians','booking'));
    }
    private function __chartOptions($title)
    {
        return [
            'yAxis' => [
                'title' => [
                    'text' => $title,
                ],
            ],
            'legend' => [
                'align' => 'right',
                'verticalAlign' => 'top',
                'floating' => true,
                'layout' => 'vertical',
                'padding' => 20,
            ],
        ];
    }




}
