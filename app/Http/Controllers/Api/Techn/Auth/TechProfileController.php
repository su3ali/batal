<?php

namespace App\Http\Controllers\Api\Techn\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Checkout\UserAddressResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\Technician\auth\TechnicianResource;
use App\Http\Resources\User\UserResource;
use App\Models\Technician;
use App\Models\User;
use App\Models\UserAddresses;
use App\Support\Api\ApiResponse;
use App\Traits\SMSTrait;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class TechProfileController extends Controller
{
    use ApiResponse;
    use SMSTrait;

    public function __construct()
    {
        $this->middleware('localize');
    }

    protected function getTechnInfo()
    {
        $techn = TechnicianResource::make(auth('sanctum')->user());
        $this->body['techn'] = $techn;
        return self::apiResponse(200, null, $this->body);
    }

    protected function updateTechnInfo(Request $request)
    {
        $techn = auth('sanctum')->user();
        $techn = Technician::query()->where('id', $techn->id)->first();

        $request->validate([
            'name' => 'nullable|min:3|max:100',
        ]);

        if ($techn->phone != $request->phone && $techn->email == $request->email){
            $code = random_int(1000, 9999);
            $techn->update([
                'code' => $code
            ]);
            $m = "رمز التحقق: ".$code;
            $msg = $this->sendMessage($techn->phone, $m);
            $this->message = t_('To modify you need the code');
        }elseif ($techn->phone == $request->phone && $techn->email != $request->email){
            $code = random_int(1000, 9999);
            $techn->update([
                'code' => $code
            ]);

            Mail::send('mail.editProfileCode',["code"=>$code], function ($message) use ($techn) {
                $message->to($techn->email);
                $message->subject(t_('edit profile code'));
            });

            $this->message = t_('To modify you need the code');
        }elseif ($techn->phone == $request->phone && $techn->email == $request->email && $techn->name != $request->name){
            $techn->update([
                'name' => $request->name,
            ]);
            $this->body['techn'] = $techn;
            $this->message = t_('Modified successfully');
        }else{
            $code = random_int(1000, 9999);
            $techn->update([
                'code' => $code
            ]);
            $m = "رمز التحقق: ".$code;
            $msg = $this->sendMessage($techn->phone, $m);
            $this->message = t_('To modify you need the code');
        }

        return self::apiResponse(200, $this->message, $this->body);
    }


    protected function editByCode(Request $request)
    {

        $techn = Technician::query()->where('code', $request->code)->first();

        if ($techn->phone != $request->phone && $techn->email == $request->email){

            $request->validate([
                'phone' => 'required|numeric|unique:users,phone,'.$techn->id,
            ]);
            $techn->update([
                'phone'=>$request->phone,
                'code' => null
            ]);

        }elseif ($techn->phone == $request->phone && $techn->email != $request->email){
            $request->validate([
                'email' => 'nullable|email|unique:users,email,'.$techn->id,
            ]);
            $techn->update([
                'email'=>$request->email,
                'code' => null
            ]);
        }else{
            $request->validate([
                'phone' => 'required|numeric|unique:users,phone,'.$techn->id,
                'email' => 'nullable|email|unique:users,email,'.$techn->id,
            ]);

            $techn->update([
                'phone'=>$request->phone,
                'email'=>$request->email,
                'code' => null
            ]);
        }

        return self::apiResponse(200, t_('Modified successfully'), $this->body);
    }

    protected function getNotification()
    {
        $techn = auth('sanctum')->user();
        $this->body['notification'] = NotificationResource::collection($techn->notifications);
        return self::apiResponse(200, null, $this->body);
    }

    protected function deleteNotification(Request $request)
    {
        \DB::table('notifications')->where('id',$request->id)->delete();
        $this->message = t_('Delete successfully');
        return self::apiResponse(200, $this->message, $this->body);
    }

    protected function readNotification(Request $request)
    {
        $techn = auth('sanctum')->user();

        foreach ($techn->unreadNotifications as $notification) {
             $notification->update(['read_at' => now()]);
         }

        $this->message = t_('Read Notification Successfully');
        return self::apiResponse(200, $this->message, $this->body);
    }

}
