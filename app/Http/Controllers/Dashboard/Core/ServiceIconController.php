<?php

namespace App\Http\Controllers\Dashboard\Core;

use App\Http\Controllers\Controller;

use App\Models\Icon;
use App\Models\Service;
use App\Models\ServiceImages;
use App\Traits\imageTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;


class ServiceIconController extends Controller
{
    use imageTrait;

    public function index()
    {

        if (request()->ajax()) {

            $icon = Icon::all();

            return DataTables::of($icon)
                ->addColumn('title', function ($icon) {
                    return $icon->title;
                })
                ->addColumn('t_image', function ($row) {
                    return '<a href="' . asset($row->image) . '" target="_blank"><img class="img-fluid" style="width: 85px;" src="' . asset($row->image) . '"/></a>';
                })
                ->addColumn('status', function ($icon) {
                    $checked = '';
                    if ($icon->active == 1) {
                        $checked = 'checked';
                    }
                    return '<label class="switch s-outline s-outline-info  mb-4 mr-2">
                        <input type="checkbox" id="customSwitch4" data-id="' . $icon->id . '" ' . $checked . '>
                        <span class="slider round"></span>
                        </label>';
                })
                ->addColumn('controll', function ($icon) {

                    $html = '



<a href="' . route('dashboard.core.icon.edit', $icon->id) . '"  id="edit-booking" class="btn btn-primary btn-sm card-tools edit" data-id="' . $icon->id . '"
                         data-type="' . $icon->type . '" >
                            <i class="far fa-edit fa-2x"></i>
                       </a>


                                <a data-href="' . route('dashboard.core.icon.destroy', $icon->id) . '" data-id="' . $icon->id . '" class="mr-2 btn btn-outline-danger btn-delete btn-sm">
                            <i class="far fa-trash-alt fa-2x"></i>
                    </a>
                                ';

                    return $html;
                })
                ->rawColumns([
                    'title',
                    't_image',
                    'status',
                    'controll',
                ])
                ->make(true);
        }

        return view('dashboard.core.icon.index');
    }

    public function create()
    {

        return view('dashboard.core.icon.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_ar' => 'required|String|min:3',
            'title_en' => 'required|String|min:3',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif',

        ]);

        $data = $request->except(['_token', 'image']);


        if ($request->has('image')) {
            $image = $this->storeImages($request->image, 'icon');
            $data['image'] = 'storage/images/icon' . '/' . $image;
        }

        Icon::query()->create($data);


        session()->flash('success');
        return redirect()->route('dashboard.core.icon.index');
    }

    public function edit($id)
    {
        $icon = Icon::where('id', $id)->first();

        return view('dashboard.core.icon.edit', compact('icon'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title_ar' => 'required|String|min:3',
            'title_en' => 'required|String|min:3',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif',

        ]);
        $icon = Icon::find($id);

        $data = $request->except(['_token', 'image']);
        if ($request->has('image')) {
            if (File::exists(public_path($icon->image))) {
                File::delete(public_path($icon->image));
            }
            $image = $this->storeImages($request->image, 'icon');
            $data['image'] = 'storage/images/icon' . '/' . $image;
        }

        $icon->update($data);
        session()->flash('success');
        return redirect()->route('dashboard.core.icon.index');
    }

    public function destroy($id)
    {
        $icon = Icon::find($id);
        if (File::exists(public_path($icon->image))) {
            File::delete(public_path($icon->image));
        }
        $icon->delete();
        return [
            'success' => true,
            'msg' => __("dash.deleted_success")
        ];
    }

    public function change_status(Request $request)
    {
        $admin = Icon::where('id', $request->id)->first();
        if ($request->active == 'true') {
            $active = 1;
        } else {
            $active = 0;
        }

        $admin->active = $active;
        $admin->save();
        return response()->json(['sucess' => true]);
    }
}
