<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $redirectToRoute = null): Response
    {
        $user = $request->user();
        
        if (! $user) {
            return $request->expectsJson()
                ? abort(401, 'Unauthenticated.')
                : redirect()->guest(route('login'));
        }

        if (! $user->hasVerifiedEmail()) {
            // If user doesn't have a valid OTP, send a new one
            if (!$user->otp || $user->otp->isExpired()) {
                $user->sendOtpNotification();
                session(['otp_user_id' => $user->id]);
            }
            
            return $request->expectsJson()
                ? abort(403, 'Your email address is not verified.')
                : redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
