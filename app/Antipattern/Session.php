<?php

namespace App\Antipattern;

use Illuminate\Support\Str;

class Session
{
    public function create_session_to_webcheckout_service($p)
    {
        $log = "6dd490faf9cb87a9862245da41170ff2";
        $tra = "024h1IlD";
        $se = date('c');
        $non = Str::random(8);
        $tra = base64_encode(hash('sha1',$non.$se.$tra,true));
        $url = "https://checkout.redirection.test/api/session";
        $expi = date('c', strtotime('+2 days'));

        $session = [
            'auth' => [
                'login' => $log,
                'tranKey' => $tra,
                'nonce' => base64_encode($non),
                'seed' => $se
            ],
            'locale' => 'es_CO',
            'payment' => $p,
            'expiration' => $expi,
            'returnUrl' => 'http://localhost:8000/return',
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'Symphony'
        ];


        $client = new \GuzzleHttp\Client();
        $res = $client->request('post',$url,[
            'json' => $session,
            'verify' => false
        ]);

        if($res){
            if($res->getStatusCode() == 200){
                $content = $res->getBody()->getContents();
                if ($content == null) {
                    throw new \Exception('Error al crear la sesión');
                }
            }else{
                throw new \Exception('Error al crear la sesión');
            }
        }else{
            throw new \Exception('Error al crear la sesión');
        }
        return json_decode($content,true);
    }

    public function get_information_from_webcheckout_service($id)
    {
        $log = "6dd490faf9cb87a9862245da41170ff2";
        $tra = "024h1IlD";
        $se = date('c');
        $non = Str::random(8);
        $tra = base64_encode(hash('sha1',$non.$se.$tra,true));
        $url = "https://checkout.redirection.test/api/session/".$id;

        $auth = [
            'auth' => [
                'login' => $log,
                'tranKey' => $tra,
                'nonce' => base64_encode($non),
                'seed' => $se
            ]
        ];

        $client = new \GuzzleHttp\Client();
        $res = $client->request('post',$url,[
            'json' => $auth,
            'verify' => false
        ]);

        if($res){
            if($res->getStatusCode() == 200){
                $content = $res->getBody()->getContents();
                if ($content == null) {
                    throw new \Exception('Error al obtener la sesión');
                }
            }else{
                throw new \Exception('Error al obtener la sesión');
            }
        }else{
            throw new \Exception('Error al obtener la sesión');
        }
        return json_decode($content,true);
    }

    public function reverse_transaction_from_webcheckout_service($ref)
    {
        $log = "6dd490faf9cb87a9862245da41170ff2";
        $tra = "024h1IlD";
        $se = date('c');
        $non = Str::random(8);
        $tra = base64_encode(hash('sha1', $non . $se . $tra, true));
        $url = "https://checkout.redirection.test/api/reverse";

        $auth = [
            'auth' => [
                'login' => $log,
                'tranKey' => $tra,
                'nonce' => base64_encode($non),
                'seed' => $se
            ],
            'internalReference' => $ref
        ];

        $client = new \GuzzleHttp\Client();
        $res = $client->request('post', $url, [
            'json' => $auth,
            'verify' => false
        ]);

        if($res){
            if($res->getStatusCode() == 200){
                $content = $res->getBody()->getContents();
                if ($content == null) {
                    throw new \Exception('Error al reversar pago');
                }
            }else{
                throw new \Exception('Error al reversar pago');
            }
        }else{
            throw new \Exception('Error al reversar pago');
        }
        return json_decode($content,true);
    }
}
