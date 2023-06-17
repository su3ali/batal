<?php

namespace App\Http\Controllers\Dashboard;



use App\Models\Technician;
use App\Models\User;
use App\Notifications\SendPushNotification;
use App\Traits\NotificationTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;


class NotificationController extends Controller
{
    use NotificationTrait;
    public function showNotification()
    {

        $technicians = Technician::query()->whereNotNull('fcm_token')->pluck('name','id')->all();
        $customers = User::query()->whereNotNull('fcm_token')->get();


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
                $FcmTokenArray = User::whereNotNull('fcm_token')->get()->pluck('fcm_token');
            }else{
                $user = User::where('id',$request->customer_id)->first('fcm_token');
                $FcmToken = $user->fcm_token;
            }

            $type = 'customer';
        }else{
            if ($request->technician_id == 'all'){
                $allTechn = Technician::whereNotNull('fcm_token')->get();

                $FcmTokenArray = $allTechn->pluck('fcm_token');


                foreach ($allTechn as $tech){
                    Notification::send(
                        $tech,
                        new SendPushNotification($request->title,$request->message)
                    );
                }

            }else{
                $technician = Technician::where('id',$request->technician_id)->first();
                $FcmToken = $technician->fcm_token;

                Notification::send(
                    $technician,
                    new SendPushNotification($request->title,$request->message)
                );

            }

            $type = 'technician';

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
            'type'=>$type??'',
            'code'=> 2
        ];

      $this->pushNotification($notification);
        session()->flash('success');
        return redirect()->back();

    }



}
