<?php

namespace App\Http\Controllers\Dashboard\Core;


use App\Http\Controllers\Controller;
use App\Models\Measurement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class MeasurementsController extends Controller{

    public function index()
    {
        if (request()->ajax()) {
            $measures = Measurement::all();
            return DataTables::of($measures)
                ->addColumn('name', function ($row) {
                    return $row->name;
                })->addColumn('symbol', function ($row) {
                    return $row->symbol;
                })
                ->addColumn('status', function ($row) {
                    $checked = '';
                    if ($row->is_float == 1) {
                        $checked = 'checked';
                    }
                    return '<label class="switch s-outline s-outline-info  mb-4 mr-2">
                        <input type="checkbox" id="customSwitchStatus" data-id="' . $row->id . '" ' . $checked . '>
                        <span class="slider round"></span>
                        </label>';
                })
                ->addColumn('control', function ($row) {

                    $html = '
                                <button type="button" id="edit-measure-status" class="btn btn-primary btn-sm card-tools edit" data-id="'.$row->id.'"
                                 data-name_ar="'.$row->name_ar.'" data-name_en="'.$row->name_en.'"
                                  data-symbol_ar="'.$row->symbol_ar.'" data-symbol_en="'.$row->symbol_en.'"
                                  data-toggle="modal" data-target="#editMeasureModel">
                            <i class="far fa-edit fa-2x"></i>
                       </button>

                                <a data-table_id="html5-extension" data-href="'.route('dashboard.core.measurements.destroy', $row->id).'" data-id="' . $row->id . '" class="mr-2 btn btn-outline-danger btn-sm btn-delete btn-sm delete_tech">
                            <i class="far fa-trash-alt fa-2x"></i>
                    </a>
                                ';

                    return $html;
                })
                ->rawColumns([
                    'name',
                    'symbol',
                    'status',
                    'control',
                ])
                ->make(true);
        }

        return view('dashboard.core.measures.index');
    }

    /**
     * @throws ValidationException
     */
    protected function store(Request $request): RedirectResponse
    {
        $rules = [
            'name_ar' => 'required|String|unique:measurements,name_ar',
            'name_en' => 'required|String|unique:measurements,name_en',
            'symbol_ar' => 'nullable|String',
            'symbol_en' => 'nullable|String',
        ];
        $validated = Validator::make($request->all(), $rules);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated->errors());
        }
        $validated = $validated->validated();
        Measurement::query()->create($validated);
        session()->flash('success');
        return redirect()->back();
    }
    protected function update(Request $request, $id){
        $measurement = Measurement::query()->where('id', $id)->first();
        $rules = [
            'name_ar' => 'required|unique:measurements,name_ar,'.$id,
            'name_en' => 'required|unique:measurements,name_en,'.$id,
            'symbol_ar' => 'nullable|String',
            'symbol_en' => 'nullable|String',
        ];
        $validated = Validator::make($request->all(), $rules);
        if ($validated->fails()) {
            return redirect()->back()->with('errors', $validated->errors());
        }
        $validated = $validated->validated();
        $measurement->update($validated);
        session()->flash('success');
        return redirect()->back();
    }

    protected function destroy($id)
    {
        $measurement = Measurement::find($id);
        $measurement->delete();
        return [
            'success' => true,
            'msg' => __("dash.deleted_success")
        ];
    }
    protected function change_status (Request $request){
        $measure = Measurement::query()->where('id', $request->id)->first();
        if ($request->active == "false"){
            $measure->is_float = 0;
        }else{
            $measure->is_float = 1;
        }
        $measure->save();
        return response('success');
    }

}
