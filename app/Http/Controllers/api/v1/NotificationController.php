<?php

namespace App\Http\Controllers\api\v1;

use App\CPU\Helpers;
use Carbon\Carbon;
use App\Model\Notification;
use Illuminate\Http\Request;
use App\Model\NotificationSeen;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function list(Request $request)
    {

        $notification_data = Notification::active()->where(['sent_to'=>'customer']);

        $notification = $notification_data->with('notification_seen_by')
            ->latest()->paginate($request['limit'], ['*'], 'page', $request['offset']);

        return [
            'total_size' => $notification->total(),
            'limit' => (int)$request['limit'],
            'offset' => (int)$request['offset'],
            'new_notification' => $notification_data->whereDoesntHave('notification_seen_by')->count(),
            'notification' => $notification->items()
        ];
    }

    public function notification_seen(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required','exists:notifications,id'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $user = $request->user();
        NotificationSeen::updateOrInsert(['user_id' => $user->id, 'notification_id' => $request->id],[
            'created_at' => Carbon::now(),
        ]);

        $notification_count = Notification::active()
            ->where('sent_to', 'customer')
            ->whereDoesntHave('notification_seen_by')
            ->count();

        return [
            'notification_count' => $notification_count,
        ];
    }
}
