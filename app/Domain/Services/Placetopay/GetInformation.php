<?php

namespace App\Domain\Services\Placetopay;

class GetInformation extends RedirectionService
{
    public function __construct(private readonly int $session_id)
    {
    }

    public function data(): array
    {
        return $this->auth();
    }

    public function url(): string
    {
        return config('webcheckout.url').'/api/session/'.$this->session_id;
    }
}
