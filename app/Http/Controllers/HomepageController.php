<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index() {
        return view('index');
    }

    public function contact() {
        return "Ini adalah halaman kontak saya.";
    }
}


// AuthController
//     login - form
//     login - action
//     register - form
//     register - action