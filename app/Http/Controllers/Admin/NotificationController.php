<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppNotification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * عرض صفحة الإشعارات ونموذج الإنشاء
     */
    public function index()
    {
        $notifications = AppNotification::with('user')->orderBy('created_at', 'desc')->paginate(15);
        $totalCount = AppNotification::count();
        $activeCount = AppNotification::where('is_active', true)->count();
        $updateCount = AppNotification::where('type', 'update')->count();
        $users = User::select('id', 'name', 'email')->orderBy('name')->get();

        return view('admin.notifications.index', compact(
            'notifications',
            'totalCount',
            'activeCount',
            'updateCount',
            'users'
        ));
    }

    /**
     * إنشاء إشعار جديد
     */
    public function store(Request $request)
    {
        $isUpdate = $request->input('type') === 'update';

        $rules = [
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:2000',
            'type' => 'required|string|in:update,general,alert,discount,info',
            'target_type' => 'required|in:all,specific',
            'user_id' => 'required_if:target_type,specific|nullable|exists:users,id',
            'version' => $isUpdate
                ? ['required', 'string', 'regex:/^\d+\.\d+\.\d+$/', 'max:20']
                : ['nullable', 'string', 'regex:/^\d+\.\d+\.\d+$/', 'max:20'],
            'link' => $isUpdate
                ? ['required', 'url', 'regex:/^https:\/\//i', 'max:500']
                : ['nullable', 'url', 'max:500'],
            'is_mandatory' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ];

        $messages = [
            'title.required' => 'عنوان الإشعار مطلوب',
            'title.max' => 'عنوان الإشعار طويل جداً',
            'body.required' => 'نص الإشعار مطلوب',
            'type.required' => 'نوع الإشعار مطلوب',
            'type.in' => 'نوع الإشعار المحدد غير صالح',
            'target_type.required' => 'يرجى تحديد الفئة المستهدفة',
            'user_id.required_if' => 'يرجى اختيار المستخدم المستهدف من القائمة',
            'user_id.exists' => 'المستخدم المحدد غير موجود في النظام',
            'version.required' => 'رقم الإصدار مطلوب عند إنشاء إشعار تحديث',
            'version.regex' => 'رقم الإصدار يجب أن يكون بصيغة x.y.z فقط (مثال: 1.0.1 أو 2.1.0) وبدون أحرف أو نصوص إضافية',
            'link.required' => 'رابط التنزيل المباشر مطلوب عند إنشاء إشعار تحديث',
            'link.url' => 'رابط التنزيل يجب أن يكون رابطاً صالحاً',
            'link.regex' => 'رابط التنزيل يجب أن يبدأ بـ https:// حصراً',
        ];

        $validated = $request->validate($rules, $messages);

        if ($validated['target_type'] === 'all') {
            $validated['user_id'] = null;
        }

        $validated['is_mandatory'] = $request->boolean('is_mandatory');
        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;

        AppNotification::create($validated);

        return redirect()->back()->with('success', 'تم إنشاء ونشر الإشعار بنجاح!');
    }

    /**
     * تبديل حالة التفعيل
     */
    public function toggle(AppNotification $notification)
    {
        $notification->update([
            'is_active' => ! $notification->is_active,
        ]);

        $statusText = $notification->is_active ? 'تفعيل' : 'إلغاء تفعيل';

        return redirect()->back()->with('success', "تم {$statusText} الإشعار بنجاح.");
    }

    /**
     * حذف الإشعار
     */
    public function destroy(AppNotification $notification)
    {
        $notification->delete();

        return redirect()->back()->with('success', 'تم حذف الإشعار بنجاح.');
    }
}
