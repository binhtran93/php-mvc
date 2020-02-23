<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 23/02/2020
 * Time: 15:37
 */

namespace Utils;


use DateTime;

class JWT {

    /**
     * @param $key
     * @param $secret
     * @param array $payload
     * @return string
     * @throws \Exception
     */
    public static function generate($key, $secret, $payload=[]) {
        $now = new DateTime();

        $payloadJson = json_encode($payload);

        $encodedKey = self::base64UrlEncode($key);
        $encodedPayload = self::base64UrlEncode($payloadJson);
        $encodedTimestamp = self::base64UrlEncode($now->getTimestamp());

        $signature = hash_hmac('sha256', $encodedKey . "." . $encodedPayload . "." . $encodedTimestamp, $secret, true);
        $encodedSignature = self::base64UrlEncode($signature);

        return $encodedKey . "." . $encodedPayload . "." . $encodedTimestamp . "." . $encodedSignature;
    }

    /**
     * @param $token
     * @param $secret
     * @return bool
     */
    public static function verify($token, $secret) {
        // split the token
        $parts   = explode('.', $token);
        $key  = base64_decode($parts[0]);
        $payload = base64_decode($parts[1]);
        $timestamp = base64_decode($parts[2]);

        $signatureProvided = $parts[3];

        // build a signature based on the header and payload using the secret
        $encodedKey = self::base64UrlEncode($key);
        $encodedPayload = self::base64UrlEncode($payload);
        $encodedTimestamp = self::base64UrlEncode($timestamp);

        $signature = hash_hmac('sha256', $encodedKey . "." . $encodedPayload . "." . $encodedTimestamp, $secret, true);
        $encodedSignature = self::base64UrlEncode($signature);

        return $encodedSignature === $signatureProvided;
    }

    /**
     * @param $text
     * @return mixed
     */
    private static function base64UrlEncode($text)
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($text));
    }
}

//$jwt = new JWT();
//$token = $jwt->generate('public', 'secret');
//
//echo $token;
//var_dump($jwt->verify($token));