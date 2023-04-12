<?php

namespace App\Http\Controllers\Dashboard\Contracts;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingStatus;
use App\Models\Contract;
use App\Models\ContractPackage;
use App\Models\Group;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\ValidationException;


class ContractController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            $contracts = Contract::query()->get();
            return DataTables::of($contracts)
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('package name', function ($row) {
                    return $row->package?->name;
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
                    <a href="'.route('dashboard.contracts.edit', $row->id).'"  id="edit-booking" class="btn btn-primary btn-sm card-tools edit" data-id="' . $row->id . '"
                          >
                            <i class="far fa-edit fa-2x"></i>
                       </a>

                                <a data-table_id="html5-extension" data-href="' . route('dashboard.contracts.destroy', $row->id) . '" data-id="' . $row->id . '" class="mr-2 btn btn-outline-danger btn-sm btn-delete btn-sm delete_tech">
                            <i class="far fa-trash-alt fa-2x"></i>
                    </a>';
                    return $html;
                })
                ->rawColumns([
                    'name',
                    'package name',
                    'status',
                    'control'
                ])
                ->make(true);
        }

        return view('dashboard.contracts.index');
    }

    protected function create()
    {
        $ContractPackages = ContractPackage::where('active',1)->get()->pluck('name','id');

        return view('dashboard.contracts.create',compact('ContractPackages'));
    }

    /**
     * @throws ValidationException
     */
    protected function store(Request $request): RedirectResponse
    {
        $request->validate = ([
            'name_ar' => 'required',
            'name_en' => 'required',
            'package_id' => 'required|exists:contract_packages,id',
            'start_date' => 'required|Date',
            'end_date' => 'required|Date',

        ]);
        $data=$request->except('_token',);
        Contract::updateOrCreate($data);
        session()->flash('success');
        return redirect()->route('dashboard.contracts.index');
    }

    protected function edit($id){
        $contract = Contract::query()->where('id', $id)->first();
        $ContractPackages = ContractPackage::where('active',1)->get()->pluck('name','id');

        return view('dashboard.contracts.edit', compact('contract','ContractPackages'));

    }
    protected function update(Request $request, $id)
    {
        $request->validate = ([
            'name_ar' => 'required',
            'name_en' => 'required',
            'package_id' => 'required|exists:contract_packages,id',
            'start_date' => 'required|Date',
            'end_date' => 'required|Date',

        ]);
        $Contract = Contract::find($id);
        $data=$request->except('_token','avatar');
        $Contract->update($data);
        session()->flash('success');
        return redirect()->route('dashboard.contracts.index');
    }

    protected function destroy($id)
    {
        $contract = Contract::query()->find($id);
        $contract->delete();
        return [
            'success' => true,
            'msg' => __("dash.deleted_success")
        ];
    }

    protected function change_status(Request $request)
    {
        $contracts = Contract::query()->where('id', $request->id)->first();
        if ($request->active == "false") {
            $contracts->active = 0;
        } else {
            $contracts->active = 1;
        }
        $contracts->save();
        return response('success');
    }

}
