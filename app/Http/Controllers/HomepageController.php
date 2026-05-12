<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\AdminInfo;

class HomepageController extends Controller
{
    public function index()
    {
        $adminInfo = AdminInfo::first();
        $newest = Room::orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        return view('index', ['newestRooms' => $newest, 'adminInfo' => $adminInfo]);
    }

    public function aboutUs()
    {
        return "Ini adalah halaman tentang kami.";
    }
}
