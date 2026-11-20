<?php

namespace App\Http\Middleware;

use App\Models\AppFeature;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckFeatureEnabled
{
    /**
     * التحقق من تفعيل الميزة قبل السماح بالوصول للـ API
     */
    public function handle(Request $request, Closure $next, string $featureKey): Response
    {
        $feature = AppFeature::findByKey($featureKey);

        if ($feature && ! $feature->is_enabled) {
            return response()->json([
                'status' => 'disabled',
                'feature' => $featureKey,
                'message' => $feature->disabled_message ?: 'هذه الميزة معطلة مؤقتاً.',
                'action' => $feature->action_type,
            ], 403);
        }

        return $next($request);
    }
}
