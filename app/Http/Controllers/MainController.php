<?php

namespace App\Http\Controllers;

use Artisan;
use Illuminate\Http\Request;

class MainController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Artisan::call($request->command);
    }
}
