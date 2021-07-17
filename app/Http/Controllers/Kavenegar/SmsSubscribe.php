<?php


namespace App\Http\Controllers\Kavenegar;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SmsSubscribe
{
    public static function webhook(Request $request)
    {
        Log::info("webhook kavenegar: " . $request);

        $users = User::query()->where('mobile', $request->mobile)->get();

        foreach ($users as $user) {
            $user->sms_subscribe = 1;
            $user->save();
        }

        return response($request);
    }
}