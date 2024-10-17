<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function waiting()
    {
        return view('pages.waiting');
    }
    public function dashboardUser()
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        return view('pages.role_user.dashboard', compact('user', 'currentDate'));
    }
    public function dashboardAdmin()
    {

        $admin = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        return view( 'pages.role_admin.dashboard', compact('admin', 'currentDate'));
    }
    public function dashboardQualityManager()
    {

        $qm = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        return view('pages.role_qm.dashboard', compact('qm', 'currentDate'));
    }
    public function dashboardFGM()
    {
        $fgm = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        return view('pages.role_fgm.dashboard', compact('fgm', 'currentDate'));
    }
}
