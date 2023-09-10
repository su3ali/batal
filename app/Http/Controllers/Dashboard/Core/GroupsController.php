<?php

namespace App\Http\Controllers\Dashboard\Core;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Group;
use App\Models\GroupRegion;
use App\Models\GroupTechnician;
use App\Models\Region;
use App\Models\Technician;
use App\Traits\imageTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;


class GroupsController extends Controller
{
    use imageTrait;

    public function index()
    {
        $technicians = Technician::all();
        if (request()->ajax()) {
            $groups = Group::where('active',1)->get();
            return DataTables::of($groups)
                ->addColumn('technician', function ($row) {
                    return $row->technician_id ? Technician::query()->find($row->technician_id)?Technician::query()->find($row->technician_id)->name : 'لا يوجد': 'لا يوجد' ;
                })
                ->addColumn('g_name', function ($row){
                    return $row->name;
                })
                ->addColumn('status', function ($row) {
                    $checked = '';
                    if ($row->active == 1) {
                        $checked = 'checked';
                    }
                    return '<label class="switch s-outline s-outline-info  mb-4 mr-2">
                        <input type="checkbox" id="customSwitch4" data-id="' . $row->id . '" ' . $checked . '>
                        <span class="slider round"></span>
                        </label>';
                })
                ->addColumn('control', function ($row) {

                    $html = '
                                <button type="button" id="edit-techGroup" class="btn btn-primary btn-sm card-tools edit" data-id="'.$row->id.'"  data-name_ar="'.$row->name_ar.'" data-name_en="'.$row->name_en.'"
                                 data-technician_id="'.$row->technician_id.'" data-technician_group_id="'.$row->technician_groups->pluck('technician_id').'" data-region_id="'.$row->regions->pluck('region_id').'" data-country_id="'.$row->country_id.'" data-city_id="'.$row->city_id.'"
                                  data-toggle="modal" data-target="#editGroupTechModel">
                            <i class="far fa-edit fa-2x"></i>
                       </button>

                                <a data-table_id="html5-extension" data-href="'.route('dashboard.core.group.destroy', $row->id).'" data-id="' . $row->id . '" class="mr-2 btn btn-outline-danger btn-sm btn-delete btn-sm delete_tech">
                            <i class="far fa-trash-alt fa-2x"></i>
                    </a>
                                ';
                    return $html;
                })
                ->rawColumns([
                    'technician',
                    'g_name',
                    'status',
                    'control',
                ])
                ->make(true);
        }
        $countries = Country::where('active',1)->get()->pluck('title','id');
        $cities = City::where('active',1)->get()->pluck('title','id');
        $regions = Region::where('active',1)->get()->pluck('title','id');

        return view('dashboard.core.groups.index', compact('technicians','countries','cities','regions'));
    }

    /**
     * @throws ValidationException
     */
    protected function store(Request $request): RedirectResponse
    {

        $request->validate([
            'name_en' => 'required|String|min:3|unique:groups,name_en',
            'name_ar' => 'required|String|min:3|unique:groups,name_ar',
            'technician_id' => 'nullable|exists:technicians,id',
            'technician_group_id' => 'required|array|exists:technicians,id',
            'technician_group_id.*' => 'required',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'region_id' => 'required|array|exists:regions,id',
            'region_id.*' => 'required',
        ]);

        $data = $request->except('_token', 'technician_group_id','region_id');
        $group = Group::query()->create($data);
        foreach ($request->technician_group_id as $tehcn){
            GroupTechnician::create([
                'group_id' => $group->id,
                'technician_id' => $tehcn,
            ]);
        }


        foreach ($request->region_id as $region){
            GroupRegion::create([
                'group_id' => $group->id,
                'region_id' => $region,
            ]);
        }

        session()->flash('success');
        return redirect()->back();
    }
    protected function update(Request $request, $id){
//        dd($request->all());
        $group = Group::query()->where('id', $id)->first();


        $request->validate([
            'name_en' => 'required|String|min:3|unique:groups,name_en,'.$id,
            'name_ar' => 'required|String|min:3|unique:groups,name_ar,'.$id,
            'technician_id' => 'nullable|exists:technicians,id',
            'technician_group_id' => 'required|array|exists:technicians,id',
            'technician_group_id.*' => 'required',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'region_id' => 'required|array|exists:regions,id',
            'region_id.*' => 'required',
        ]);


        $data = $request->except('_token', 'technician_group_id','region_id');

        $group->update($data);
        GroupTechnician::where('group_id',$id)->delete();
        foreach ($request->technician_group_id as $tehcn){
            GroupTechnician::create([
                'group_id' => $group->id,
                'technician_id' => $tehcn,
            ]);
        }

        GroupRegion::where('group_id',$id)->delete();

        foreach ($request->region_id as $region){
            GroupRegion::create([
                'group_id' => $group->id,
                'region_id' => $region,
            ]);
        }
        session()->flash('success');
        return redirect()->back();
    }

    protected function destroy($id)
    {
        $group = Group::query()->find($id);
        $group->delete();
        return [
            'success' => true,
            'msg' => __("dash.deleted_success")
        ];
    }


    public function change_status(Request $request)
    {
        $admin = Group::where('id', $request->id)->first();
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
