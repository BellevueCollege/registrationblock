<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StudentInfo;

class BlocksController extends Controller
{
    //
    public function blockList()
    {
        $student = new StudentInfo(session('username'));
        $data = array(
            'userData' => $student->getUser(),
            'username' => session('username'),
            'logout'   => session('logout_url'),
        );
        if (null !== $student->getUser() && null !== $student->getUser()['blocks'])
        {
            return view('blocks/blocks', $data);
        }
        elseif (null !== $student->getUser())
        {
            return view('error/noBlocks', $data);
        }
        else
        {
            return view('error/notStudent', $data);
        }

    }
}
