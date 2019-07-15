<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cache;

class DataAPI
{
    //
    protected $client;
    protected $clientId;
    protected $clientKey;
    protected $baseURI;
    protected $key;
    public $data;

    public function __construct(
        $client
    )
    {
        $this->client = $client;

        //$token = $this->loadToken();
        //$this->data = $this->loadUserInfo($this->client, $username, $token);
    }

    /**
     * Get Authentication Token using ID and Key
     */
    public function getToken($user, $pass)
    {
        $body = array(
            'clientid'  => $user,
            'clientkey' => $pass,
        );

        // Load token and cache for 30 seconds. //TODO - Encrypt?
        $token = Cache::remember('api_token', now()->addSeconds(30), function () use($body) {

            // Catch guzzle errors. If error, return null and log error
            try
            {
                $tokenRequest = $this->client->request('POST', 'auth/login', ['form_params' => $body]);
                $tokenRequest = json_decode((string) $tokenRequest->getBody())->access_token;
                return $tokenRequest;
            }
            catch(ClientException $exception)
            {
                report($exception);
                return null;
            }
        });
        return $token;
    }

    /**
     * Pull User Info from API
     */
    public function getUser($username, $token)
    {

        // Build authentication headers
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ];

        // Catch guzzle errors. If error, return null and log error
        try
        {
            // Make API request
            $raw = $this->client->request('GET', "student/$username", ['headers' => $headers]);
            $raw = json_decode((string) $raw->getBody());

            // Build data array
            if (isset($raw->data))
            {
                return [
                    'firstName' => $raw->data->firstName,
                    'lastName'  => $raw->data->lastName,
                    'blocks'    => $raw->data->blocks, // array of objects, 'blockID' and 'reason'
                ];
            }
            return null;

        }
        catch(ClientException $exception)
        {
            report($exception);
            return null;
        }
    }
}
