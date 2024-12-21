<?php

namespace App\Core;

use App\Core\NewException;


/**
 * TOKEN BASIC CLASS
 */
class TokenBasic
{

    public static function getTokenBasic(string $authorizationHeader): string
    {
        //<Basic ><token>  there is a space between basic and token
        $matches = array();
        preg_match('/Basic (.+)/', $authorizationHeader, $matches);
        $token = $matches[1];

        return $token;
    }


    public static function setTokenBasic(string $email, string $psw)
    {
        (new DotEnv(PATH_ENV . 'key.env'))->load();
        $key = getenv('API_KEY');

        $payload = array(
            'email' => $email,
            'psw' => $psw,
            'key' => $key
        );

        return (new self)->encodeTokenBasic($payload);
    }


    public static function validateTokenBasic(string $token)
    {
        (new DotEnv(PATH_ENV . 'key.env'))->load();
        $key = getenv('API_KEY');

        $payload = (new self)->decodeTokenBasic($token);

        if ($payload['key'] === $key) {
            return true;
        } else {
            return false;
        }
    }



    /**
     * Use this function when creating or updating User Credentials
     */
    private function encodeTokenBasic(array $payload)
    {
        $payload = json_encode($payload);
        $token = $this->base64URLEncode($payload);

        return $token;
    }

    private function decodeTokenBasic(string $token): array
    {

        $payload = json_decode($this->base64URLDecode($token), true);
        return $payload;
    }


    private function base64URLEncode(string $text): string
    {

        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($text));
    }


    private function base64URLDecode(string $text): string
    {
        return base64_decode(
            str_replace(
                ["-", "_"],
                ["+", "/"],
                $text
            )
        );
    }

    //END CLASS
}