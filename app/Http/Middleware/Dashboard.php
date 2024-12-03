<?php

namespace App\Http\Middleware;

use App\Enums\RolesEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Dashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            Auth::user()?->role?->slug == RolesEnum::SUPER_ADMIN->value
            || Auth::user()?->role?->slug == RolesEnum::MASTER_ADMIN->value
        ) {
            return $next($request);
        } else {
            return redirect()->route("products.index");
        }
    }
}
