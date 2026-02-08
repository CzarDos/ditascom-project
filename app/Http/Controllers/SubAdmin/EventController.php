<?php

namespace App\Http\Controllers\SubAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $parishName = Auth::user()->parish_name;
        return view('subadmin.events', compact('parishName'));
    }
} 