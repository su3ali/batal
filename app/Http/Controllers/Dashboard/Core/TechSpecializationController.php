<?php
namespace App\Http\Controllers\Dashboard\Core;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use App\Models\Technician;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class TechSpecializationController extends Controller{
    public function index()
    {
        if (request()->ajax()) {
            $specs = Specialization::all();
            return DataTables::of($specs)
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
                                <button type="button" id="edit-spec-status" class="btn btn-primary btn-sm card-tools edit" data-id="'.$row->id.'"
                                 data-name_ar="'.$row->name_ar.'" data-name_en="'.$row->name_en.'"
                                  data-description_ar="'.$row->description_ar.'" data-description_en="'.$row->description_en.'"
                                  data-toggle="modal" data-target="#editSpecModel">
                            <i class="far fa-edit fa-2x"></i>
                       </button>

                                <a data-table_id="html5-extension" data-href="'.route('dashboard.core.tech_specializations.destroy', $row->id).'" data-id="' . $row->id . '" class="mr-2 btn btn-outline-danger btn-sm btn-delete btn-sm delete_tech">
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

        return view('dashboard.core.tech_specializations.index');
    }

    /**
     * @throws ValidationException
     */
    protected function store(Request $request): RedirectResponse
    {
        $rules = [
            'name_ar' => 'required||String|unique:specializations,name_ar',
            'name_en' => 'required||String|unique:specializations,name_en',
            'description_ar' => 'nullable|String',
            'description_en' => 'nullable|String',
        ];
        $validated = Validator::make($request->all(), $rules);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated->errors());
        }
        $validated = $validated->validated();
        Specialization::query()->create($validated);
        session()->flash('success');
        return redirect()->back();
    }
    protected function update(Request $request, $id){
        $spec = Specialization::query()->where('id', $id)->first();
        $rules = [
            'name_ar' => 'required|unique:specializations,name_ar,'.$id,
            'name_en' => 'required|unique:specializations,name_en,'.$id,
            'description_ar' => 'nullable|String',
            'description_en' => 'nullable|String',
        ];
        $validated = Validator::make($request->all(), $rules);
        if ($validated->fails()) {
            return redirect()->back()->with('errors', $validated->errors());
        }
        $validated = $validated->validated();
        $spec->update($validated);
        session()->flash('success');
        return redirect()->back();
    }

    protected function destroy($id)
    {
        $spec = Specialization::find($id);
        if (in_array($id, Technician::query()->pluck('spec_id')->toArray())){
            return response()->json(['success' => false,
                'msg' => 'حذف التخصص غير متاح لارتباطه بفني'
            ]);
        }
        $spec->delete();
        return [
            'success' => true,
            'msg' => __("dash.deleted_success")
        ];
    }
    protected function change_status (Request $request){
        $spec = Specialization::query()->where('id', $request->id)->first();
        if ($request->active == "false"){
            $spec->active = 0;
        }else{
            $spec->active = 1;
        }
        $spec->save();
        return response('success');
    }
}
