<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use App\DataAPI;

class BlocksController extends Controller
{
    //
    public function blockList(Request $request)
    {
        /**
         * Load from Data API
         */
        $dataAPI = new DataAPI(
            new Client([ 'base_uri' => config('dataapi.baseURI')])
        );
        $token = $dataAPI->getToken(
            config('dataapi.clientId'),
            config('dataapi.clientKey')
        );

        $user = $dataAPI->getUser(
            $request->get('username'),
            $token
        );

        $data = array(
            'userData' => $user,
            'username' => $request->get('username'),
            'logout'   => $request->get('logoutUrl'),
        );

        if (null !== $user && null !== $user['blocks'])
        {
            return view('blocks/blocks', $data);
        }
        elseif (null !== $user)
        {
            return view('error/noBlocks', $data);
        }
        else
        {
            Log::info( 'User '. (null !== $request->get('username') ? $request->get('username') : '[NOT SET]') .' logged in, had no student record');
            return view('error/notStudent', $data);
        }

    }
}
