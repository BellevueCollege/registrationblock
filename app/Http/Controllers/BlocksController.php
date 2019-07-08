<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use App\DataAPI;

class BlocksController extends Controller
{
    //
    public function blockList()
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
            'local' !== config('app.env') ? session('username') : 't.test',
            $token
        );

        $data = array(
            'userData' => $user,
            'username' => session('username'),
            'logout'   => session('logout_url'),
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
            Log::info( 'User '. (null !== session('username') ? session('username') : '[NOT SET]') .' logged in, had no student record');
            return view('error/notStudent', $data);
        }

    }
}
