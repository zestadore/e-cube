<?php

namespace App\Http\Controllers\Registration\Candidate;
use App\Http\Controllers\Controller;
use App\Models\BasicDetails;
use App\Models\Address;
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
        $basicDetails = BasicDetails::where('user_id', Auth::id())->first();
        if($basicDetails){
            $basicDetails->update($request->except(['_token']));
            return response()->json(['status' => true, 'data' => $basicDetails]);
        }
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

    public function saveAddress(Request $request)
    {
        $request->validate([
            'permanent_address_1' => 'required',
            'permanent_city' => 'required',
            'permanent_state' => 'required',
            'permanent_zip' => 'required',
            'permanent_country' => 'required',
            'permanent_police_station' => 'required',
            'permanent_panchayat_municipality' => 'required',
            'present_address_1' => 'required',
            'present_city' => 'required',
            'present_state' => 'required',
            'present_zip' => 'required',
            'present_country' => 'required',
            'present_police_station' => 'required',
            'present_panchayat_municipality' => 'required',
        ]);
        $presentAddressData =[
            'address_1' => $request->present_address_1,
            'address_2' => $request->present_address_2,
            'landmark' => $request->present_landmark,
            'city' => $request->present_city,
            'state' => $request->present_state,
            'zip' => $request->present_zip,
            'country' => $request->present_country,
            'police_station' => $request->present_police_station,
            'panchayat_municipality' => $request->present_panchayat_municipality,
            'user_id' => Auth::id(),
            'type' => 'present_address',
        ];
        $permanentAddressData=[
            'address_1' => $request->permanent_address_1,
            'address_2' => $request->permanent_address_2,
            'landmark' => $request->permanent_landmark,
            'city' => $request->permanent_city,
            'state' => $request->permanent_state,
            'zip' => $request->permanent_zip,
            'country' => $request->permanent_country,
            'police_station' => $request->permanent_police_station,
            'panchayat_municipality' => $request->permanent_panchayat_municipality,
            'user_id' => Auth::id(),
            'type' => 'permenant_address',
        ];
        $address = Address::where('user_id', Auth::id())->first();
        if($address){
            $presentAddress = Address::where('user_id', Auth::id())->where('type', 'present_address')->first();
            $presentAddress->update($presentAddressData);
            $permanentAddress = Address::where('user_id', Auth::id())->where('type', 'permenant_address')->first();
            $permanentAddress->update($permanentAddressData);
            return response()->json(['status' => true, 'present_address' => $presentAddress, 'permanent_address' => $permanentAddress]);
        }else{
            $presentAddress = Address::create($presentAddressData);
            $permanentAddress = Address::create($permanentAddressData);
            return response()->json(['status' => true, 'present_address' => $presentAddress, 'permanent_address' => $permanentAddress]);
        }
    }

}
