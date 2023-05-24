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
        if ($request->type == 'customers'){
            if ($request->customer_id == 'all'){
                $FcmToken = User::whereNotNull('fcm_token')->pluck('fcm_token')->all();
            }else{
                $user = User::where('id',$request->customer_id)->first('fcm_token');
                $FcmToken = $user->fcm_token;
            }
        }else{
            if ($request->technician_id == 'all'){
                $FcmToken = Technician::whereNotNull('fcm_token')->pluck('fcm_token')->all();
            }else{
                $technician = Technician::where('id',$request->technician_id)->first('fcm_token');
                $FcmToken = $technician->fcm_token;
            }
        }


        $notification = [
            'device_token' => $FcmToken,
            'title' => $request->title,
            'message' => $request->message,
        ];

      $this->sendNotification($notification);
        return redirect()->back();

    }



}
