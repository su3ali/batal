<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class FaqsController extends Controller{
    public function index()
    {
        if (request()->ajax()) {
            $faqs = Faq::all();
            return DataTables::of($faqs)
                ->addColumn('question', function ($row) {
                    return $row->q;
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
                                <button type="button" id="edit-faq" class="btn btn-primary btn-sm card-tools edit" data-id="'.$row->id.'"
                                 data-q_ar="'.$row->q_ar.'" data-q_en="'.$row->q_en.'"
                                  data-ans_ar="'.$row->ans_ar.'" data-ans_en="'.$row->ans_en.'"
                                  data-toggle="modal" data-target="#editFaqModel">
                            <i class="far fa-edit fa-2x"></i>
                       </button>

                                <a data-table_id="html5-extension" data-href="'.route('dashboard.faqs.destroy', $row->id).'" data-id="' . $row->id . '" class="mr-2 btn btn-outline-danger btn-sm btn-delete btn-sm delete_tech">
                            <i class="far fa-trash-alt fa-2x"></i>
                    </a>
                                ';

                    return $html;
                })
                ->rawColumns([
                    'question',
                    'status',
                    'control',
                ])
                ->make(true);
        }

        return view('dashboard.settings.faqs.index');
    }

    /**
     * @throws ValidationException
     */
    protected function store(Request $request): RedirectResponse
    {
        $rules = [
            'q_ar' => 'required||String|unique:faqs,q_ar',
            'q_en' => 'required||String|unique:faqs,q_en',
            'ans_ar' => 'required|String',
            'ans_en' => 'required|String',
        ];
        $validated = Validator::make($request->all(), $rules);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated->errors());
        }
        $validated = $validated->validated();
        Faq::query()->create($validated);
        session()->flash('success');
        return redirect()->back();
    }
    protected function update(Request $request, $id){
        $faq = Faq::query()->where('id', $id)->first();
        $rules = [
            'q_ar' => 'required||String|unique:faqs,q_ar,'.$id,
            'q_en' => 'required||String|unique:faqs,q_en,'.$id,
            'ans_ar' => 'required|String',
            'ans_en' => 'required|String',
        ];
        $validated = Validator::make($request->all(), $rules);
        if ($validated->fails()) {
            return redirect()->back()->with('errors', $validated->errors());
        }
        $validated = $validated->validated();
        $faq->update($validated);
        session()->flash('success');
        return redirect()->back();
    }

    protected function destroy($id)
    {
        $faq = Faq::find($id);
        $faq->delete();
        return [
            'success' => true,
            'msg' => __("dash.deleted_success")
        ];
    }
    protected function change_status (Request $request){
        $faq = Faq::query()->where('id', $request->id)->first();
        if ($request->active == "false"){
            $faq->active = 0;
        }else{
            $faq->active = 1;
        }
        $faq->save();
        return response('success');
    }
}
