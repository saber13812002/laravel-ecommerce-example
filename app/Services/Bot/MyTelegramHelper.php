<?php


namespace App\Services\Bot;


use Illuminate\Support\Facades\Log;

class MyTelegramHelper
{
    public static function send($message, $chat_id, $token)
    {
        $curl = curl_init();

        Log::info('pardisania bot token : ' . $token . ' message: ' . $message . 'chat_id: ' . $chat_id);

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.telegram.org/bot' . $token . '/sendMessage?chat_id=' . $chat_id . '&text=' . $message,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        //echo $response;
    }

    public static function sendMessage($message)
    {
        $chat_id = config('telegrambot.php_group_chat_id');
        $token = env('PARDISANIA_BOT_TOKEN');
        MyTelegramHelper::send($message, $chat_id, $token);
    }
}