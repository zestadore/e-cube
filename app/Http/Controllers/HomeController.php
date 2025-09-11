<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\Qualification;
use App\Models\ComputerAndOtherSkill;
use App\Models\Industry;
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
                return redirect()->route('admin.dashboard');
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

    public function adminDashboard(){
        return view('admin.dashboard.index');
    }

    public function chooseType(){
        $basics=Auth::user()->basics;
        if($basics){
            return redirect()->route('basic-details.index');
        }
        return view('choose_type');
    }

    public function registerAsJobSeeker(){
        $qualifications = Qualification::get();
        $skills = ComputerAndOtherSkill::get();
        $industries = Industry::get();
        $basics=Auth::user()->basics;
        return view('users.registration.candidate',compact('qualifications','skills','industries','basics'));
    }

    public function registerAsEmployer(){
        dd('register_as_employer');
    }
}
