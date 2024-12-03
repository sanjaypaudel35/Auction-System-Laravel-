<?php

namespace App\Http\Controllers\Auth;

use App\Enums\RolesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Inertia\Inertia;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    public function forgetPassword(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse|View
    {
        $request->authenticate();

        $request->session()->regenerate();

        $authUser = Auth::user();
        if (!$authUser->hasVerifiedEmail()) {
            $request->user()->sendEmailVerificationNotification();
            return view('auth.verify-email');
        } else {
            if ($authUser?->role?->slug== RolesEnum::CUSTOMER->value) {
                return redirect()->intended(RouteServiceProvider::FRONTEND);
            } else {
                return redirect()->intended(RouteServiceProvider::HOME);
            }
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
