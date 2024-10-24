<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailerController extends Controller
{
    public function index(Request $request)
    {
        return view('phpmailer.index');
    }
    public function store(Request $request)
    {
        $mail = new PHPMailer(true);
       try {


       }catch (Exception $e) {
           dd($e);
       }
    }
}
