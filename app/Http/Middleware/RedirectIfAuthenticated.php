<?php

namespace App\Http\Middleware;

use App\Enums\RolesEnum;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $authUser = Auth::user();
                if ($authUser->role->slug == RolesEnum::SUPER_ADMIN->value) {
                    return redirect(RouteServiceProvider::HOME);
                } else {
                    return redirect(RouteServiceProvider::FRONTEND);
                }
            }
        }

        return $next($request);
    }
}
