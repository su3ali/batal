<?php

namespace App\Http\Controllers\Dashboard\Core;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use App\Models\User;
use App\Models\UserAddresses;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;


class AddressController extends Controller
{
    public function index()
    {

        if (request()->ajax()) {
            $address = UserAddresses::where('user_id',request('id'))->get();
            return DataTables::of($address)
                ->addColumn('customer_name', function ($address) {
                    return $address->user?->first_name . ' ' . $address->user?->last_name;
                })
                ->addColumn('country_name', function ($address) {
                    return $address->country?->title;
                })
                ->addColumn('city_name', function ($address) {

                    return $address->city?->title;
                })
                ->addColumn('region_name', function ($address) {

                    return $address->region?->title;
                })
                ->addColumn('status', function ($address) {
                    $checked = '';
                    if ($address->active == 1){
                        $checked = 'checked';
                    }
                    return '<label class="switch s-outline s-outline-info  mb-4 mr-2">
                        <input type="checkbox" id="customSwitch4" data-id="' . $address->id . '" ' . $checked . '>
                        <span class="slider round"></span>
                        </label>';
                })
                ->addColumn('controll', function ($address) {

                    $html = '
                    <a href="'.route('dashboard.core.address.edit', $address->id).'" class="mr-2 btn btn-outline-warning btn-sm"><i class="far fa-edit fa-2x"></i> </a>
                              
                                <a data-href="'.route('dashboard.core.address.destroy', $address->id).'" data-id="'.$address->id.'" class="mr-2 btn btn-outline-danger btn-delete btn-sm">
                            <i class="far fa-trash-alt fa-2x"></i>
                    </a>
                                ';

                    return $html;
                })

                ->rawColumns([
                    'user_name',
                    'country_name',
                    'city_name',
                    'region_name',
                    'status',
                    'controll',
                ])
                ->make(true);
        }

        return view('dashboard.core.addresses.index');
    }

    public function create()
    {
        $countries = Country::where('active',1)->get()->pluck('title','id');
        return view('dashboard.core.addresses.create',compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'region_id' => 'required|exists:regions,id',
            'address' => 'required|string|max:300',
            'active' => 'nullable|in:on,off',
        ]);

        $data=$request->except('_token','active');

        if ($request['active'] && $request['active'] == 'on'){
            $data['active'] = 1;
        }else{
            $data['active'] = 0;
        }


        UserAddresses::updateOrCreate($data);

        session()->flash('success');
        return redirect()->route('dashboard.core.address.index','id='.$request->user_id);
    }

    public function edit($id)
    {
        $address = UserAddresses::where('id',$id)->first();
        $countries = Country::where('active',1)->get()->pluck('title','id');
        $cities = City::where('active',1)->get()->pluck('title','id');
        $regions = Region::where('active',1)->get()->pluck('title','id');
        return view('dashboard.core.addresses.edit',compact('address','countries','cities','regions'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'region_id' => 'required|exists:regions,id',
            'address' => 'required|string|max:300',
            'active' => 'nullable|in:on,off',

        ]);
        $data=$request->except('_token','active');

        if ($request['active'] && $request['active'] == 'on'){
            $data['active'] = 1;
        }else{
            $data['active'] = 0;
        }


        $user = UserAddresses::find($id);
        $user->update($data);
        session()->flash('success');
        return redirect()->route('dashboard.core.address.index','id='.$request->user_id);
    }

    public function destroy($id)
    {
        $user = UserAddresses::find($id);

        $user->delete();
        return [
            'success' => true,
            'msg' => __("dash.deleted_success")
        ];
    }

    public function change_status(Request $request){
        $admin = UserAddresses::where('id',$request->id)->first();
        if ($request->active == 'true'){
            $active = 1;
        }else{
            $active = 0;
        }

        $admin->active = $active;
        $admin->save();
        return response()->json(['sucess'=>true]);
    }


    public function getCityBycountry(Request $request)
    {

        $cities = City::where('active',1)->where('country_id',$request->country_id)->get()->pluck('title','id');
        return $cities;

    }

    public function getRegionByCity(Request $request)
    {

        $regions = Region::where('active',1)->where('city_id',$request->city_id)->get()->pluck('title','id');
        return $regions;

    }

}
