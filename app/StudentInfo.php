<?php

namespace App;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class StudentInfo
{
    //
    protected $client;
    protected $clientId;
    protected $clientKey;
    protected $baseURI;
    protected $key;
    public $data;

    public function __construct( $username )
    {
        $this->clientId  = config('dataapi.clientId');
        $this->clientKey = config('dataapi.clientKey');
        $this->baseURI   = config('dataapi.baseURI');
        
        $this->client = new Client(['base_uri' => $this->baseURI]);

        $token = $this->loadToken($this->client, $this->clientId, $this->clientKey);
        $this->data = $this->loadUserInfo($this->client, $username, $token);
    }

    /**
     * Get Authentication Token using ID and Key
     */
    private function loadToken( $client, $user, $pass )
    {
        $body = array(
            'clientid'  => $user,
            'clientkey' => $pass,
        );

        // Load token and cache for 30 seconds. //TODO - Encrypt?
        $token = Cache::remember('api_token', now()->addSeconds(30), function () use($client, $body) {
            $tokenRequest = $client->request('POST', 'auth/login', ['form_params' => $body]);
            $tokenRequest = json_decode((string) $tokenRequest->getBody())->access_token;
            return $tokenRequest;
        });
        return $token;
    }

    /**
     * Pull User Info from API
     */
    private function loadUserInfo($client, $username, $token)
    {

        //
        // Build authentication headers
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ];

        // Make API request
        $raw = $client->request('GET', "student/$username", ['headers' => $headers]);
        $raw = json_decode((string) $raw->getBody());
        //dd($raw);
        // Build data array
        if (isset($raw->data))
        {
            $processed = [
                'firstName' => $raw->data->firstName,
                'lastName'  => $raw->data->lastName,
                'blocks'    => $raw->data->blocks,
            ];
        } else {
            $processed = null;
        }
        return $processed;
    }

    public function getUser()
    {
        if (isset($this->data))
        {
            return $this->data;
        } else {
            return null;
        }
    }
}
