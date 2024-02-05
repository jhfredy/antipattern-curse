<?php

namespace App\Domain\Services\Placetopay;

class CreateSession extends RedirectionService
{
    public function __construct(private readonly array $data)
    {
    }

    public function data(): array
    {
        return array_merge($this->auth(),[
            'locale' => 'es_CO',
            'payment' => $this->data['payment'],
            'ipAddress' => '127.0.0.1',
            'returnUrl' => 'http://localhost:8000/return',
            'expiration' => date('c', strtotime('+2 days')),
            'userAgent' => 'Symphony'
        ]);
    }

    public function url(): string
    {
        return config('webcheckout.url').'/api/session';
    }
}
