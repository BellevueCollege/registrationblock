<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;

use App\DataAPI;

class StudentInfoTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function setUp() : void
    {
        parent::setUp();
        Cache::flush();

        $this->validToken = 'valid_token';
        $this->invalidToken = null;

        $this->dataAPIValidCreds = new DataAPI(
            new Client(['handler' => HandlerStack::create(
                new MockHandler([
                    new Response(200, [], '{"access_token": "'.$this->validToken.'","token_type": "bearer","expires_in": 3600}'),
                ])
            )])
        );

        $this->dataAPIInvalidCreds = new DataAPI(
            new Client(['handler' => HandlerStack::create(
                new MockHandler([
                    new Response(401, [], '{"error": "Unauthorized"}'),
                ])
            )])
        );

        $this->dataAPIUserValidToken = new DataAPI(
            new Client(['handler' => HandlerStack::create(
                new MockHandler([
                    new Response(200, [], '{
                        "data": {
                            "SID": 954999993,
                            "firstName": "Student",
                            "lastName": "Test",
                            "email": "t.test@bellevuecollege.edu",
                            "phoneDaytime": "4255645662",
                            "phoneEvening": null,
                            "username": "t.test",
                            "blocks": [
                                {
                                    "blockId": "A0",
                                    "reason": "Please contact the Athletics department to discuss the block on your record at 425-564-2351."
                                }
                            ]
                        }
                    }'),
                ])
            )])
        );

        $this->dataAPIUserInvalidToken = new DataAPI(
            new Client(['handler' => HandlerStack::create(
                new MockHandler([
                    new Response(200, [], '{"access_token": "'.$this->validToken.'","token_type": "bearer","expires_in": 3600}'),
                ])
            )])
        );
    }


    /**
     * Valid Response
     */
    public function testLoadTokenValidCreds()
    {
        $token = $this->dataAPIValidCreds->getToken('username', 'password');
        $this->assertEquals(
            $token,
            $this->validToken,
            'Token returned should match expected value'
        );
    }


    /**
     * Invalid (unauthorized) Response
     */
    public function testLoadTokenInvalidCreds()
    {
        $token = $this->dataAPIInvalidCreds->getToken('username', 'password');
        $this->assertEquals(
            $token,
            $this->invalidToken,
            'null should be returned on invalid login. current token: ' . $token
        );
    }


    /**
     * Load User Data With Valid Token
     */
    public function testLoadUserDataValidToken()
    {
        $token = $this->validToken;
        $user = $this->dataAPIUserValidToken->getUser(
            't.test',
            $token
        );

        $this->assertEquals(
            $user['firstName'],
            'Student',
            'First Name should match expected value'
        );
        $this->assertEquals(
            $user['lastName'],
            'Test',
            'Last Name should match expected value'
        );
        $this->assertEquals(
            $user['blocks'][0]->blockId,
            'A0',
            'Block ID should match expected value'
        );
        $this->assertEquals(
            $user['blocks'][0]->reason,
            'Please contact the Athletics department to discuss the block on your record at 425-564-2351.',
            'Block reason should match expected value'
        );
    }


    /**
     * Load User Data With Invalid Token
     */
    public function testLoadUserDataInvalidToken()
    {
        $token = $this->validToken;
        $user = $this->dataAPIInvalidCreds->getUser(
            't.test',
            $token
        );

        $this->assertEquals(
            $user,
            null,
            'Token returned should match expected value'
        );
    }
}
