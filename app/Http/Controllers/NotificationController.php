<?php

namespace App\Http\Controllers;

use App\CPU\Helpers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function store(Request $request){

        // $notification = array();
        // $notification['title'] = $request['title'];
        // $notification['description'] = $request["description"];

        $notification = [
                    'title'=>$request['title'],
                    "description"=>$request["description"]
                ];
        // try {
            $result = Helpers::send_push_notif_to_topic($notification);
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'status'=>false,
        //     ]);
        // }
        return response()->json([
            'status'=>$result,
        ]);
    }
}
