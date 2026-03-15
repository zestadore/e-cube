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
        $profile=CompanyProfile::with('industry')->where('user_id',Auth::id())->first();
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
        $request->mergeIfMissing(['industry_id' => 0]);
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

    /**
     * Show industry selection page with hierarchical accordion
     */
    public function selectIndustry()
    {
        // Get parent industries (industries that have no parents) with their children
        $parentIndustries = Industry::whereDoesntHave('parents')
            ->where('status', 1)
            ->with('children')
            ->get();
        
        // Get the current profile to show selected industry if any
        $profile = CompanyProfile::where('user_id', Auth::id())->first();
        $selectedIndustryId = $profile ? $profile->industry_id : null;
        
        // Get candidate counts per industry
        $candidateCounts = $this->getCandidateCountsByIndustry();
        
        return view('users.registration.industry-selection', compact('parentIndustries', 'selectedIndustryId', 'candidateCounts'));
    }

    /**
     * Get candidate counts for each industry
     */
    private function getCandidateCountsByIndustry()
    {
        // Count unique candidates (users) per industry from their experiences
        $counts = \App\Models\CandidateExperience::select('industry_id')
            ->selectRaw('COUNT(DISTINCT user_id) as candidate_count')
            ->groupBy('industry_id')
            ->pluck('candidate_count', 'industry_id')
            ->toArray();

        return $counts;
    }

    /**
     * Save selected industry to company profile
     */
    public function saveIndustry(Request $request)
    {
        $request->validate([
            'industry_id' => 'required|exists:industries,id'
        ]);

        $profile = CompanyProfile::where('user_id', Auth::id())->first();
        
        if ($profile) {
            $profile->update(['industry_id' => $request->industry_id]);
        } else {
            // Create a minimal profile with just the industry_id
            CompanyProfile::create([
                'user_id' => Auth::id(),
                'industry_id' => $request->industry_id,
                'company_name' => '',
                'company_address' => '',
                'company_email' => '',
                'company_phone' => '',
                'date_of_establishment' => now(),
                'chairman_name' => '',
                'chairman_contact' => '',
                'hr_name' => '',
                'hr_contact' => '',
                'registration_type' => 'pvt_ltd'
            ]);
        }

        return redirect()->route('employer.company_profile')->with('success', 'Industry selected successfully');
    }
}
