<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email does not exist!'], 404);
        }

        // Tạo OTP 6 số
        $otp = rand(100000, 999999);

        // Lưu vào bảng password_resets
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'otp' => $otp,
                'created_at' => now()
            ]
        );

        // Gửi email
        Mail::raw("Mã OTP của bạn là: $otp", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Mã OTP xác nhận quên mật khẩu');
        });

        return response()->json(['message' => 'OTP has been sent!']);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required'
        ]);
    
        $otpData = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();
    
        if (!$otpData) {
            return response()->json(['message' => 'Invalid OTP.'], 400);
        }
    
        // Kiểm tra hạn OTP (5 phút)
        if (Carbon::parse($otpData->created_at)->addMinutes(5)->isPast()) {
            return response()->json(['message' => 'OTP has expired.'], 400);
        }
    
        return response()->json(['message' => 'success']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);
    
        $otpData = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();
    
        if (!$otpData) {
            return response()->json(['message' => 'Invalid OTP.'], 400);
        }
    
        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);
    
        // Xóa OTP
        DB::table('password_resets')->where('email', $request->email)->delete();
    
        return response()->json(['message' => 'Password updated successfully!']);
    }
    
}
