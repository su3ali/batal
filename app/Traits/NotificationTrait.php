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
            'id' => random_int(1, 9999),
            'title' => $notification['title'],
            'body' => $notification['message'],
            'type' => $notification['type'],
            'code' => $notification['code'],

        ];

//      $notification = [
//          'title' => $notification['title'] ,
//          'body' => $notification['message'],
//          'sound' => 'default',
//          "priority" => "high",
//          "mutable-content"=> 1,
//          'data' => $data
//      ];

/*         $fields = [
            'registration_ids' => $device_token,
//          'notification' => $notification,
            "content_available" => true,
            "android" => [
                "priority" => "HIGH"
            ],
            "ios"=>[
                "priority"=>"HIGH"
            ],
            'data' => $data,
            'sound' => 'default',
            "priority" => "HIGH",
            "mutable-content" => 1,
        ]; */

        $fields = [];
        if ($notification['type'] == 'customer') {
            $fields = [
                'registration_ids' => $device_token,
                'notification' => [
                    'title' => $notification['title'],
                    'body' => $notification['message'],
                ],
                "content_available" => true,
                "android" => [
                    "priority" => "HIGH"
                ],
                "ios" => [
                    "priority" => "HIGH",
                    // "apns" => [
                    //     "payload" => [
                    //         "aps" => [
                    //             "contentAvailable" => true
                    //         ]
                    //     ]
                    // ]
                ],
                'data' => $data,
                'sound' => 'default',
                "priority" => "HIGH",
                "mutable-content" => true,
            ];
        } else {
            $fields = [
                'registration_ids' => $device_token,
                "content_available" => true,
                "android" => [
                    "priority" => "HIGH"
                ],
                "ios" => [
                    "priority" => "HIGH",
                ],
                'data' => $data,
                'sound' => 'default',
                "priority" => "HIGH",
                "mutable-content" => true,
            ];
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: key=' . $auth_key, 'Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
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

        /* $fields = [
            'registration_ids' => $device_token,
            "content_available" => true,
            "android" => [
                "priority" => "HIGH"
            ],
            "ios"=>[
                "priority"=>"HIGH"
            ],
            'data' => $data,
            "priority" => "HIGH",
        ]; */

        $fields = [];
        if ($notification['fromFunc'] == 'latlong') {
            $fields = [
                'registration_ids' => $device_token,
                "content_available" => true,
                "android" => [
                    "priority" => "HIGH"
                ],
                "ios" => [
                    "priority" => "HIGH",
                    // "apns" => [
                    //     "payload" => [
                    //         "aps" => [
                    //             "contentAvailable" => true
                    //         ]
                    //     ]
                    // ]
                ],
                'data' => $data,
                "priority" => "HIGH",
                "mutable-content" => true,
            ];
        } else {
            $statusList = [
                'طلبك باقي نرسلك افضل الأخصائيين عندنا',
                ' فريقنا جايين لعندك ياريت تجهز مكان العمل',
                ' فريق اهتمام بدأ بالخدمة هالحين',
                'ارسلنا لك طلب تسليم اذا شغلنا زين وافق عليها',
                'حبينا نشكرك على انتظارك طلبك مكتمل الحين',
                'تم إلغاء الطلب للأسباب التالية: ',
                ' للزيارة رقم ',
            ];
            $title = $notification['data']['order_details']['group']['name'] . $statusList[6] . $notification['data']['order_details']['id'];
            $body = '';
            $notification = json_decode(json_encode($notification));

            $booking_details = $notification->data->order_details->booking_details;
            if (!(is_null($booking_details->status))) {

                if ($booking_details->status->id == 6) {
                    $body = $statusList[$booking_details->status->id - 1] . $notification->data->order_details->cancel_reason->reason;
                } else {
                    $body = $statusList[$booking_details->status->id - 1];
                }
            } else {

                $body = $statusList[0];
            }


            $fields = [
                'registration_ids' => $device_token,
                "content_available" => true,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                "android" => [
                    "priority" => "HIGH"
                ],
                "ios" => [
                    "priority" => "HIGH",
                ],
                'data' => $data,
                "priority" => "HIGH",
                "mutable-content" => true,
            ];
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: key=' . $auth_key, 'Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }

        curl_close($ch);
    }
}
