<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppFeature;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppFeatureController extends Controller
{
    /**
     * عرض لوحة التحكم بميزات وشاشات التطبيق
     */
    public function index(): View
    {
        $features = AppFeature::orderBy('sort_order')->orderBy('id')->get();
        $totalCount = $features->count();
        $enabledCount = $features->where('is_enabled', true)->count();
        $disabledCount = $features->where('is_enabled', false)->count();

        return view('admin.features.index', compact(
            'features',
            'totalCount',
            'enabledCount',
            'disabledCount'
        ));
    }

    /**
     * تبديل حالة الميزة (تشغيل / إيقاف)
     */
    public function toggle(AppFeature $feature): RedirectResponse
    {
        $feature->update([
            'is_enabled' => ! $feature->is_enabled,
        ]);

        $statusText = $feature->is_enabled ? 'تشغيل وتفعيل' : 'تعطيل وإيقاف';

        return redirect()->back()->with('success', "تم {$statusText} واجهة ({$feature->name}) بنجاح.");
    }

    /**
     * تحديث إعدادات الميزة (نوع الإجراء ورسالة التعطيل)
     */
    public function update(Request $request, AppFeature $feature): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'action_type' => 'required|in:lock,hide',
            'disabled_message' => 'nullable|string|max:500',
            'description' => 'nullable|string|max:1000',
            'icon' => 'nullable|string|max:50',
        ], [
            'name.required' => 'اسم الواجهة مطلوب',
            'action_type.required' => 'نوع الإجراء عند التعطيل مطلوب',
            'action_type.in' => 'نوع الإجراء المحدد غير صالح',
            'disabled_message.max' => 'رسالة التعطيل لا يجب أن تتجاوز 500 حرف',
        ]);

        $feature->update($validated);

        return redirect()->back()->with('success', "تم تحديث إعدادات واجهة ({$feature->name}) بنجاح.");
    }

    /**
     * إضافة واجهة جديدة للتحكم بها
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'key' => 'required|string|max:100|unique:app_features,key|regex:/^[a-zA-Z0-9_]+$/',
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:1000',
            'icon' => 'nullable|string|max:50',
            'action_type' => 'required|in:lock,hide',
            'disabled_message' => 'nullable|string|max:500',
        ], [
            'key.required' => 'المعرّف التقني للواجهة مطلوب',
            'key.unique' => 'هذا المعرّف التقني مسجل مسبقاً',
            'key.regex' => 'المعرّف التقني يجب أن يحتوي على أحرف إنجليزية وأرقام وشرطة سفلية فقط (بدون مسافات)',
            'name.required' => 'اسم الواجهة بالعربية مطلوب',
        ]);

        $validated['is_enabled'] = true;
        $validated['sort_order'] = (AppFeature::max('sort_order') ?? 0) + 1;

        AppFeature::create($validated);

        return redirect()->back()->with('success', "تمت إضافة واجهة ({$validated['name']}) بنجاح.");
    }

    /**
     * حذف واجهة مخصصة
     */
    public function destroy(AppFeature $feature): RedirectResponse
    {
        $name = $feature->name;
        $feature->delete();

        return redirect()->back()->with('success', "تم حذف واجهة ({$name}) من لوحة التحكم.");
    }
}
