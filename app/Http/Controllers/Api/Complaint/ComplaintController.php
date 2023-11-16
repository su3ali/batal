<?php

namespace App\Http\Controllers\Api\Complaint;

use App\Http\Controllers\Controller;
use App\Http\Resources\Complaint\ComplaintResource;
use App\Models\CustomerComplaint;
use App\Models\CustomerComplaintImage;
use App\Support\Api\ApiResponse;
use Illuminate\Http\Request;
use Validator;

class ComplaintController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('localization');
    }

    protected function index()
    {
        $complaints = CustomerComplaint::where('user_id', auth()->user('sanctum')->id)->get();
        $this->body['complaints'] = ComplaintResource::collection($complaints);
        return self::apiResponse(200, null, $this->body);
    }

    protected function store(Request $request)
    {
        $rules = [
            'text' => 'required|string',
            'video' => 'nullable',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png,gif',
            'order_id' => 'required|exists:orders,id',
        ];

        $validated = Validator::make($request->all(), $rules);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated->errors());
        }
        $validated = $validated->validated();
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $filename = time() . '.' . $video->getClientOriginalExtension();
            $request->video->move(storage_path('app/public/images/complaints/videos/'), $filename);
            $validated['video'] = 'storage/images/complaints/videos' . '/' . $filename;
        }
        $validated = collect($validated)->except('images')->toArray();
        $validated['user_id'] = auth()->user('sanctum')->id;
        $customerComplaint = CustomerComplaint::create($validated);
        $customer_complaints_id = $customerComplaint->id;
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageFilename = time() . '_' . rand(100, 999) . '.' . $image->getClientOriginalExtension();
                $image->move(storage_path('app/public/images/complaints/images/'), $imageFilename);
                $imagePath = 'storage/images/complaints/images' . '/' . $imageFilename;
                CustomerComplaintImage::create([
                    'customer_complaints_id' => $customer_complaints_id,
                    'image' => $imagePath
                ]);
            }
        }
        return self::apiResponse(200, __('api.complaint filed successfully'), $this->body);
    }
}
