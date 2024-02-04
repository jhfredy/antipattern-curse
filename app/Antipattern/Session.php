<?php

namespace App\Antipattern;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Session
{
    public function create_session_to_webcheckout_service($payment, $expiration, $returnUrl)
    {
        $login = "6dd490faf9cb87a9862245da41170ff2";
        $tranKey = "024h1IlD";
        $seed = date('c');
        $nonce = Str::random(8);
        $tranKey = base64_encode(hash('sha1',$nonce.$seed.$tranKey,true));
        $url = "https://checkout.redirection.test/api/session";

        $session = [
            'auth' => [
                'login' => $login,
                'tranKey' => $tranKey,
                'nonce' => base64_encode($nonce),
                'seed' => $seed
            ],
            'locale' => 'es_CO',
            'payment' => $payment,
            'expiration' => $expiration,
            'returnUrl' => $returnUrl,
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'Symphony'
        ];


        $client = new \GuzzleHttp\Client();
        $response = $client->request('post',$url,[
            'json' => $session,
            'verify' => false
        ]);

        $content = $response->getBody()->getContents();
        return json_decode($content,true);
    }

    public function get_information_from_webcheckout_service($session_id)
    {
        $login = "6dd490faf9cb87a9862245da41170ff2";
        $tranKey = "024h1IlD";
        $seed = date('c');
        $nonce = Str::random(8);
        $tranKey = base64_encode(hash('sha1',$nonce.$seed.$tranKey,true));
        $url = "https://checkout.redirection.test/api/session/".$session_id;

        $auth = [
            'auth' => [
                'login' => $login,
                'tranKey' => $tranKey,
                'nonce' => base64_encode($nonce),
                'seed' => $seed
            ]
        ];

        $client = new \GuzzleHttp\Client();
        $response = $client->request('post',$url,[
            'json' => $auth,
            'verify' => false
        ]);

        $content = $response->getBody()->getContents();
        return json_decode($content,true);
    }

    public function reverse_transaction_from_webcheckout_service($internalReference)
    {
        $login = "6dd490faf9cb87a9862245da41170ff2";
        $tranKey = "024h1IlD";
        $seed = date('c');
        $nonce = Str::random(8);
        $tranKey = base64_encode(hash('sha1', $nonce . $seed . $tranKey, true));
        $url = "https://checkout.redirection.test/api/reverse";

        $auth = [
            'auth' => [
                'login' => $login,
                'tranKey' => $tranKey,
                'nonce' => base64_encode($nonce),
                'seed' => $seed
            ],
            'internalReference' => $internalReference
        ];

        $client = new \GuzzleHttp\Client();
        $response = $client->request('post', $url, [
            'json' => $auth,
            'verify' => false
        ]);

        $content = $response->getBody()->getContents();
        return json_decode($content, true);
    }
}
