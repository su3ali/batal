<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;


class RegionController extends Controller
{
    public function index()
    {

        if (request()->ajax()) {

            $region = Region::all();

            return DataTables::of($region)
                ->addColumn('title', function ($region) {
                    return $region->title;
                })
                ->addColumn('city_name', function ($region) {
                    return $region->city?->title;
                })
                ->addColumn('status', function ($region) {
                    $checked = '';
                    if ($region->active == 1){
                        $checked = 'checked';
                    }
                    return '<label class="switch s-outline s-outline-info  mb-4 mr-2">
                        <input type="checkbox" id="customSwitch4" data-id="' . $region->id . '" ' . $checked . '>
                        <span class="slider round"></span>
                        </label>';
                })
                ->addColumn('controll', function ($region) {

                    $html = '

                    <a href="'.route('dashboard.region.edit', $region->id).'"  class="mr-2 btn btn-sm btn-primary">
                            <i class="far fa-edit fa-2x"></i>
                    </a>



                                <a data-href="'.route('dashboard.region.destroy', $region->id).'" data-id="'.$region->id.'" class="mr-2 btn btn-outline-danger btn-delete btn-sm">
                            <i class="far fa-trash-alt fa-2x"></i>
                    </a>
                                ';

                    return $html;
                })

                ->rawColumns([
                    'title',
                    'city_name',
                    'status',
                    'controll',
                ])
                ->make(true);
        }
        return view('dashboard.settings.regions.index');
    }

    public function create()
    {
        $cities = City::where('active',1)->get()->pluck('title','id');

        return view('dashboard.settings.regions.create',compact('cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_ar' => 'required|String|min:3',
            'title_en' => 'required|String|min:3',
            'city_id' => 'required|exists:cities,id',
            'space_km' => 'required|numeric',
            'lat' => 'required',
            'lon' => 'required',

        ]);

        $data=$request->except('_token');

        Region::updateOrCreate($data);

        session()->flash('success');
        return redirect()->route('dashboard.region.index');
    }

    public function edit($id)
    {
        $region = Region::where('id',$id)->first();
        $cities = City::where('active',1)->get()->pluck('title','id');
        return view('dashboard.settings.regions.edit', compact( 'region','cities'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title_ar' => 'required',
            'title_en' => 'required',
            'city_id' => 'required|exists:cities,id',
            'space_km' => 'required|numeric',
            'lat' => 'required',
            'lon' => 'required',
        ]);
        $data=$request->except('_token');


        $region = Region::find($id);

        $region->update($data);
        session()->flash('success');
        return redirect()->route('dashboard.region.index');

    }

    public function destroy($id)
    {
        $region = Region::find($id);
        $region->delete();
        return [
            'success' => true,
            'msg' => __("dash.deleted_success")
        ];
    }

    public function change_status(Request $request){
        $admin = Region::where('id',$request->id)->first();
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
