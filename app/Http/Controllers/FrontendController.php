<?php

namespace App\Http\Controllers;
use App\Models\Industry;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $industries = Industry::doesntHave('parents')->where('status', 1)->get();
        return view('welcome', compact('industries'));
    }
}
