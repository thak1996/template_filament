<?php

namespace App\Http\Middleware;

use App\Enums\PermissionEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckDashboardAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->routeIs('filament.admin.auth.logout')) {
            return $next($request);
        }
        if (Auth::check()) {
            $user = Auth::user();
            if (! $user->can(PermissionEnum::DASHBOARD_VIEW->value)) {
                return redirect()->route('no-access');
            }
        }

        return $next($request);
    }
}
