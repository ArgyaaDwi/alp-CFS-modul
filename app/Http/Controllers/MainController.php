<?php

namespace App\Http\Controllers;

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
        return view('pages.role_user.dashboard', compact('user'));
    }
    public function dashboardAdmin()
    {
        $admin = Auth::user();
        return view( 'pages.role_admin.dashboard', compact('admin'));
    }
    public function dashboardQualityManager()
    {
        $qm = Auth::user();
        return view('pages.role_qm.dashboard', compact('qm'));
    }
    public function dashboardFGM()
    {
        $fgm = Auth::user();
        return view('pages.role_fgm.dashboard', compact('fgm'));
    }
}
