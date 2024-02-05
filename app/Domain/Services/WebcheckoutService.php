<?php

namespace App\Domain\Services;

use App\Domain\Services\Placetopay\CreateSession;
use App\Domain\Services\Placetopay\GetInformation;
use App\Domain\Services\Placetopay\ReversePayment;

class WebcheckoutService
{

    public function createSession(array $data): CreateSession
    {
        return (new CreateSession($data));
    }

    public function getInformation(int $session_id): GetInformation
    {
        return (new GetInformation($session_id));
    }

    public function reverseTransaction(int $internalReference): ReversePayment
    {
        return (new ReversePayment($internalReference));
    }
}
