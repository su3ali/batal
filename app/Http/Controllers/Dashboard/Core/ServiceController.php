<?php

namespace App\Http\Controllers\Dashboard\Core;

use App\Enums\Core\ServiceType;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Models\ServiceImages;
use App\Traits\imageTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;


class ServiceController extends Controller
{
    use imageTrait;
    public function index()
    {

        if (request()->ajax()) {

            $service = Service::all();

            return DataTables::of($service)
                ->addColumn('title', function ($service) {
                    return $service->title;
                })
                ->addColumn('status', function ($service) {
                    $checked = '';
                    if ($service->active == 1){
                        $checked = 'checked';
                    }
                    return '<label class="switch s-outline s-outline-info  mb-4 mr-2">
                        <input type="checkbox" id="customSwitch4" data-id="' . $service->id . '" ' . $checked . '>
                        <span class="slider round"></span>
                        </label>';
                })
                ->addColumn('controll', function ($service) {

                    $html = '
                    
                    <button type="button" id="add-work-exp" class="btn btn-primary btn-sm card-tools image" data-id="'.$service->id.'" data-toggle="modal" data-target="#imageModel">
                            <i class="far fa-image fa-2x"></i>
                       </button>
                  
                                <button type="button" id="add-work-exp" class="btn btn-primary btn-sm card-tools edit" data-id="'.$service->id.'"  data-title_ar="'.$service->title_ar.'"
                                 data-title_en="'.$service->title_en.'" data-des_ar="'.$service->description_ar.'" data-des_en="'.$service->description_en.'" data-ter_ar="'.$service->ter_cond_ar.'" data-ter_en="'.$service->ter_cond_en.'"
                                  data-category_id="'.$service->category_id.'" data-price="'.$service->price.'" data-type="'.$service->type.'" data-start="'.$service->start_from.'" data-toggle="modal" data-target="#editModel">
                            <i class="far fa-edit fa-2x"></i>
                       </button>

                                <a data-href="'.route('dashboard.core.service.destroy', $service->id).'" data-id="'.$service->id.'" class="mr-2 btn btn-outline-danger btn-delete btn-sm">
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
        $categories = category::whereNull('parent_id')->where('active',1)->get()->pluck('title','id');

        return view('dashboard.core.services.index',compact('categories'));
    }

    public function create()
    {
        return view('dashboard.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_ar' => 'required|String|min:3',
            'title_en' => 'required|String|min:3',
            'description_ar' => 'required|String|min:3',
            'description_en' => 'required|String|min:3',
            'ter_cond_ar' => 'required|String|min:3',
            'ter_cond_en' => 'required|String|min:3',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|Numeric',
            'type' => 'required',
            'start_from' => 'nullable|Numeric',
        ]);

        $data=$request->except('_token');

        Service::updateOrCreate($data);

        session()->flash('success');
        return redirect()->back();
    }

    public function edit($id)
    {
        $service = Service::where('id',$id)->first();
        return view('dashboard.services.edit', compact( 'service'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title_ar' => 'required|String|min:3',
            'title_en' => 'required|String|min:3',
            'description_ar' => 'required|String|min:3',
            'description_en' => 'required|String|min:3',
            'ter_cond_ar' => 'required|String|min:3',
            'ter_cond_en' => 'required|String|min:3',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|Numeric',
            'type' => 'required',
            'start_from' => 'nullable|Numeric',
        ]);
        $data=$request->except('_token');


        $service = Service::find($id);

        $service->update($data);
        session()->flash('success');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $service = Service::find($id);
        $service->delete();
        return [
            'success' => true,
            'msg' => __("dash.deleted_success")
        ];
    }

    public function change_status(Request $request){
        $admin = Service::where('id',$request->id)->first();
        if ($request->active == 'true'){
            $active = 1;
        }else{
            $active = 0;
        }

        $admin->active = $active;
        $admin->save();
        return response()->json(['sucess'=>true]);
    }


    public function uploadImage(Request $request){

        $request->validate([
            'file' => 'required',
            'service_id' => 'required',
        ]);

        if ($request->has('file')){
            $image=$this->storeImages($request->file,'service');
            $image= 'storage/images/service'.'/'.$image;
        }

        ServiceImages::create([
            'image' =>$image,
            'service_id' =>$request->service_id,
        ]);
        $serviceImage = ServiceImages::where('service_id',$request->service_id)->latest()->first();

        return response()->json($serviceImage);

    }

    public function getImage(Request $request){
        $request->validate([
            'id' => 'required',
        ]);

        $service = Service::find($request->id);
        if (!$service) {
            return response()->json('error');
        }
        return response()->json($service->serviceImages);

    }

    public function deleteImage(Request $request){
        $request->validate([
            'id' => 'required',
        ]);
        $image = ServiceImages::find($request->id);

        if (File::exists(public_path($image->image))) {
            File::delete(public_path($image->image));
        }
        $image->delete();
        return response()->json('success');
    }
}
