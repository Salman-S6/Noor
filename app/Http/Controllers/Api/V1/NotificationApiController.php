<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\AppNotification;
use App\Models\AppNotificationRead;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationApiController extends Controller
{
    /**
     * جلب قائمة الإشعارات النشطة الموجهة للمستخدم
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $query = AppNotification::active()
            ->forUser($user?->id)
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc');

        // فلترة اختيارية حسب نوع الإشعار
        if ($request->filled('type')) {
            $query->where('type', $request->query('type'));
        }

        $notifications = $query->paginate(20);

        // جلب سجلات القراءة للمستخدم الحالي
        $readMap = $user
            ? AppNotificationRead::where('user_id', $user->id)
                ->pluck('read_at', 'app_notification_id')
            : collect();

        // حساب عدد الإشعارات غير المقروءة
        $unreadCount = 0;
        if ($user) {
            $activeIds = AppNotification::active()->forUser($user->id)->pluck('id');
            $readIds = $readMap->keys()->toArray();
            $unreadCount = $activeIds->diff($readIds)->count();
        }

        // تنسيق وإثراء البيانات لتتوافق مع كلا النظامين (Noor + Kasherak)
        $notifications->getCollection()->transform(function ($item) use ($readMap) {
            $readAt = $readMap->get($item->id);
            $isRead = $readAt !== null;

            return [
                'id' => $item->id,
                'title' => $item->title,
                'body' => $item->body,
                'message' => $item->body, // للتوافق مع تطبيق كاشيرك
                'type' => $item->type,
                'target_type' => $item->user_id ? 'specific' : 'all',
                'user_id' => $item->user_id,
                'version' => $item->version,
                'link' => $item->link,
                'download_url' => $item->link,
                'is_mandatory' => (bool) $item->is_mandatory,
                'is_read' => $isRead,
                'read_at' => $readAt ? Carbon::parse($readAt)->format('Y/m/d h:i A') : null,
                'created_at' => $item->created_at ? $item->created_at->format('Y/m/d h:i A') : null,
                'published_at' => $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : null,
                'time_ago' => $item->created_at ? $item->created_at->locale('ar')->diffForHumans() : '',
            ];
        });

        return response()->json([
            'status' => 'success',
            'unread_count' => $unreadCount,
            'notifications' => $notifications, // كاشيرك
            'data' => $notifications,          // نور
        ], 200);
    }

    /**
     * تحديد إشعار معين كمقروء
     */
    public function markAsRead(Request $request, $id)
    {
        $user = $request->user();

        $notification = AppNotification::active()
            ->forUser($user->id)
            ->findOrFail($id);

        AppNotificationRead::updateOrCreate(
            [
                'app_notification_id' => $notification->id,
                'user_id' => $user->id,
            ],
            [
                'read_at' => now(),
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'تم تحديد الإشعار كمقروء بنجاح',
        ], 200);
    }

    /**
     * تحديد جميع الإشعارات كمقروءة بضغطة واحدة
     */
    public function markAllAsRead(Request $request)
    {
        $user = $request->user();

        $activeIds = AppNotification::active()
            ->forUser($user->id)
            ->pluck('id');

        $readIds = AppNotificationRead::where('user_id', $user->id)
            ->pluck('app_notification_id')
            ->toArray();

        $unreadIds = $activeIds->diff($readIds);

        $now = now();
        $records = $unreadIds->map(fn($id) => [
            'app_notification_id' => $id,
            'user_id' => $user->id,
            'read_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ])->toArray();

        if (! empty($records)) {
            AppNotificationRead::insert($records);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'تم تحديد جميع الإشعارات كمقروءة بنجاح',
        ], 200);
    }

    /**
     * جلب آخر إشعار تحديث للتطبيق (أعلى إصدار بناءً على المقارنة الرقمية Semantic Versioning)
     */
    public function getLatestUpdate(Request $request)
    {
        $cachedResult = \Illuminate\Support\Facades\Cache::remember('latest_app_update', 3600, function () {
            $updates = AppNotification::active()
                ->where('type', 'update')
                ->whereNotNull('version')
                ->whereNotNull('link')
                ->get();

            if ($updates->isEmpty()) {
                return [
                    'has_update' => false,
                    'message' => 'أنت تستخدم أحدث إصدار من التطبيق.',
                    'update' => null,
                ];
            }

            // ترتيب تنازلي حسب رقم الإصدار (Semantic Versioning)، وفي حال التساوي نأخذ الأحدث بـ id
            $sorted = $updates->sort(function ($a, $b) {
                $cmp = version_compare($b->version, $a->version);
                if ($cmp !== 0) {
                    return $cmp;
                }

                return $b->id <=> $a->id;
            })->values();

            $update = $sorted->first();

            return [
                'has_update' => true,
                'update' => [
                    'id' => $update->id,
                    'title' => $update->title,
                    'body' => $update->body,
                    'version' => $update->version,
                    'download_url' => $update->link,
                    'is_mandatory' => (bool) $update->is_mandatory,
                    'published_at' => $update->created_at->format('Y-m-d H:i:s'),
                ],
            ];
        });

        return response()->json($cachedResult, 200);
    }
}
