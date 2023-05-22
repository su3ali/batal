<?php

namespace App\Http\Controllers\Dashboard\Banners;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\BannerImage;
use App\Traits\imageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class BannersController extends Controller
{
    use imageTrait;
    protected function index()
    {
        if (request()->ajax()) {
            $banners = Banner::all();
            return DataTables::of($banners)
                ->addColumn('title', function ($row) {
                    return $row->title;
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



                                <button type="button" id="add-work-exp" class="btn btn-sm btn-primary card-tools edit" data-id="' . $row->id . '"  data-title_ar="' . $row->title_ar . '"
                                 data-title_en="' . $row->title_en . '" data-image="'.$row->slug.'" data-toggle="modal" data-target="#editBannerModel">
                            <i class="far fa-edit fa-2x"></i>
                       </button>

                                <a data-href="' . route('dashboard.banners.destroy', $row->id) . '" data-id="' . $row->id . '" class="mr-2 btn btn-outline-danger btn-delete btn-sm">
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
        return view('dashboard.banners.index');
    }
    protected function store(Request $request){
        $rules = [
            'title_ar' => 'required|String|min:3|max:100',
            'title_en' => 'required|String|min:3|max:100',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif',
        ];
        $validated = Validator::make($request->all(), $rules);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated->errors());
        }
        $validated = $validated->validated();


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move(storage_path('app/public/images/banners/'), $filename);
            $validated['image'] = 'storage/images/banners'.'/'. $filename;
        }

        Banner::query()->create($validated);
        session()->flash('success');
        return redirect()->back();
    }
    protected function update(Request $request, $id){
        $banner = Banner::query()->where('id', $id)->first();
        $rules = [
            'title_ar' => 'required|String|min:3|max:100',
            'title_en' => 'required|String|min:3|max:100',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif',
        ];
        $validated = Validator::make($request->all(), $rules);
        if ($validated->fails()) {
            return redirect()->back()->with('errors', $validated->errors());
        }
        $validated = $validated->validated();

        if ($request->hasFile('image')) {
            if (File::exists(public_path($banner->image))) {
                File::delete(public_path($banner->image));
            }
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move(storage_path('app/public/images/banners/'), $filename);
            $validated['image'] = 'storage/images/banners'.'/'. $filename;
        }

        $banner->update($validated);
        session()->flash('success');
        return redirect()->back();
    }
    protected function change_status (Request $request){
        $banner = Banner::query()->where('id', $request->id)->first();
        if ($request->active == "false"){
            $banner->active = 0;
        }else{
            $banner->active = 1;
        }
        $banner->save();
        return response('success');
    }

    public function destroy($id)
    {
        $banner = Banner::find($id);
        $banner->delete();
        return [
            'success' => true,
            'msg' => __("dash.deleted_success")
        ];
    }

//    public function uploadImage(Request $request){
//        $request->validate([
//            'file' => 'required',
//            'banner_id' => 'required',
//        ]);
//
//        if ($request->has('file')){
//            $image=$this->storeImages($request->file,'banners');
//            $image= 'storage/images/banners'.'/'.$image;
//        }
//
//        BannerImage::create([
//            'image' =>$image,
//            'banner_id' =>$request->banner_id,
//        ]);
//        $bannerImage = BannerImage::where('banner_id',$request->banner_id)->latest()->first();
//
//        return response()->json($bannerImage);
//
//    }
//
//    public function getImage(Request $request){
//        $request->validate([
//            'id' => 'required',
//        ]);
//
//        $banner = Banner::query()->find($request->id);
//        if (!$banner) {
//            return response()->json('error');
//        }
//        return response()->json($banner->bannerImages);
//
//    }
//
//    public function deleteImage(Request $request){
//        $request->validate([
//            'id' => 'required',
//        ]);
//        $image = BannerImage::find($request->id);
//
//        if (File::exists(public_path($image->image))) {
//            File::delete(public_path($image->image));
//        }
//        $image->delete();
//        return response()->json('success');
//    }



}
