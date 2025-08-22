<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        switch (Auth::user()->role) {
            case 'admin':
                return redirect('/admin');
                break;
            case 'super_admin':
                return redirect('/super_admin');
                break;
            case 'employee':
                return redirect('/employee');
                break;
            case 'employer':
                return redirect('/employer');
                break;
            default:
                return redirect('/select-option');
                break;
        }
    }

    public function chooseType(){
        return view('choose_type');
    }

    public function registerAsJobSeeker(){
        dd('register_as_job_seeker');
    }

    public function registerAsEmployer(){
        dd('register_as_employer');
    }
}
