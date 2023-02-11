<?php


namespace App\Http\Controllers\Kavenegar;


use App\Http\Services\Eitaa;
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


        $botToken = config('eitaayar.log_group.token');
        $chatId = config('eitaayar.log_group.chat_id');
        Eitaa::sendMessage($botToken, $chatId, $message);

        return response($request);
    }


}