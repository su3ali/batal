<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;


class CountryController extends Controller
{
    public function index()
    {

        if (request()->ajax()) {

            $country = Country::all();

            return DataTables::of($country)
                ->addColumn('title', function ($country) {
                    return $country->title;
                })
                ->addColumn('status', function ($country) {
                    $checked = '';
                    if ($country->active == 1){
                        $checked = 'checked';
                    }
                    return '<label class="switch s-outline s-outline-info  mb-4 mr-2">
                        <input type="checkbox" id="customSwitch4" data-id="' . $country->id . '" ' . $checked . '>
                        <span class="slider round"></span>
                        </label>';
                })
                ->addColumn('controll', function ($country) {

                    $html = '
                    
                                <button type="button" id="add-work-exp" class="btn btn-sm btn-primary card-tools edit" data-id="'.$country->id.'"  data-title_ar="'.$country->title_ar.'"
                                 data-title_en="'.$country->title_en.'" data-toggle="modal" data-target="#editModel">
                            <i class="far fa-edit fa-2x"></i>
                       </button>

                                <a data-href="'.route('dashboard.country.destroy', $country->id).'" data-id="'.$country->id.'" class="mr-2 btn btn-outline-danger btn-delete btn-sm">
                            <i class="far fa-trash-alt fa-2x"></i>
                    </a>
                                ';

                    return $html;
                })

                ->rawColumns([
                    'title',
                    'status',
                    'controll',
                ])
                ->make(true);
        }

        return view('dashboard.settings.countries.index');
    }

    public function create()
    {
        return view('dashboard.settings.countries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_ar' => 'required|String|min:3',
            'title_en' => 'required|String|min:3',
        ]);

        $data=$request->except('_token');

        Country::updateOrCreate($data);

        session()->flash('success');
        return redirect()->back();
    }

    public function edit($id)
    {
        $country = Country::where('id',$id)->first();
        return view('dashboard.setting.countries.edit', compact( 'country'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title_ar' => 'required',
            'title_en' => 'required',
        ]);
        $data=$request->except('_token');


        $country = Country::find($id);

        $country->update($data);
        session()->flash('success');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $country = Country::find($id);
        $country->delete();
        return [
            'success' => true,
            'msg' => __("dash.deleted_success")
        ];
    }

    public function change_status(Request $request){
        $admin = Country::where('id',$request->id)->first();
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
