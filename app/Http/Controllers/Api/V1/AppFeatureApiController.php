<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\AppFeature;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppFeatureApiController extends Controller
{
    /**
     * جلب حالة جميع ميزات وواجهات التطبيق
     */
    public function index(Request $request): JsonResponse
    {
        $features = AppFeature::orderBy('sort_order')->orderBy('id')->get();

        $dictionary = [];
        $list = [];

        foreach ($features as $feature) {
            $item = [
                'key' => $feature->key,
                'name' => $feature->name,
                'description' => $feature->description,
                'icon' => $feature->icon,
                'is_enabled' => (bool) $feature->is_enabled,
                'action' => $feature->action_type, // 'lock' أو 'hide'
                'message' => ! $feature->is_enabled
                    ? ($feature->disabled_message ?: 'هذه الميزة معطلة مؤقتاً.')
                    : null,
            ];

            $dictionary[$feature->key] = $item;
            $list[] = $item;
        }

        return response()->json([
            'status' => 'success',
            'features' => $dictionary, // قاموس للوصول المباشر عبر المفتاح: features['reports_summary']
            'features_list' => $list,  // مصفوفة للعرض المباشر في القوائم
        ], 200);
    }
}
