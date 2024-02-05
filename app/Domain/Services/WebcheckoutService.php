<?php

namespace App\Domain\Services;

use App\Domain\Services\Placetopay\CreateSession;
use App\Domain\Services\Placetopay\GetInformation;
use App\Domain\Services\Placetopay\ReversePayment;

class WebcheckoutService
{

    public function createSession(array $data)
    {
        return (new CreateSession($data))->request();
    }

    public function getInformation(int $session_id)
    {
        return (new GetInformation($session_id))->request();
    }

    public function reverseTransaction(int $internalReference)
    {
        return (new ReversePayment($internalReference))->request();
    }
}
