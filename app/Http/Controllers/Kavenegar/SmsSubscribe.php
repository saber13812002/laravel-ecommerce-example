<?php


namespace App\Http\Controllers\Kavenegar;


use App\Services\Bot\MyTelegramHelper;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SmsSubscribe
{
    public static function webhook(Request $request)
    {
        Log::info("webhook kavenegar: " . $request);

        $users = User::query()->where('mobile', $request->mobile)->get();

        $name = "";

        foreach ($users as $user) {
            $user->sms_subscribe = 1;
            $user->save();
            $name = $user->name;
        }

        $message = trans('bot.webhook', ['name' => $name]);
        MyTelegramHelper::sendMessage($message);

        return response($request);
    }


}