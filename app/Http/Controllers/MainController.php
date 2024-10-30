<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Complaints;

class MainController extends Controller
{
    public function waiting()
    {
        return view('pages.waiting');
    }
    public function dashboardSalesManager()
    {
        $user = Auth::user();
        $distributors = Distributor::where('company_distributor_id', $user->distributor_id)->get();
        $complaints = Complaints::where('main_distributor_id', $user->distributor_id)->get();
        $counts = $complaints->count();
        $distributor = Distributor::all();
        $count = $distributors->count();
        $allFeedback = Complaints::all()->count();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        return view('pages.role_sm.dashboard', compact('user', 'currentDate', 'distributors', 'count', 'complaints', 'counts', 'distributor', 'allFeedback'));
    }
    public function dashboardAdmin()
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        return view('pages.role_admin.dashboard', compact('user',  'currentDate'));
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
