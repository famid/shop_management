<?php

namespace App\Http\Controllers\Shopkeeper;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index() {
        return view('shopkeeper.home');
    }
}
