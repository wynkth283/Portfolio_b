<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next): Response
    {
        // Lấy token từ query string hoặc session
        $token = $request->query('token') ?? session('admin_token');
        
        if ($token) {
            // Validate token
            $accessToken = PersonalAccessToken::findToken($token);
            
            if ($accessToken) {
                $user = $accessToken->tokenable;
                
                if ($user && $user->role === 'admin') {
                    // Lưu token vào session cho các request tiếp theo
                    session(['admin_token' => $token]);
                    session(['admin_user' => $user]);
                    
                    return $next($request);
                }
            }
        }
        
        // Nếu không phải admin, chuyển hướng về frontend
        return redirect(env('FRONTEND_URL'))->with('error', 'Unauthorized access');
    }
}