<?php

namespace App\Http\Controllers\Dashboard;



use App\Models\Technician;
use App\Models\User;
use App\Traits\NotificationTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class NotificationController extends Controller
{
    use NotificationTrait;
    public function showNotification()
    {

        $technicians = Technician::query()->whereNotNull('fcm_token')->pluck('name','id')->all();
        $customers = User::query()->whereNotNull('fcm_token')->pluck('first_name','id')->all();


        return view('dashboard.notification.notification',compact('customers','technicians'));
    }

    public function sendNotification(Request $request)
    {

        $request->validate([
            'customer_id'=>'nullable',
            'technician_id'=>'nullable',
            'title'=>'required',
            'message'=>'required',
            'type'=>'required'
        ]);
        if ($request->type == 'customer'){
            if ($request->customer_id == 'all'){
                $FcmTokenArray = User::whereNotNull('fcm_token')->pluck('fcm_token')->all();
            }else{
                $user = User::where('id',$request->customer_id)->first('fcm_token');
                $FcmToken = $user->fcm_token;
            }
        }else{
            if ($request->technician_id == 'all'){
                $FcmTokenArray = Technician::whereNotNull('fcm_token')->pluck('fcm_token')->all();
            }else{
                $technician = Technician::where('id',$request->technician_id)->first('fcm_token');
                $FcmToken = $technician->fcm_token;
            }
        }


        if (isset($FcmToken) && $FcmToken == null){

            return redirect()->back()->withErrors(['fcm_token' => 'لا يمكن ارسال الاشعارت لعدم توفر رمز الجهاز']);

        }elseif(isset($FcmTokenArray) && count($FcmTokenArray) == 0){
            return redirect()->back()->withErrors(['fcm_token' => 'لا يمكن ارسال الاشعارت لعدم توفر رمز الجهاز']);
        }


        $notification = [
            'device_token' => isset($FcmToken) ?[$FcmToken] : $FcmTokenArray,
            'title' => $request->title,
            'message' => strip_tags($request->message),
        ];

      $this->pushNotification($notification);
        session()->flash('success');
        return redirect()->back();

    }



}
