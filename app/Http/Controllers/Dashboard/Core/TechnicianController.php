<?php

namespace App\Http\Controllers\Dashboard\Core;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Group;
use App\Models\Specialization;
use App\Models\Technician;
use App\Traits\imageTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;


class TechnicianController extends Controller
{
    use imageTrait;

    public function index()
    {
        $groups = Group::where('active',1)->get();
        $specs = Specialization::all();
        if (request()->ajax()) {
            $technician = Technician::all();
            return DataTables::of($technician)
                ->addColumn('group', function ($row) {
                    return Group::query()->find($row->group_id)?->name;
                })
                ->addColumn('spec', function ($row) {
                    return $row->specialization?->name;
                })
                ->addColumn('t_image', function ($row) {
                    return '<img class="img-fluid" style="width: 85px;" src="'.asset($row->image).'"/>';
                })
                ->addColumn('status', function ($row) {
                    $checked = '';
                    if ($row->active == 1) {
                        $checked = 'checked';
                    }
                    return '<label class="switch s-outline s-outline-info  mb-4 mr-2">
                        <input type="checkbox" id="customSwitchtech" data-id="' . $row->id . '" ' . $checked . '>
                        <span class="slider round"></span>
                        </label>';
                })
                ->addColumn('control', function ($row) {
                    $html = '<button type="button" id="edit-tech" class="btn btn-primary btn-sm card-tools edit" data-id="'.$row->id.'"  data-name="'.$row->name.'" data-user_name="'.$row->user_name.'"
                                 data-email="'.$row->email.'" data-phone="'.$row->phone.'" data-specialization="'.$row->spec_id.'"
                                 data-active="'.$row->active.'" data-group_id="'.$row->group_id.'"
                                  data-country_id="'.$row->country_id.'" data-address="'.$row->address.'" data-wallet_id="'.$row->wallet_id.'"
                                  data-birth_date="'.$row->birth_date.'" data-identity_number="'.$row->identity_id.'" data-image="'.asset($row->image).'"
                                  data-toggle="modal" data-target="#editTechModel">
                            <i class="far fa-edit fa-2x"></i>
                       </button><a data-table_id="html5-extension" data-href="'.route('dashboard.core.technician.destroy', $row->id).'" data-id="' . $row->id . '" class="mr-2 btn btn-outline-danger btn-sm btn-delete btn-sm delete_tech"><i class="far fa-trash-alt fa-2x"></i></a>';

                    return $html;
                })
                ->rawColumns([
                    'group',
                    'spec',
                    't_image',
                    'status',
                    'control'
                ])
                ->make(true);
        }

        return view('dashboard.core.technicians.index', compact('groups', 'specs'));
    }

    /**
     * @throws ValidationException
     */
    protected function store(Request $request): RedirectResponse
    {

        $rules = [
            'name' => 'required|String|min:3',
            'email' => 'required|Email|unique:technicians,email',
            'phone' => 'required|unique:technicians,phone',
            'user_name' => ['required', 'regex:/^[^\s]+$/', 'unique:technicians,user_name'],
            'password' => ['required', 'confirmed', Password::min(4)],
            'spec_id' => 'required|exists:specializations,id',
            'country_id' => 'required',
            'identity_id' => 'required|Numeric',
            'birth_date' => 'required|Date',
            'wallet_id' => 'required',
            'address' => 'required|String',
            'group_id' => 'nullable',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif',
            'active' => 'nullable|in:on,off',
        ];
        $validated = Validator::make($request->all(), $rules, [ 'user_name.regex' => 'يجب أن لا يحتوي اسم المستخدم على أي مسافات']);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated->errors());
        }
        $validated = $validated->validated();
        if ($validated['active'] && $validated['active'] == 'on'){
            $validated['active'] = 1;
        }else{
            $validated['active'] = 0;
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move(storage_path('app/public/images/technicians/'), $filename);
            $validated['image'] = 'storage/images/technicians'.'/'. $filename;
        }
        Technician::query()->create($validated);
        session()->flash('success');
        return redirect()->back();
    }
    protected function update(Request $request, $id){
        $tech = Technician::query()->where('id', $id)->first();
        $rules = [
            'name' => 'required|String|min:3',
            'email' => 'required|Email|unique:technicians,email,'.$id,
            'phone' => 'required|unique:technicians,phone,'.$id,
            'user_name' => ['required', 'regex:/^[^\s]+$/', 'unique:technicians,user_name,'.$id],
            'spec_id' => 'required|exists:specializations,id',
            'country_id' => 'required',
            'identity_id' => 'required|Numeric',
            'birth_date' => 'required|Date',
            'wallet_id' => 'required',
            'address' => 'required|String',
            'group_id' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif',
            'active' => 'nullable|in:on,off',
            'password' => ['nullable', 'confirmed', Password::min(4)],
        ];
        $validated = Validator::make($request->all(), $rules, ['user_name.regex' => 'يجب أن لا يحتوي اسم المستخدم على أي مسافات']);
        if ($validated->fails()) {;
            return redirect()->to(route('dashboard.core.technician.index'))->withErrors($validated->errors());
        }
        $validated = $validated->validated();
        if ($validated['active'] && $validated['active'] == 'on'){
            $validated['active'] = 1;
        }else{
            $validated['active'] = 0;
        }
        if ($request->hasFile('image')) {
            if (File::exists(public_path($tech->image))) {
                File::delete(public_path($tech->image));
            }
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move(storage_path('app/public/images/technicians/'), $filename);
            $validated['image'] = 'storage/images/technicians'.'/'. $filename;
        }
        $tech->update($validated);
        session()->flash('success');
        return redirect()->back();
    }

    protected function destroy($id)
    {
        $tech = Technician::find($id);
        if (File::exists(public_path($tech->image))) {
            File::delete(public_path($tech->image));
        }
        $tech->delete();
        return [
            'success' => true,
            'msg' => __("dash.deleted_success")
        ];
    }
    protected function changeStatus(Request $request){
        $tech = Technician::query()->where('id', $request->id)->first();
        if ($request->active){
            $tech->active = 1;
        }else{
            $tech->active = 0;
        }
        $tech->save();
        return response('success');
    }

}
