<?php

namespace App\Http\Controllers\Dashboard\Core;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Contacting;
use App\Models\Icon;
use App\Models\Service;
use App\Models\ServiceImages;
use App\Traits\imageTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;


class ContactingController extends Controller
{
    use imageTrait;

    public function index()
    {

        if (request()->ajax()) {

            $contact = Contacting::all();
            return DataTables::of($contact)
                ->addColumn('title', function ($row) {
                    return $row->title;
                })
                ->addColumn('category', function ($row) {
                    return $row->category?->title;
                })

                ->addColumn('controll', function ($row) {

                    $html = '



<a href="' . route('dashboard.core.contact.edit', $row->id) . '"  id="edit-booking" class="btn btn-primary btn-sm card-tools edit" data-id="' . $row->id . '"
                         data-type="' . $row->type . '" >
                            <i class="far fa-edit fa-2x"></i>
                       </a>


                                <a data-href="' . route('dashboard.core.contact.destroy', $row->id) . '" data-id="' . $row->id . '" class="mr-2 btn btn-outline-danger btn-delete btn-sm">
                            <i class="far fa-trash-alt fa-2x"></i>
                    </a>
                                ';

                    return $html;
                })
                ->rawColumns([
                    'title',
                    'category',
                    'controll',
                ])
                ->make(true);
        }

        return view('dashboard.core.contact.index');
    }

    public function create()
    {
        $categories = category::whereNull('parent_id')->where('active', 1)->get()->pluck('title', 'id');
        return view('dashboard.core.contact.create',compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_ar' => 'required|String|min:3',
            'title_en' => 'required|String|min:3',
            'desc_ar' => 'required|String|min:3',
            'desc_en' => 'required|String|min:3',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif',

        ]);

        $data = $request->except(['_token','image']);


        if ($request->has('image')) {
            $image = $this->storeImages($request->image, 'contact');
            $data['image'] = 'storage/images/contact' . '/' . $image;
        }

        Contacting::query()->create($data);


        session()->flash('success');
        return redirect()->route('dashboard.core.contact.index');
    }

    public function edit($id)
    {
        $contact = Contacting::where('id', $id)->first();
        $categories = category::whereNull('parent_id')->where('active', 1)->get()->pluck('title', 'id');

        return view('dashboard.core.contact.edit', compact('contact','categories'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title_ar' => 'required|String|min:3',
            'title_en' => 'required|String|min:3',
            'desc_ar' => 'required|String|min:3',
            'desc_en' => 'required|String|min:3',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif',

        ]);
        $contact = Contacting::find($id);

        $data = $request->except(['_token','image']);
        if ($request->has('image')) {
            if (File::exists(public_path($contact->image))) {
                File::delete(public_path($contact->image));
            }
            $image = $this->storeImages($request->image, 'contact');
            $data['image'] = 'storage/images/contact' . '/' . $image;
        }

        $contact->update($data);
        session()->flash('success');
        return redirect()->route('dashboard.core.contact.index');
    }

    public function destroy($id)
    {
        $contact = Contacting::find($id);
        if (File::exists(public_path($contact->image))) {
            File::delete(public_path($contact->image));
        }
        $contact->delete();
        return [
            'success' => true,
            'msg' => __("dash.deleted_success")
        ];
    }

}
