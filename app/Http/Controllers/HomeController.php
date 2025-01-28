<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function showMessage()
{
    return view('home', ['message' => 'Hello from the Blade template!']);
}

}
