<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;

class HomepageController extends Controller
{
    public function index()
    {
        $newest = Apartment::orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        return view('index', ['newestApartments' => $newest]);
    }

    public function aboutUs()
    {
        return "Ini adalah halaman tentang kami.";
    }
}
