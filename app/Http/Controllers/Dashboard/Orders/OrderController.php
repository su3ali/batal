<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;


class OrderController extends Controller
{

    public function index()
    {
        $users = User::all();
        $categories = Category::all();
        $services = Service::all();
        if (request()->ajax()) {
            $orders = Order::all();
            return DataTables::of($orders)
                ->addColumn('user', function ($row) {
                    return $row->user->name;
                })
                ->addColumn('service', function ($row) {
                    return $row->service->title;
                })
                ->addColumn('status', function ($row) {
                    return $row->status->name;
                })
                ->addColumn('control', function ($row) {

                    $html = '
                                <button type="button" id="edit-order" class="btn btn-primary btn-sm card-tools edit" data-id="'.$row->id.'"
                                 data-user_id="'.$row->user_id.'" data-category_id="'.$row->category_id.'" data-service_id="'.$row->service_id.'"
                                  data-price="'.$row->price.'" data-payment_method="'.$row->payment_method.'" data-notes="'.$row->notes.'"
                                  data-toggle="modal" data-target="#editOrderModel">
                            <i class="far fa-edit fa-2x"></i>
                       </button>

                                <a data-table_id="html5-extension" data-href="'.route('dashboard.orders.destroy', $row->id).'" data-id="' . $row->id . '" class="mr-2 btn btn-outline-danger btn-sm btn-delete btn-sm delete_tech">
                            <i class="far fa-trash-alt fa-2x"></i>
                    </a>
                                ';

                    return $html;
                })
                ->rawColumns([
                    'user',
                    'service',
                    'status',
                    'control',
                ])
                ->make(true);
        }

        return view('dashboard.orders.index', compact('users', 'categories', 'services'));
    }

    /**
     * @throws ValidationException
     */
    protected function store(Request $request): RedirectResponse
    {
        $rules = [
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'service_id' => 'required|exists:services,id',
            'price' => 'required|Numeric',
            'payment_method' => 'required|in:visa,cache',
            'notes' => 'nullable|String'
        ];
        $validated = Validator::make($request->all(), $rules);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated->errors());
        }
        $validated = $validated->validated();
        $validated['status_id'] = 1;
        Order::query()->create($validated);
        session()->flash('success');
        return redirect()->back();
    }
    protected function update(Request $request, $id){
        $order = Order::query()->where('id', $id)->first();
        $rules = [
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'service_id' => 'required|exists:services,id',
            'price' => 'required|Numeric',
            'payment_method' => 'required|in:visa,cache',
            'notes' => 'nullable|String'
        ];
        $validated = Validator::make($request->all(), $rules);
        if ($validated->fails()) {
            return redirect()->back()->with('errors', $validated->errors());
        }
        $validated = $validated->validated();
        $order->update($validated);
        session()->flash('success');
        return redirect()->back();
    }

    protected function destroy($id)
    {
        $order = Order::find($id);
        $order->delete();
        return [
            'success' => true,
            'msg' => __("dash.deleted_success")
        ];
    }


}
