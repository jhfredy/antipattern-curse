<?php

namespace Tests\Unit;

use App\Antipattern\Session;
use App\Domain\Services\Placetopay\CreateSession;
use App\Domain\Services\Placetopay\GetInformation;
use App\Domain\Services\Placetopay\RedirectionService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class InformationSessionTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_it_can_get_pending_information(): void
    {
        $mockedResponse = json_decode(file_get_contents(base_path('tests/Mocks/get_information.json')),true);
        $sessionId = 79;
        $getInformation = new GetInformation($sessionId);

        Http::fake([
            $getInformation->url() => Http::response($mockedResponse),
        ]);

        $response = $getInformation->request();


        $this->assertEquals($sessionId,$response['requestId']);
        $this->assertArrayHasKey('status',$response);
        $this->assertEquals('PENDING',$response['status']['status']);
    }

    public function test_it_can_get_approved_information()
    {
        $mockedResponse = json_decode(file_get_contents(base_path('tests/Mocks/get_approved_information.json')),true);
        $sessionId = 78;
        $getInformation = new GetInformation($sessionId);

        Http::fake([
            $getInformation->url() => Http::response($mockedResponse),
        ]);

        $response = $getInformation->request();

        $this->assertEquals($sessionId,$response['requestId']);
        $this->assertArrayHasKey('status',$response);
        $this->assertEquals('APPROVED',$response['status']['status']);
    }


}
