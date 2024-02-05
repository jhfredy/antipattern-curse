<?php

namespace Tests\Unit;

use App\Antipattern\Session;
use App\Domain\Services\Placetopay\CreateSession;
use App\Domain\Services\Placetopay\RedirectionService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CreateSessionTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_it_can_create_session()
    {
        $mockedResponse = json_decode(file_get_contents(base_path('tests/Mocks/create_session.json')),true);
        $createSession = new CreateSession(['payment' => [
            'reference' => '123456',
            'description' => 'Testing',
            'amount' => [
                'currency' => 'COP',
                'total' => 100000
            ],
            'allowPartial' => false
        ]]);

        Http::fake([
            $createSession->url() => Http::response($mockedResponse),
        ]);

        $response = $createSession->request();

        $this->assertArrayHasKey('status',$response);
        $this->assertEquals('OK',$response['status']['status']);
        $this->assertArrayHasKey('requestId',$response);
        $this->assertArrayHasKey('processUrl',$response);
    }


}
