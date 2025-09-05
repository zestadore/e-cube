<?php

namespace App\Http\Controllers\Registration\Candidate;
use App\Http\Controllers\Controller;
use App\Models\BasicDetails;
use Illuminate\Http\Request;

class BasicDetailsController extends Controller
{
    
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        dd($request);
    }

    public function show(BasicDetails $basicDetails)
    {
        //
    }

    public function edit(BasicDetails $basicDetails)
    {
        //
    }

    public function update(Request $request, BasicDetails $basicDetails)
    {
        //
    }

    public function destroy(BasicDetails $basicDetails)
    {
        //
    }
}
