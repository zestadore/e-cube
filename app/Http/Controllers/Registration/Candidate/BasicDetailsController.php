<?php

namespace App\Http\Controllers\Registration\Candidate;
use App\Http\Controllers\Controller;
use App\Models\BasicDetails;
use Auth;
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
        $request->validate([
            'dob' => 'required|date',
            'gender' => 'required|string',
            'aadhar_number' => 'required',
            'experience' => 'required',
            'Job_type' => 'required',
            'differently_abled' => 'required',
        ]);
        $basicDetails = BasicDetails::create($request->except(['_token'])+['user_id' => Auth::id()]);
        return response()->json(['status' => true, 'data' => $basicDetails]);
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
