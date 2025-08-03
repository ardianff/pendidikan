<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function landingPage(Request $request)
    {
        return view('pages.front.landing.index');
    }
}
