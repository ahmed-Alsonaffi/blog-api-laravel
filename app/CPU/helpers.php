<?php

namespace App\CPU;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class Helpers
{
    public static function send_push_notif_to_topic($data)
    {

        $url = "https://fcm.googleapis.com/fcm/send";
        $header = ["authorization: key=AAAAyiv9En4:APA91bGqxOZunYstUkDAvFR0kfzjhhkCsrLo0J2VfAJKttkwkM8XTnIF9A5INer1FpPdHn4fI1_7XL8bLX_F8_BcKXb9ZwU4AtWcYj-Sp4fdrXyZUNtSpgplBZXa8Ul5wFLFRY7m2FFX",
            "Content-Type: application/json",
        ];

        $postdata = '{
            "to" : "/topics/all",
            "data" : {
                "click_action": "FLUTTER_NOTIFICATION_CLICK",
                "id": "1",
                "status": "done",
                "notification_type": "custom",
                "description": "' . $data['description'] . '"
              },
              "priority": "normal",
              "notification" : {
                "title":"' . $data['title'] . '",
                "body" : "' . $data['description'] . '",
                "sound" : "default"
              }
        }';

        $ch = curl_init();
        $timeout = 120;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        // return curl_getinfo($ch);
        // Get URL content
        $result = curl_exec($ch);
        // close handle to release resources
        // curl_close($ch);

        return $result;
    }
}