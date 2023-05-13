<?php

namespace App\Http\Controllers\Dashboard\Core;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Group;
use App\Traits\imageTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;


class CategoryController extends Controller
{
    use imageTrait;
    public function index()
    {

        if (request()->ajax()) {

//            if (request('id') == null){
//                $category = Category::whereNull('parent_id')->get();
//
//            }else{
//                $category = Category::where('parent_id',request('id'))->get();
//            }

            $category = Category::whereNull('parent_id')->get();

            return DataTables::of($category)
                ->addColumn('title', function ($category) {
                    return $category->title;
                })
                ->addColumn('status', function ($category) {
                    $checked = '';
                    if ($category->active == 1){
                        $checked = 'checked';
                    }
                    return '<label class="switch s-outline s-outline-info  mb-4 mr-2">
                        <input type="checkbox" id="customSwitch4" data-id="' . $category->id . '" ' . $checked . '>
                        <span class="slider round"></span>
                        </label>';
                })
                ->addColumn('controll', function ($category) {

                    $html = '

                                <button type="button" id="add-work-exp" class="btn btn-sm btn-primary card-tools edit" data-id="'.$category->id.'"  data-title_ar="'.$category->title_ar.'"
                                 data-title_en="'.$category->title_en.'" data-des_ar="'.$category->description_ar.'" data-des_en="'.$category->description_en.'"
                                  data-parent_id="'.$category->parent_id.'" data-image="'.$category->image.'" data-group_id="'.$category->groups()->pluck('group_id').'" data-toggle="modal" data-target="#editModel">
                            <i class="far fa-edit fa-2x"></i>
                       </button>

                                <a data-href="'.route('dashboard.core.category.destroy', $category->id).'" data-id="'.$category->id.'" class="mr-2 btn btn-outline-danger btn-delete btn-sm">
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

        $categories = Category::whereNull('parent_id')->get();
        $groups = Group::query()->get();

        return view('dashboard.core.categories.index',compact('categories','groups'));
    }

    public function create()
    {
        return view('dashboard.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_ar' => 'required|String|min:3',
            'title_en' => 'required|String|min:3',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png,gif',
            'description_ar' => 'required',
            'description_en' => 'required',
            'parent_id' => 'nullable|exists:categories,id',
            'group_ids' => 'required|array',
            'group_ids.*' => 'required|exists:groups,id',
        ]);

        $data=$request->except('_token','avatar','group_ids');

        if ($request->has('avatar')){
            $image=$this->storeImages($request->avatar,'category');
                $data['slug']= 'storage/images/category'.'/'.$image;
        }

        $category = Category::updateOrCreate($data);
        $category->groups()->sync($request->group_ids);
        session()->flash('success');
        return redirect()->back();
    }

    public function edit($id)
    {
        $category = Category::where('id',$id)->first();
        return view('dashboard.categories.edit', compact( 'category'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title_ar' => 'required',
            'title_en' => 'required',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png,gif',
            'description_ar' => 'required',
            'description_en' => 'required',
            'parent_id' => 'nullable|exists:categories,id',
            'group_ids' => 'required|array',
            'group_ids.*' => 'required|exists:groups,id',
        ]);
        $data=$request->except('_token','avatar','group_ids');


        $category = Category::find($id);
        if ($request->has('avatar')){
            if (File::exists(public_path($category->slug))) {
                File::delete(public_path($category->slug));
            }
            $image=$this->storeImages($request->avatar,'category');
            $data['slug']= 'storage/images/category'.'/'.$image;
        }
        $category->update($data);
        $category->groups()->sync($request->group_ids);
        session()->flash('success');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (File::exists(public_path($category->slug))) {
            File::delete(public_path($category->slug));
        }

        $category->delete();
        return [
            'success' => true,
            'msg' => __("dash.deleted_success")
        ];
    }

    public function change_status(Request $request){
        $admin = Category::where('id',$request->id)->first();
        if ($request->active == 'true'){
            $active = 1;
        }else{
            $active = 0;
        }

        $admin->active = $active;
        $admin->save();
        return response()->json(['sucess'=>true]);
    }
}
