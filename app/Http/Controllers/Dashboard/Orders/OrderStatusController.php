<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\ValidationException;


class OrderStatusController extends Controller {

    public function index()
    {
        if (request()->ajax()) {
            $statuses = OrderStatus::all();
            return DataTables::of($statuses)
                ->addColumn('name', function ($row) {
                    return $row->name;
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
                                <button type="button" id="edit-order-status" class="btn btn-primary btn-sm card-tools edit" data-id="'.$row->id.'"
                                 data-name_ar="'.$row->name_ar.'" data-name_en="'.$row->name_en.'"
                                  data-description_ar="'.$row->description_ar.'" data-description_en="'.$row->description_en.'"
                                  data-toggle="modal" data-target="#editOrderStatusModel">
                            <i class="far fa-edit fa-2x"></i>
                       </button>

                                <a data-table_id="html5-extension" data-href="'.route('dashboard.order_statuses.destroy', $row->id).'" data-id="' . $row->id . '" class="mr-2 btn btn-outline-danger btn-sm btn-delete btn-sm delete_tech">
                            <i class="far fa-trash-alt fa-2x"></i>
                    </a>
                                ';

                    return $html;
                })
                ->rawColumns([
                    'name',
                    'status',
                    'control',
                ])
                ->make(true);
        }

        return view('dashboard.order_statuses.index');
    }

    /**
     * @throws ValidationException
     */
    protected function store(Request $request): RedirectResponse
    {
        $rules = [
            'name_ar' => 'required||String|unique:order_statuses,name_ar',
            'name_en' => 'required||String|unique:order_statuses,name_en',
            'description_ar' => 'nullable|String',
            'description_en' => 'nullable|String',
        ];
        $validated = Validator::make($request->all(), $rules);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated->errors());
        }
        $validated = $validated->validated();
        OrderStatus::query()->create($validated);
        session()->flash('success');
        return redirect()->back();
    }
    protected function update(Request $request, $id){
        $orderStatus = OrderStatus::query()->where('id', $id)->first();
        $rules = [
            'name_ar' => 'required|unique:order_statuses,name_ar,'.$id,
            'name_en' => 'required|unique:order_statuses,name_en,'.$id,
            'description_ar' => 'nullable|String',
            'description_en' => 'nullable|String',
        ];
        $validated = Validator::make($request->all(), $rules);
        if ($validated->fails()) {
            return redirect()->back()->with('errors', $validated->errors());
        }
        $validated = $validated->validated();
        $orderStatus->update($validated);
        session()->flash('success');
        return redirect()->back();
    }

    protected function destroy($id)
    {
        $orderStatus = OrderStatus::find($id);
        if (in_array($id, Order::query()->pluck('status_id')->toArray())){
            return response()->json(['success' => false,
                'msg' => 'حذف الحالة غير متاح لارتباطها بطلب'
            ]);
        }
        $orderStatus->delete();
        return [
            'success' => true,
            'msg' => __("dash.deleted_success")
        ];
    }
    protected function change_status (Request $request){
        $order_status = OrderStatus::query()->where('id', $request->id)->first();
        if ($request->active == "false"){
            $order_status->active = 0;
        }else{
            $order_status->active = 1;
        }
        $order_status->save();
        return response('success');
    }

}
