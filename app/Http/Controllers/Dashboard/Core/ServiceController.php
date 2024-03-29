<?php

namespace App\Http\Controllers\Dashboard\Core;

use App\Enums\Core\ServiceType;
use App\Http\Controllers\Controller;
use App\Models\BookingSetting;
use App\Models\Category;
use App\Models\Group;
use App\Models\Icon;
use App\Models\Measurement;
use App\Models\Service;
use App\Models\ServiceGroup;
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
                    if ($service->active == 1) {
                        $checked = 'checked';
                    }
                    return '<label class="switch s-outline s-outline-info  mb-4 mr-2">
                        <input type="checkbox" id="customSwitch4" data-id="' . $service->id . '" ' . $checked . '>
                        <span class="slider round"></span>
                        </label>';
                })
                ->addColumn('controll', function ($service) {

                    $html = '

                    <button type="button" id="add-work-exp" class="btn btn-sm btn-primary card-tools image" data-id="' . $service->id . '" data-toggle="modal" data-target="#imageModel">
                            <i class="far fa-image fa-2x"></i>
                       </button>

<a href="' . route('dashboard.core.service.edit', $service->id) . '"  id="edit-booking" class="btn btn-primary btn-sm card-tools edit" data-id="' . $service->id . '"
                         data-type="' . $service->type . '" >
                            <i class="far fa-edit fa-2x"></i>
                       </a>


                                <a data-href="' . route('dashboard.core.service.destroy', $service->id) . '" data-id="' . $service->id . '" class="mr-2 btn btn-outline-danger btn-delete btn-sm">
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

        return view('dashboard.core.services.index');
    }

    public function create()
    {
        $categories = category::whereNull('parent_id')->where('active', 1)->get()->pluck('title', 'id');
        $groups = Group::query()->where('active',1)->get();
        $icons = Icon::query()->get();
        $measurements = Measurement::query()->get();
        return view('dashboard.core.services.create', compact('categories', 'groups','measurements','icons'));
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
            'measurement_id' => 'required|exists:measurements,id',
            'price' => 'required|Numeric',
            'type' => 'required|in:evaluative,fixed',
//            'group_ids' => 'required|array',
//            'group_ids.*' => 'required|exists:groups,id',

//            'icon_ids' => 'required|array',
//            'icon_ids.*' => 'required|exists:icons,id',
            'start_from' => 'nullable|Numeric',
            'is_quantity' => 'nullable|in:on,off',
            'best_seller' => 'nullable|in:on,off',

            'preview_price' => 'nullable|Numeric',
            'preview' => 'nullable|in:on,off',
            'deposit_price' => 'nullable|Numeric',
            'deposit' => 'nullable|in:on,off',

        ]);

        $data = $request->except(['_token', 'group_ids','is_quantity','best_seller','icon_ids']);

        if ($request['is_quantity'] && $request['is_quantity'] == 'on'){
            $data['is_quantity'] = 1;
        }else{
            $data['is_quantity'] = 0;
        }

        if ($request['best_seller'] && $request['best_seller'] == 'on'){
            $data['best_seller'] = 1;
        }else{
            $data['best_seller'] = 0;
        }

        if ($request['preview'] && $request['preview'] == 'on'){
            $data['preview'] = 1;
        }else{
            $data['preview'] = 0;
        }

        if ($request['deposit'] && $request['deposit'] == 'on'){
            $data['deposit'] = 1;
        }else{
            $data['deposit'] = 0;
        }

        $service = Service::query()->create($data);

//        $service->icons()->sync($request->icon_ids);

        $bookingByservice = BookingSetting::query()->where('service_id',$service->id)->first();
        if ($bookingByservice == null){
            BookingSetting::create([
                'service_id' => $service->id,
                'service_start_date' => 'Saturday',
                'service_end_date' => 'Thursday',
                'available_service' => 4,
                'service_start_time' => '12:34:00',
                'service_end_time' => '18:34:00',
                'service_duration' => 30,
                'buffering_time' => 10,
            ]);
        }


//        foreach ($request->group_ids as $group_id) {
//            ServiceGroup::query()->create([
//                'service_id' => $service->id,
//                'group_id' => $group_id,
//            ]);
//        }

        session()->flash('success');
        return redirect()->route('dashboard.core.service.index');
    }

    public function edit($id)
    {
        $service = Service::where('id', $id)->first();
        $categories = category::whereNull('parent_id')->where('active', 1)->get()->pluck('title', 'id');
        $groups = Group::query()->where('active',1)
            ->whereNotIn('id', ServiceGroup::query()->pluck('group_id')->toArray())
            ->orWhereIn('id', ServiceGroup::query()->where('service_id', $service->id)->pluck('group_id')->toArray())
            ->get();
        $measurements = Measurement::query()->get();
        $icons = Icon::query()->get();

        return view('dashboard.core.services.edit', compact('service', 'categories', 'groups','measurements','icons'));
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
            'measurement_id' => 'required|exists:measurements,id',
            'price' => 'required|Numeric',
            'type' => 'required|in:evaluative,fixed',
            'start_from' => 'nullable|Numeric',
//            'group_ids' => 'required|array',
//            'group_ids.*' => 'required|exists:groups,id',
//            'icon_ids' => 'required|array',
//            'icon_ids.*' => 'required|exists:icons,id',
            'is_quantity' => 'nullable|in:on,off',
            'best_seller' => 'nullable|in:on,off',

            'preview_price' => 'nullable|Numeric',
            'preview' => 'nullable|in:on,off',
            'deposit_price' => 'nullable|Numeric',
            'deposit' => 'nullable|in:on,off',

        ]);
        $data = $request->except(['_token', 'group_ids','is_quantity','best_seller','icon_ids']);

        if ($request['is_quantity'] && $request['is_quantity'] == 'on'){
            $data['is_quantity'] = 1;
        }else{
            $data['is_quantity'] = 0;
        }

        if ($request['best_seller'] && $request['best_seller'] == 'on'){
            $data['best_seller'] = 1;
        }else{
            $data['best_seller'] = 0;
        }

        if ($request['preview'] && $request['preview'] == 'on'){
            $data['preview'] = 1;
        }else{
            $data['preview'] = 0;
            $data['preview_price'] = 0;
        }

        if ($request['deposit'] && $request['deposit'] == 'on'){
            $data['deposit'] = 1;
        }else{
            $data['deposit'] = 0;
            $data['deposit_price'] = 0;

        }


        if ($request->type == 'fixed') {
            $data['start_from'] = null;
        }
        $service = Service::find($id);

        $service->update($data);

//        $service->icons()->sync($request->icon_ids);

//        ServiceGroup::query()->where('service_id', $service->id)->delete();
//        foreach ($request->group_ids as $group_id) {
//            ServiceGroup::query()->create([
//                'service_id' => $service->id,
//                'group_id' => $group_id
//            ]);
//        }
        session()->flash('success');
        return redirect()->route('dashboard.core.service.index');
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

    public function change_status(Request $request)
    {
        $admin = Service::where('id', $request->id)->first();
        if ($request->active == 'true') {
            $active = 1;
        } else {
            $active = 0;
        }

        $admin->active = $active;
        $admin->save();
        return response()->json(['sucess' => true]);
    }


    public function uploadImage(Request $request)
    {

        $request->validate([
            'file' => 'required',
            'service_id' => 'required',
        ]);

        if ($request->has('file')) {
            $image = $this->storeImages($request->file, 'service');
            $image = 'storage/images/service' . '/' . $image;
        }

        ServiceImages::create([
            'image' => $image,
            'service_id' => $request->service_id,
        ]);
        $serviceImage = ServiceImages::where('service_id', $request->service_id)->latest()->first();

        return response()->json($serviceImage);

    }

    public function getImage(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $service = Service::find($request->id);
        if (!$service) {
            return response()->json('error');
        }
        return response()->json($service->serviceImages);

    }

    public function deleteImage(Request $request)
    {
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
