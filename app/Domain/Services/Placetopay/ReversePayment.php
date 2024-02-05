<?php

namespace App\Domain\Services\Placetopay;

class ReversePayment extends RedirectionService
{

    public function __construct(private readonly int $internalReference)
    {
    }

    public function data(): array
    {
        return array_merge($this->auth(),[
            'internalReference' => $this->internalReference
        ]);
    }

    public function url(): string
    {
        return config('webcheckout.url').'/api/reverse/';
    }
}
