<?php

namespace App\Http\Services;

class Eitaa
{

    public static function sendMessage(string $botToken, string $chatId, ?string $message)
    {
        $defaultMessage = 'send message by api';

        // initialise the curl request
        $request = curl_init('https://eitaayar.ir/api/' . $botToken . '/sendMessage');

//        dd($request,$botToken, $chatId, $message);

        // send a message
        curl_setopt($request, CURLOPT_POST, true);
        curl_setopt($request, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt(
            $request, CURLOPT_POSTFIELDS,
            array(
                'chat_id' => $chatId,
                'title' => $message ?? $defaultMessage,
                'text' => $message ?? $defaultMessage,
                'date' => time() + 1, // send next 30 second
            ));

        // output the response
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        echo curl_exec($request);

        // close the session
        curl_close($request);
    }

    public static function sendFile(string $botToken, string $chatId, string $fileName, string $title, string $caption)
    {
        $defaultCaption = 'text of caption file';
        $defaultTitle = 'send file by api';

        // initialise the curl request
        $request = curl_init('https://eitaayar.ir/api/' . $botToken . '/sendFile');

        // send a file
        curl_setopt($request, CURLOPT_POST, true);
        curl_setopt($request, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt(
            $request, CURLOPT_POSTFIELDS,
            array(
                'file' => new \CurlFile(realpath($fileName ?? 'C:/Users/eitaa/Desktop/eitaa.apk')),
                'chat_id' => $chatId,
                'title' => $title ?? $defaultTitle,
                'caption' => $caption ?? $defaultCaption,
                'date' => time() + 1, // send next 30 second
                //     TODO:           pin
                //     TODO:        viewCountForDelete
            ));

        // output the response
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        echo curl_exec($request);

        // close the session
        curl_close($request);
    }
}