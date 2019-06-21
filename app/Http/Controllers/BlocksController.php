<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class BlocksController extends Controller
{
    //
    public function blockList()
    {
        $student = session('username');

        $clientId = config('dataapi.clientId');
        $clientKey = config('dataapi.clientKey');
        $baseURI = config('dataapi.baseURI');
        $body = array(
            'clientid' => $clientId,
            'clientkey' => $clientKey,
        );

        $client = new Client(['base_uri' => $baseURI]);

        $token = $client->request('POST', 'auth/login', ['form_params' => $body]);
        $token = json_decode((string) $token->getBody())->access_token;

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ];
        $studentInfo = $client->request('GET', "student/$student", ['headers' => $headers]);
        $studentInfo = json_decode((string) $studentInfo->getBody(), true);
        //dd( $studentInfo);
        //return($studentInfo);
        return view('blocks/blocks', $studentInfo['data']);

    }
}
