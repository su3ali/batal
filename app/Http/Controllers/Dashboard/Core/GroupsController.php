<?php

namespace App\Http\Controllers\Dashboard\Core;

use App\Http\Controllers\Controller;
use App\Models\Group;
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
            $groups = Group::all();
            return DataTables::of($groups)
                ->addColumn('technician', function ($row) {
                    return Technician::query()->find($row->technician_id)->name;
                })
                ->addColumn('g_name', function ($row){
                    return $row->name;
                })
                ->addColumn('control', function ($row) {

                    $html = '
                                <button type="button" id="edit-techGroup" class="btn btn-primary btn-sm card-tools edit" data-id="'.$row->id.'"  data-name_ar="'.$row->name_ar.'" data-name_en="'.$row->name_en.'"
                                 data-technician_id="'.$row->technician_id.'"
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
                    'control',
                ])
                ->make(true);
        }
        return view('dashboard.core.groups.index', compact('technicians'));
    }

    /**
     * @throws ValidationException
     */
    protected function store(Request $request): RedirectResponse
    {
        $rules = [
            'name_en' => 'required|String|min:3|unique:groups,name_en',
            'name_ar' => 'required|String|min:3|unique:groups,name_ar',
            'technician_id' => 'required|exists:technicians,id',
        ];
        $validated = Validator::make($request->all(), $rules);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated->errors());
        }
        $validated = $validated->validated();

        Group::query()->create($validated);
        session()->flash('success');
        return redirect()->back();
    }
    protected function update(Request $request, $id){
        $group = Group::query()->where('id', $id)->first();
        $rules = [
            'name_en' => 'required|String|min:3|unique:groups,name_en,'.$id,
            'name_ar' => 'required|String|min:3|unique:groups,name_ar,'.$id,
            'technician_id' => 'required|exists:technicians,id',
        ];
        $validated = Validator::make($request->all(), $rules);
        if ($validated->fails()) {
            return redirect()->back()->with('errors', $validated->errors());
        }
        $validated = $validated->validated();

        $group->update($validated);
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

}
