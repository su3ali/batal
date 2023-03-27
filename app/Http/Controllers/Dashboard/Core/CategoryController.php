<?php

namespace App\Http\Controllers\Dashboard\Core;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return view('dashboard.core.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('dashboard.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $data=$request->except('_token');


        Category::updateOrCreate($data);

        session()->flash('add');
        return redirect()->route('admin.category.index');
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
