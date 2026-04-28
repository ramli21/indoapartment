<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProyekController extends Controller
{
    public function show() {
        // return "Ini adalah halaman detail proyek saya.";

        return view('index');
    }
}
