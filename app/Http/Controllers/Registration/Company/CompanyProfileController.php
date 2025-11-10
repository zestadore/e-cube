<?php

namespace App\Http\Controllers\Registration\Company;
use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use App\Models\Industry;
use Illuminate\Http\Request;
use App\Http\Requests\ValidateCompanyProfile;
use Auth;

class CompanyProfileController extends Controller
{
    
    public function index()
    {
        $profile=CompanyProfile::where('user_id',Auth::id())->first();
        $industries = Industry::get();
        return view('users.registration.employer',compact('profile','industries'));
    }

    public function create()
    {
        //
    }

    public function store(ValidateCompanyProfile $request)
    {
        $profile=CompanyProfile::where('user_id',Auth::id())->first();
        if($profile){
            $profile->update($request->except(['_token','company_logo']));
        }else{
            $profile=CompanyProfile::create($request->except(['_token','company_logo'])+['user_id' => Auth::id()]);
        }
        if($request->file('company_logo')){
            if($profile->company_logo!=null){
                unlink(public_path('uploads/logos/'. $profile->company_logo));
            }
            $file= $request->file('company_logo');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('uploads/logos'), $filename);
            $profile->update(['company_logo'=>$filename]);
        }
        Auth::user()->update(['role'=>'employer']);
        return redirect()->route('home');
    }

    public function show(CompanyProfile $companyProfile)
    {
        //
    }

    public function edit(CompanyProfile $companyProfile)
    {
        //
    }

    public function update(Request $request, CompanyProfile $companyProfile)
    {
        //
    }

    public function destroy(CompanyProfile $companyProfile)
    {
        //
    }
}
