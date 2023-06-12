<?php
namespace App\Traits;

use Illuminate\Support\Facades\Config;

trait NotificationTrait
{

   public function pushNotification($notification)
  {
      $auth_key = Config::get('app.firebase_credentials');

      $device_token = $notification['device_token'];

      $data = [
          'id' => random_int(1,9999),
          'title' => $notification['title'],
          'body' => $notification['message'],
          'type' => $notification['type'],

      ];

//      $notification = [
//          'title' => $notification['title'] ,
//          'body' => $notification['message'],
//          'sound' => 'default',
//          "priority" => "high",
//          "mutable-content"=> 1,
//          'data' => $data
//      ];

    $fields = json_encode([
      'registration_ids' => $device_token,
//      'notification' => $notification,
    'data' => $data,
    'sound' => 'default',
    "priority" => "HIGH",
    "mutable-content"=> 1,
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: key=' . $auth_key, 'Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    $result = curl_exec($ch);

    if ($result === FALSE) {
      die('FCM Send Error: ' . curl_error($ch));
    }

    curl_close($ch);
  }

    public function pushNotificationBackground($notification)
    {
        $auth_key = Config::get('app.firebase_credentials');

        $device_token = $notification['device_token'];

        $data = [
            'data' => $notification['data'],
        ];

        $fields = json_encode([
            'registration_ids' => $device_token,
            'data' => $data,
            "priority" => "HIGH",
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: key=' . $auth_key, 'Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }

        curl_close($ch);
    }
}
