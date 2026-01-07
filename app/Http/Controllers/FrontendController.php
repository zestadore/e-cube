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

    public function about_us()
    {
        return view('frontend.about');
    }

    public function faq()
    {
        return view('frontend.faq');
    }

    public function privacyPolicy()
    {
        return view('frontend.privacy-policy');
    }

    public function termsAndConditions()
    {
        return view('frontend.terms-and-conditions');
    }

    public function refundPolicy()
    {
        return view('frontend.refund-policy');
    }
}
