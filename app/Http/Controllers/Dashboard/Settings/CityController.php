<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;


class CityController extends Controller
{
    public function index()
    {

        if (request()->ajax()) {

            $city = City::all();

            return DataTables::of($city)
                ->addColumn('title', function ($city) {
                    return $city->title;
                })
                ->addColumn('country_name', function ($city) {
                    return $city->country?->title;
                })
                ->addColumn('status', function ($city) {
                    $checked = '';
                    if ($city->active == 1){
                        $checked = 'checked';
                    }
                    return '<label class="switch s-outline s-outline-info  mb-4 mr-2">
                        <input type="checkbox" id="customSwitch4" data-id="' . $city->id . '" ' . $checked . '>
                        <span class="slider round"></span>
                        </label>';
                })
                ->addColumn('controll', function ($city) {

                    $html = '
                    
                                <button type="button" id="add-work-exp" class="btn btn-sm btn-primary card-tools edit" data-id="'.$city->id.'"  data-title_ar="'.$city->title_ar.'"
                                 data-title_en="'.$city->title_en.'" data-country_id="'.$city->country_id.'" data-toggle="modal" data-target="#editModel">
                            <i class="far fa-edit fa-2x"></i>
                       </button>

                                <a data-href="'.route('dashboard.city.destroy', $city->id).'" data-id="'.$city->id.'" class="mr-2 btn btn-outline-danger btn-delete btn-sm">
                            <i class="far fa-trash-alt fa-2x"></i>
                    </a>
                                ';

                    return $html;
                })

                ->rawColumns([
                    'title',
                    'country_name',
                    'status',
                    'controll',
                ])
                ->make(true);
        }
        $countries = Country::where('active',1)->get()->pluck('title','id');
        return view('dashboard.settings.cities.index',compact('countries'));
    }

    public function create()
    {
        return view('dashboard.settings.cities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_ar' => 'required|String|min:3',
            'title_en' => 'required|String|min:3',
            'country_id' => 'required|exists:countries,id',

        ]);

        $data=$request->except('_token');

        City::updateOrCreate($data);

        session()->flash('success');
        return redirect()->back();
    }

    public function edit($id)
    {
        $city = City::where('id',$id)->first();
        return view('dashboard.setting.cities.edit', compact( 'city'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title_ar' => 'required',
            'title_en' => 'required',
            'country_id' => 'required|exists:countries,id',

        ]);
        $data=$request->except('_token');


        $city = City::find($id);

        $city->update($data);
        session()->flash('success');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $city = City::find($id);
        $city->delete();
        return [
            'success' => true,
            'msg' => __("dash.deleted_success")
        ];
    }

    public function change_status(Request $request){
        $admin = City::where('id',$request->id)->first();
        if ($request->active == 'true'){
            $active = 1;
        }else{
            $active = 0;
        }

        $admin->active = $active;
        $admin->save();
        return response()->json(['sucess'=>true]);
    }
}
