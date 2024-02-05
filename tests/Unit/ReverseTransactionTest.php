<?php

namespace Tests\Unit;

use App\Antipattern\Session;
use App\Domain\Services\Placetopay\CreateSession;
use App\Domain\Services\Placetopay\RedirectionService;
use App\Domain\Services\Placetopay\ReversePayment;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ReverseTransactionTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_it_can_reverse_transaction()
    {
        $mockedResponse = json_decode(file_get_contents('tests/Mocks/process_reverse.json'),true);
        $internalReference = 10;
        $reverseTransaction = new ReversePayment($internalReference);

        Http::fake([
            $reverseTransaction->url() => Http::response($mockedResponse),
        ]);

        $response = $reverseTransaction->request();

        $this->assertArrayHasKey('status',$response);
        $this->assertEquals('APPROVED',$response['status']['status']);
    }


}
