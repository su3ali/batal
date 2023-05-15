<?php

namespace App\Http\Controllers\Dashboard\Visits;

use App\Http\Controllers\Controller;
use App\Models\ReasonCancel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ReasonCancelController extends Controller
{
    protected function index()
    {
        if (request()->ajax()) {
            $banners = ReasonCancel::all();
            return DataTables::of($banners)
                ->addColumn('reason', function ($row) {
                    return $row->reason;
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

                                <button type="button" id="add-work-exp" class="btn btn-sm btn-primary card-tools edit" data-id="' . $row->id . '"  data-reason_ar="' . $row->reason_ar . '"
                                 data-reason_en="' . $row->reason_en . '" data-toggle="modal" data-target="#editBookingStatusModel">
                            <i class="far fa-edit fa-2x"></i>
                       </button>

                                <a data-href="' . route('dashboard.reason_cancel.destroy', $row->id) . '" data-id="' . $row->id . '" class="mr-2 btn btn-outline-danger btn-delete btn-sm">
                            <i class="far fa-trash-alt fa-2x"></i>
                    </a>
                                ';

                    return $html;
                })
                ->rawColumns([
                    'title',
                    'status',
                    'control',
                ])
                ->make(true);
        }
        return view('dashboard.reason_cancel.index');
    }
    protected function store(Request $request){
        $rules = [
            'reason_ar' => 'required|String|min:3|max:100',
            'reason_en' => 'required|String|min:3|max:100'
        ];
        $validated = Validator::make($request->all(), $rules);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated->errors());
        }
        $validated = $validated->validated();
        ReasonCancel::query()->create($validated);
        session()->flash('success');
        return redirect()->back();
    }
    protected function update(Request $request, $id){
        $banner = ReasonCancel::query()->where('id', $id)->first();
        $rules = [
            'reason_ar' => 'required|String|min:3|max:100',
            'reason_en' => 'required|String|min:3|max:100'
        ];
        $validated = Validator::make($request->all(), $rules);
        if ($validated->fails()) {
            return redirect()->back()->with('errors', $validated->errors());
        }
        $validated = $validated->validated();
        $banner->update($validated);
        session()->flash('success');
        return redirect()->back();
    }
    protected function destroy($id)
    {
        $booking = ReasonCancel::query()->find($id);
        $booking->delete();
        return [
            'success' => true,
            'msg' => __("dash.deleted_success")
        ];
    }
    protected function change_status (Request $request){
        $banner = ReasonCancel::query()->where('id', $request->id)->first();
        if ($request->active == "false"){
            $banner->active = 0;
        }else{
            $banner->active = 1;
        }
        $banner->save();
        return response('success');
    }

}
