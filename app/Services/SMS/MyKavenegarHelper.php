<?php


namespace App\Services\SMS;


use Illuminate\Support\Facades\Log;

class MyKavenegarHelper
{
    public static function send($phoneNumber, $message)
    {
        $curl = curl_init();

        $api_key = env('KAVENEGAR_API_KEY');

        Log::info(' mobile=' . $phoneNumber . ' message=' . $message . ' apikey=' . $api_key);

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.kavenegar.com/v1/' . $api_key . '/sms/send.json',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'receptor=' . $phoneNumber . '&message=' . $message,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

    }
}