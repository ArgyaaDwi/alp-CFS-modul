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
    public function dashboardSalesManager()
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        return view('pages.role_sm.dashboard', compact('user', 'currentDate'));
    }
    public function dashboardAdmin()
    {

        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        return view( 'pages.role_admin.dashboard', compact('user',  'currentDate'));
    }
    public function dashboardQualityManager()
    {

        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        return view('pages.role_qm.dashboard', compact('user', 'currentDate'));
    }
    public function dashboardFGM()
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        return view('pages.role_fgm.dashboard', compact('user', 'currentDate'));
    }
}
