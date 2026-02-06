<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Counter;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
       

        return view('welcome');
          
       
    }
}
