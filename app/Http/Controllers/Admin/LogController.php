<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;

class LogController extends Controller
{
    public function index() {
        return view('pages.log.index', [
            'log' => Log::class
        ]);
    }
}
