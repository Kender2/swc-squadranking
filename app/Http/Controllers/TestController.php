<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;

class TestController extends Controller
{
    use DispatchesJobs;

    public function test()
    {
        return 'ok';
    }
}
