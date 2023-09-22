<?php

namespace App\Http\Controllers\Dashboard\Bookings;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingStatus;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\ValidationException;


class BookingStatusController extends Controller {

    public function index()
    {
        if (request()->ajax()) {
            $statuses = BookingStatus::all();
            return DataTables::of($statuses)
                ->addColumn('name', function ($row) {
                    return $row->name;
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

                ->rawColumns([
                    'name',
                    'status',
                ])
                ->make(true);
        }

        return view('dashboard.booking_statuses.index');
    }

    /**
     * @throws ValidationException
     */
//    protected function store(Request $request): RedirectResponse
//    {
//        $rules = [
//            'name_ar' => 'required|String|unique:booking_statuses,name_ar',
//            'name_en' => 'required|String|unique:booking_statuses,name_en',
//            'description_ar' => 'nullable|String',
//            'description_en' => 'nullable|String',
//        ];
//        $validated = Validator::make($request->all(), $rules);
//        if ($validated->fails()) {
//            return redirect()->back()->withErrors($validated->errors());
//        }
//        $validated = $validated->validated();
//        BookingStatus::query()->create($validated);
//        session()->flash('success');
//        return redirect()->back();
//    }
//    protected function update(Request $request, $id){
//        $bookingStatus = BookingStatus::query()->where('id', $id)->first();
//        $rules = [
//            'name_ar' => 'required|unique:booking_statuses,name_ar,'.$id,
//            'name_en' => 'required|unique:booking_statuses,name_en,'.$id,
//            'description_ar' => 'nullable|String',
//            'description_en' => 'nullable|String',
//        ];
//        $validated = Validator::make($request->all(), $rules);
//        if ($validated->fails()) {
//            return redirect()->back()->with('errors', $validated->errors());
//        }
//        $validated = $validated->validated();
//        $bookingStatus->update($validated);
//        session()->flash('success');
//        return redirect()->back();
//    }

//    protected function destroy($id)
//    {
//        $bookingStatus = BookingStatus::find($id);
//        if (in_array($id, Booking::query()->pluck('booking_status_id')->toArray())){
//            return response()->json(['success' => false,
//                'msg' => 'حذف الحالة غير متاح لارتباطها بطلب'
//            ]);
//        }
//        $bookingStatus->delete();
//        return [
//            'success' => true,
//            'msg' => __("dash.deleted_success")
//        ];
//    }
    protected function change_status (Request $request){
        $bookingStatus = BookingStatus::query()->where('id', $request->id)->first();
        if ($request->active == "false"){
            $bookingStatus->active = 0;
        }else{
            $bookingStatus->active = 1;
        }
        $bookingStatus->save();
        return response('success');
    }

}
