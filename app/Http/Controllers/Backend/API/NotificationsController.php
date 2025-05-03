<?php

namespace App\Http\Controllers\Backend\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laracasts\Flash\Flash;
use App\Models\Notification;

class NotificationsController extends Controller
{
    public function notificationList(Request $request)
    {
        $user = auth()->user();
        $user->last_notification_seen = now();
        $user->save();

        $type = isset($request->type) ? $request->type : null;
        if ($type == 'mark_as_read') {
            if (count($user->unreadNotifications) > 0) {
                $user->unreadNotifications->markAsRead();
            }
        }
         $page=1;

        $limit =  $request->input('per_page');
        $notifications = $user->Notifications->sortByDesc('created_at')->forPage($page, $limit);
        $all_unread_count = isset($user->unreadNotifications) ? $user->unreadNotifications->count() : 0;

        $items = NotificationResource::collection($notifications);

        $response = [
            'notification_data' => $items,
            'all_unread_count' => $all_unread_count,
            'message' => __('messages.mark_read'),
            'status' => true,
        ];

        return $response;
    }

    public function notificationRemove(Request $request)
    {
        $id = $request->id;
        $data = Notification::findOrFail($id);

        $data->delete();

        $message = __('notification.notification_deleted');

        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function deleteAll()
    {
        $module_action = 'Delete All';

        $user = auth()->user();

        $user->notifications()->delete();

        $message = __('notification.notification_deleted');
        return response()->json(['message' => $message, 'status' => true], 200);
    }
}
