<?php

namespace Tests\Unit;

use App\Antipattern\Session;
use App\Services\WebcheckoutService;
use Tests\TestCase;

class SessionTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_it_can_create_session()
    {
        $session = new Session();
        $payment = [
            'reference' => 'TEST_1000',
            'description' => 'conexion con webcheckout desde un test',
            'amount' => [
                'currency' => 'COP',
                'total' => '10000'
            ]
        ];

        $response = $session->create_session_to_webcheckout_service($payment);
        dump($response);
        $this->assertArrayHasKey('status',$response);
        $this->assertEquals('OK',$response['status']['status']);
        $this->assertArrayHasKey('requestId',$response);
        $this->assertArrayHasKey('processUrl',$response);
    }

    public function test_it_can_get_information_from_pending_session()
    {
        $session = new Session();
        $payment = [
            'reference' => 'TEST_1000',
            'description' => 'conexion con webcheckout desde un test',
            'amount' => [
                'currency' => 'COP',
                'total' => '10000'
            ]
        ];

        $response = $session->create_session_to_webcheckout_service($payment);

        $this->assertArrayHasKey('status',$response);
        $this->assertEquals('OK',$response['status']['status']);
        $this->assertArrayHasKey('requestId',$response);
        $this->assertArrayHasKey('processUrl',$response);

        $session_id = $response['requestId'];
        $responseGetSession = $session->get_information_from_webcheckout_service($session_id);
        $this->assertEquals($session_id,$responseGetSession['requestId']);
        $this->assertArrayHasKey('status',$responseGetSession);
        $this->assertEquals('PENDING',$responseGetSession['status']['status']);
    }

    public function test_it_can_get_information_from_approved_session_and_can_reverse()
    {
        $session = new Session();
        $session_id = 71;
        $responseGetSession = $session->get_information_from_webcheckout_service($session_id);
        $internalReference = $responseGetSession['payment'][0]['internalReference'];
        $this->assertEquals($session_id,$responseGetSession['requestId']);
        $this->assertArrayHasKey('status',$responseGetSession);
        $this->assertEquals('APPROVED',$responseGetSession['status']['status']);

        $responseReverse = $session->reverse_transaction_from_webcheckout_service($internalReference);
        $this->assertArrayHasKey('status',$responseReverse);
        $this->assertEquals('APPROVED',$responseReverse['status']['status']);
    }

}
