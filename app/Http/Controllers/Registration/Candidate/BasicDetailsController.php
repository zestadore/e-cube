<?php

namespace App\Http\Controllers\Registration\Candidate;
use App\Http\Controllers\Controller;
use App\Models\BasicDetails;
use App\Models\Address;
use App\Models\CandidateQualification, CandidateSkill, CandidateExperience;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BasicDetailsController extends Controller
{
    
    public function index()
    {
        return view('choose_type');
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

    public function saveQualifications(Request $request)
    {
        /* ---- validate ---- */
        $request->validate([
            'qualifications'                 => 'required|array|min:1',
            'qualifications.*.qualification' => 'required|exists:qualifications,id',
            'qualifications.*.university'    => 'required|string|max:255',
            'qualifications.*.from_year'     => 'required|digits:4|integer|min:1900|max:'.date('Y'),
            'qualifications.*.to_year'       => 'required|digits:4|integer|min:1900|max:'.date('Y'),
            'qualifications.*.percentage'    => 'required|integer|min:0|max:100',
            'qualifications.*.certificate'   => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        DB::beginTransaction();
        try {
            /* ---- delete old rows for this user ---- */
            CandidateQualification::where('user_id', Auth::user()->id)->delete();

            /* ---- insert new rows ---- */
            foreach ($request->qualifications as $q) {
                $certificatePath = null;
                if (!empty($q['certificate']) && $request->hasFile("qualifications.*.certificate")) {
                    $file = $q['certificate']; // Laravel will cast uploaded file automatically
                    $certificatePath = $file->store('candidate/qualifications', 'public');
                }

                DB::table('candidate_qualifications')->insert([
                    'user_id'           => Auth::user()->id,
                    'qualification_id'  => $q['qualification'],
                    'university'        => $q['university'],
                    'from_year'         => $q['from_year'],
                    'to_year'           => $q['to_year'],
                    'percentage'        => $q['percentage'],
                    'certificate'       => $certificatePath,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Qualifications saved successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to save qualifications', 'error' => $e->getMessage()], 500);
        }
    }

    public function saveSkills(Request $request)
    {
        /* ---- allow empty payload ---- */
        if (!$request->has('skills') || !is_array($request->skills) || count($request->skills) === 0) {
            return response()->json(['message' => 'No skills to save']);
        }

        /* ---- validate ---- */
        $request->validate([
            'skills'                 => 'required|array|min:1',
            'skills.*.skill'         => 'required|exists:computer_and_other_skills,id',
            'skills.*.university'    => 'required|string|max:255',
            'skills.*.from_year'     => 'required|digits:4|integer|min:1900|max:'.date('Y'),
            'skills.*.to_year'       => 'required|digits:4|integer|min:1900|max:'.date('Y'),
            'skills.*.percentage'    => 'required|integer|min:0|max:100',
            'skills.*.certificate'   => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        DB::beginTransaction();
        try {
            /* ---- delete old rows for this user ---- */
            DB::table('candidate_skills')->where('user_id', Auth::user()->id)->delete();

            /* ---- insert new rows ---- */
            foreach ($request->skills as $s) {
                $certificatePath = null;
                if (!empty($s['certificate']) && $request->hasFile("skills.*.certificate")) {
                    $file = $s['certificate'];
                    $certificatePath = $file->store('candidate/skills', 'public');
                }

                DB::table('candidate_skills')->insert([
                    'user_id'   => Auth::user()->id,
                    'skill_id'  => $s['skill'],
                    'university'=> $s['university'],
                    'from_year' => $s['from_year'],
                    'to_year'   => $s['to_year'],
                    'percentage'=> $s['percentage'],
                    'certificate'=> $certificatePath,
                    'created_at'=> now(),
                    'updated_at'=> now(),
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Skills saved successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to save skills', 'error' => $e->getMessage()], 500);
        }
    }

    public function saveExperience(Request $request)
    {
        if (!$request->has('experiences') || !is_array($request->experiences)) {
            Auth::user()->update(['role' => 'employee']);
            return response()->json(['message' => 'No experiences to save']);
        }

        $request->validate([
            'experiences'                 => 'required|array|min:1',
            'experiences.*.industry'      => 'required|exists:industries,id',
            'experiences.*.roles'         => 'required|array|min:1',
            'experiences.*.roles.*'       => 'exists:industries,id', // or your roles table
            'experiences.*.company'       => 'required|string|max:255',
            'experiences.*.from_year'     => 'required|digits:4|integer|min:1900|max:'.date('Y'),
            'experiences.*.to_year'       => 'required|digits:4|integer|min:1900|max:'.date('Y'),
            'experiences.*.duration'      => 'nullable|string|max:50',
            'experiences.*.certificate'   => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        DB::beginTransaction();
        try {
            DB::table('candidate_experiences')->where('user_id', Auth::user()->id)->delete();

            foreach ($request->experiences as $e) {
                $path = null;
                if (!empty($e['certificate']) && $request->hasFile("experiences.*.certificate")) {
                    $path = $e['certificate']->store('candidate/experiences', 'public');
                }

                DB::table('candidate_experiences')->insert([
                    'user_id'     => Auth::user()->id,
                    'industry_id' => $e['industry'],
                    'role_ids'    => json_encode($e['roles']),
                    'company'     => $e['company'],
                    'from_year'   => $e['from_year'],
                    'to_year'     => $e['to_year'],
                    'duration'    => $e['duration'] ?? null,
                    'certificate' => $path,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
            Auth::user()->update(['role' => 'employee']);
            DB::commit();
            return response()->json(['message' => 'Experience saved successfully']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to save experience', 'error' => $ex->getMessage()], 500);
        }
    }

}
