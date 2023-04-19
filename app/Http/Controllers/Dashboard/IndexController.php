<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Order;
use App\Models\Technician;
use App\Models\User;
use Yajra\DataTables\DataTables;

class IndexController extends Controller
{
    protected function index(){
        $customers = User::count();
        $orders = Order::count();
        $technicians = Technician::count();
        $booking = Booking::count();

        return view('dashboard.home',compact('customers','orders','technicians','booking'));
    }





}
