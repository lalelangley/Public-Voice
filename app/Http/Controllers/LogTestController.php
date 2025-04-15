<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class LogTestController extends Controller
{
    public function testLog()
    {
        Log::info('Test log entry');
        return 'Log entry has been made!';
    }
}
