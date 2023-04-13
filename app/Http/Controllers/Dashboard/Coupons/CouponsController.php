<?php

namespace App\Http\Controllers\Dashboard\Coupons;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Service;
use Yajra\DataTables\DataTables;

class CouponsController extends Controller
{
    protected function index()
    {
        if (request()->ajax()) {
            $coupons = Coupon::all();
            return DataTables::of($coupons)
                ->addColumn('title', function ($row) {
                    return $row->title;
                })
                ->addColumn('value', function ($row) {
                    return $row->type == 'percentage'? $row->value.'%' : $row->value.' ريال سعودي ';
                })
                ->addColumn('status', function ($row) {
                    $checked = '';
                    if ($row->active == 1) {
                        $checked = 'checked';
                    }
                    return '<label class="switch s-outline s-outline-info  mb-4 mr-2">
                        <input type="checkbox" id="customSwitchStatus" data-id="' . $row->id . '" ' . $checked . '>
                        <span class="slider round"></span>
                        </label>';
                })
                ->addColumn('control', function ($row) {

                    $html = '
                    <a href="'.route('dashboard.coupons.edit', $row->id).'"  id="edit-coupon" class="btn btn-primary btn-sm card-tools edit" data-id="' . $row->id . '"
                          >
                            <i class="far fa-edit fa-2x"></i>
                       </a>

                                <a data-table_id="html5-extension" data-href="' . route('dashboard.coupons.destroy', $row->id) . '" data-id="' . $row->id . '" class="mr-2 btn btn-outline-danger btn-sm btn-delete btn-sm delete_tech">
                            <i class="far fa-trash-alt fa-2x"></i>
                    </a>';
                    return $html;
                })
                ->rawColumns([
                    'title',
                    'value',
                    'status',
                    'control',
                ])
                ->make(true);
        }

        return view('dashboard.coupons.index');
    }

    protected function create(){
        $categories = Category::all();
        $services = Service::all();
        return view('dashboard.coupons.create', compact('categories', 'services'));
    }
}
