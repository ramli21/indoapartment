<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\AdminInfo;
use App\Models\Apartment;

class HomepageController extends Controller
{
    public function index()
    {
        $adminInfo = AdminInfo::first();
        $apartments = Apartment::orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        return view('index', ['apartments' => $apartments, 'adminInfo' => $adminInfo]);
    }

    public function aboutUs()
    {
        return "Ini adalah halaman tentang kami.";
    }
}
