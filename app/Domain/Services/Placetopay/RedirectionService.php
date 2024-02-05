<?php

namespace App\Domain\Services\Placetopay;

use App\Domain\Contracts\Checkout;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

abstract class RedirectionService implements Checkout
{

    public function auth(): array
    {
        $seed = date('c');
        $nonce = Str::random(8);
        $tranKey = base64_encode(hash('sha1',$nonce.$seed.config('webcheckout.tranKey'),true));

        return [
            'auth' => [
                'login' => config('webcheckout.login'),
                'tranKey' => $tranKey,
                'nonce' => base64_encode($nonce),
                'seed' => $seed
            ]
        ];
    }

    public function request(): mixed
    {
        try {
            $request =  Http::withOptions([
                'verify' => false,
            ])->post($this->url(), $this->data());
        }catch (\Throwable $e){
            throw new \Exception('Error al momento de conectarse con webcheckout on: '.class_basename($this));
        }

        $content = $request->getBody()->getContents();
        return json_decode($content,true);
    }

    abstract public function data(): array;

    abstract public function url(): string;
}
