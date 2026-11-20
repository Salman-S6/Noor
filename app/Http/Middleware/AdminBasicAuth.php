<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminBasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $expectedUser = config('services.admin_notifications.user') ?? env('ADMIN_NOTIFICATIONS_USER', 'admin');
        $expectedPassword = config('services.admin_notifications.password') ?? env('ADMIN_NOTIFICATIONS_PASSWORD');

        $user = $request->getUser() ?? $request->server('PHP_AUTH_USER');
        $password = $request->getPassword() ?? $request->server('PHP_AUTH_PW');

        if (
            !$user ||
            !$password ||
            empty($expectedPassword) ||
            !hash_equals((string) $expectedUser, (string) $user) ||
            !hash_equals((string) $expectedPassword, (string) $password)
        ) {
            return response('غير مصرح لك بالدخول (Unauthorized)', 401, [
                'WWW-Authenticate' => 'Basic realm="Admin Notifications Area"',
            ]);
        }

        return $next($request);
    }
}
