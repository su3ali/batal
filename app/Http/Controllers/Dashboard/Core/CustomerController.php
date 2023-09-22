<?php

namespace App\Http\Controllers\Dashboard\Core;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;


class CustomerController extends Controller
{
    public function index()
    {

        if (request()->ajax()) {
            $user = User::all();
            return DataTables::of($user)
                ->addColumn('name', function ($user) {
                    $name = $user->first_name . ' ' . $user->last_name;
                    return $name;
                })
                ->addColumn('city_name', function ($user) {

                    return $user->city?->title;
                })
                ->addColumn('status', function ($user) {
                    $checked = '';
                    if ($user->active == 1) {
                        $checked = 'checked';
                    }
                    return '<label class="switch s-outline s-outline-info  mb-4 mr-2">
                        <input type="checkbox" id="customSwitch4" data-id="' . $user->id . '" ' . $checked . '>
                        <span class="slider round"></span>
                        </label>';
                })
                ->addColumn('controll', function ($user) {

                    $html = '
                    <a href="' . route('dashboard.core.address.index', 'id=' . $user->id) . '" class="mr-2 btn btn-outline-primary btn-sm"><i class="far fa-address-book fa-2x"></i> </a>
                    <a href="' . route('dashboard.core.customer.edit', $user->id) . '" class="mr-2 btn btn-outline-warning btn-sm"><i class="far fa-edit fa-2x"></i> </a>

                                <a data-href="' . route('dashboard.core.customer.destroy', $user->id) . '" data-id="' . $user->id . '" class="mr-2 btn btn-outline-danger btn-delete btn-sm">
                            <i class="far fa-trash-alt fa-2x"></i>
                    </a>
                                ';

                    return $html;
                })
                ->rawColumns([
                    'name',
                    'status',
                    'controll',
                ])
                ->make(true);
        }

        return view('dashboard.core.customers.index');
    }

    public function create()
    {
        $cities = City::where('active', 1)->get()->pluck('title', 'id');

        return view('dashboard.core.customers.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'nullable|email|max:255|unique:users,email',
            'phone' => 'required|numeric|unique:users,phone',
            'active' => 'nullable|in:on,off',
            'city_id' => 'nullable|exists:cities,id',
        ]);

        $data = $request->except('_token', 'active');
        $data['active'] = 1;
        User::query()->create($data);

        session()->flash('success');
        return redirect()->route('dashboard.core.customer.index');
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        $cities = City::where('active', 1)->get()->pluck('title', 'id');
        return view('dashboard.core.customers.edit', compact('user', 'cities'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'nullable|email|max:255|unique:users,email,' . $id,
            'phone' => 'required|numeric|unique:users,phone,' . $id,
            'active' => 'nullable|in:on,off',
            'city_id' => 'nullable|exists:cities,id',

        ]);
        $data = $request->except('_token', 'active');

        $data['active'] = 1;


        $user = User::find($id);
        $user->update($data);
        session()->flash('success');
        return redirect()->route('dashboard.core.customer.index');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();
        return [
            'success' => true,
            'msg' => __("dash.deleted_success")
        ];
    }

    public function change_status(Request $request)
    {
        $admin = User::where('id', $request->id)->first();
        if ($request->active == 'true') {
            $active = 1;
        } else {
            $active = 0;
        }

        $admin->active = $active;
        $admin->save();
        return response()->json(['sucess' => true]);
    }
}
