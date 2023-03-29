<?php

namespace App\Http\Controllers\Dashboard\Core;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\imageTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class CategoryController extends Controller
{
    use imageTrait;
    public function index()
    {
        if (request()->ajax()) {
                $category = Category::all();
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
                                  data-parent_id="'.$category->parent_id.'" data-image="'.storage_path('app/public/images/category/'.$category->slug).'" data-toggle="modal" data-target="#editModel">
                            <i class="far fa-edit fa-2x"></i>
                       </button>

                                <a data-id="'.$category->id.'" class="mr-2 btn btn-sm btn-outline-danger btn-delete btn-sm">
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
        return view('dashboard.core.categories.index',compact('categories'));
    }

    public function create()
    {
        return view('dashboard.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_ar' => 'required',
            'title_en' => 'required',
            'avatar' => 'required|image',
            'description_ar' => 'required',
            'description_en' => 'required',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $data=$request->except('_token','avatar');

        if ($request->has('avatar')){
            $image=$this->storeImages($request->avatar);
            $data['slug']=$image;
        }

        Category::updateOrCreate($data);

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
            'title' => 'required',
        ]);
        $category = Category::find($id);
        $data['title']=$request->title;

        $category->update($data);
        session()->flash('edit');
        return redirect()->route('admin.category.index');
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        session()->flash('edit');
        return redirect()->route('admin.category.index');
    }

    public function changStatus(Request $request){
        $admin = Category::where('id',$request->id)->first();
        if ($request->active == 'true'){
            $active = 1;
        }else{
            $active = 0;
        }

        $admin->status = $active;
        $admin->save();
        return response()->json(['sucess'=>true]);
    }
}
