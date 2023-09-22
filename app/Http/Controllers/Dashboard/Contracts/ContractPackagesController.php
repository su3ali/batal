<?php

namespace App\Http\Controllers\Dashboard\Contracts;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingStatus;
use App\Models\ContractPackage;
use App\Models\Group;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use App\Traits\imageTrait;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\ValidationException;


class ContractPackagesController extends Controller
{
    use imageTrait;
    public function index()
    {
        if (request()->ajax()) {
            $ContractPackage = ContractPackage::query()->get();
            return DataTables::of($ContractPackage)
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('service name', function ($row) {
                    return $row->service?->title;
                })
                ->addColumn('visit_number', function ($row) {
                    return $row->visit_number;
                })
                ->addColumn('status', function ($row) {
                    $checked = '';
                    if ($row->active == 1){
                        $checked = 'checked';
                    }
                    return '<label class="switch s-outline s-outline-info  mb-4 mr-2">
                        <input type="checkbox" id="customSwitchStatus" data-id="' . $row->id . '" ' . $checked . '>
                        <span class="slider round"></span>
                        </label>';
                })
                ->addColumn('control', function ($row) {
                    $html = '
                    <a href="'.route('dashboard.contract_packages.edit', $row->id).'"  id="edit-booking" class="btn btn-primary btn-sm card-tools edit" data-id="' . $row->id . '"
                          >
                            <i class="far fa-edit fa-2x"></i>
                       </a>

                                <a data-table_id="html5-extension" data-href="' . route('dashboard.contract_packages.destroy', $row->id) . '" data-id="' . $row->id . '" class="mr-2 btn btn-outline-danger btn-sm btn-delete btn-sm delete_tech">
                            <i class="far fa-trash-alt fa-2x"></i>
                    </a>';
                    return $html;
                })
                ->rawColumns([
                    'name',
                    'service name',
                    'visit_number',
                    'status',
                    'control'
                ])
                ->make(true);
        }

        return view('dashboard.contract_packages.index');
    }

    protected function create()
    {
        $services = Service::where('active',1)->get()->pluck('title','id');

        return view('dashboard.contract_packages.create',compact('services'));
    }

    /**
     * @throws ValidationException
     */
    protected function store(Request $request): RedirectResponse
    {
        $request->validate = ([
            'name_ar' => 'required',
            'name_en' => 'required',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png,gif',
            'description_ar' => 'required',
            'description_en' => 'required',
            'service_id' => 'required|exists:services,id',
            'price' => 'required|numeric',
            'time' => 'required|string',
            'visit_number' => 'required|numeric',

        ]);
        $data=$request->except('_token','avatar');

        if ($request->has('avatar')){
            $image=$this->storeImages($request->avatar,'contract_packages');
            $data['image']= 'storage/images/contract_packages'.'/'.$image;
        }

        ContractPackage::updateOrCreate($data);

        session()->flash('success');
        return redirect()->route('dashboard.contract_packages.index');
    }

    protected function edit($id){
        $ContractPackage = ContractPackage::query()->where('id', $id)->first();
        $services = Service::where('active',1)->get()->pluck('title','id');

        return view('dashboard.contract_packages.edit', compact('ContractPackage','services'));

    }
    protected function update(Request $request, $id)
    {
        $request->validate = ([
            'name_ar' => 'required',
            'name_en' => 'required',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png,gif',
            'description_ar' => 'required',
            'description_en' => 'required',
            'service_id' => 'required|exists:services,id',
            'price' => 'required|numeric',
            'time' => 'required|string',
            'visit_number' => 'required|numeric',

        ]);
        $ContractPackage = ContractPackage::find($id);
        $data=$request->except('_token','avatar');

        if ($request->has('avatar')){
            $image=$this->storeImages($request->avatar,'contract_packages');
            $data['image']= 'storage/images/contract_packages'.'/'.$image;
        }
        $ContractPackage->update($data);

        session()->flash('success');
        return redirect()->route('dashboard.contract_packages.index');
    }

    protected function destroy($id)
    {
        $ContractPackage = ContractPackage::query()->find($id);
        $ContractPackage->delete();
        return [
            'success' => true,
            'msg' => __("dash.deleted_success")
        ];
    }

    protected function change_status(Request $request)
    {
        $ContractPackage = ContractPackage::query()->where('id', $request->id)->first();
        if ($request->active == "false") {
            $ContractPackage->active = 0;
        } else {
            $ContractPackage->active = 1;
        }
        $ContractPackage->save();
        return response('success');
    }

}
