<?php

namespace App\Http\Controllers\Registration\Candidate;
use App\Http\Controllers\Controller;
use App\Models\BasicDetails;
use App\Models\Address;
use App\Models\CandidateQualification;
use App\Models\CandidateSkill;
use App\Models\CandidateExperience;
use App\Models\CandidateHobby;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
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
            'experiences.*.roles.*'       => 'exists:industries,id',
            'experiences.*.company'       => 'required|string|max:255',
            'experiences.*.from_year'     => 'required|digits:4|integer|min:1900|max:'.date('Y'),
            'experiences.*.to_year'       => 'required',
            'experiences.*.duration'      => 'nullable|string|max:50',
            'experiences.*.certificate'   => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
            'experiences.*.responsibilities' => 'nullable|string',
            'experiences.*.achievements'  => 'nullable|string',
            'experiences.*.present_salary'=> 'nullable|numeric',
            'experiences.*.expected_salary'=> 'nullable|numeric',
            'experiences.*.is_current'    => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            DB::table('candidate_experiences')->where('user_id', Auth::user()->id)->delete();

            foreach ($request->experiences as $index => $e) {
                $path = null;
                if ($request->hasFile("experiences.{$index}.certificate")) {
                    $path = $request->file("experiences.{$index}.certificate")->store('candidate/experiences', 'public');
                }

                DB::table('candidate_experiences')->insert([
                    'user_id'           => Auth::user()->id,
                    'industry_id'       => $e['industry_id'] ?? $e['industry'],
                    'role_ids'          => json_encode($e['role_ids'] ?? $e['roles'] ?? []),
                    'company'           => $e['company'],
                    'from_year'         => $e['from_year'],
                    'to_year'           => $e['to_year'] === 'current' ? null : $e['to_year'],
                    'duration'          => $e['duration'] ?? null,
                    'responsibilities'  => $e['responsibilities'] ?? null,
                    'achievements'      => $e['achievements'] ?? null,
                    'present_salary'    => $e['present_salary'] ?? null,
                    'expected_salary'   => $e['expected_salary'] ?? null,
                    'is_current'        => isset($e['is_current']) ? true : false,
                    'certificate'       => $path,
                    'created_at'        => now(),
                    'updated_at'        => now(),
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

    /**
     * Save complete candidate profile
     */
    public function saveCompleteProfile(Request $request)
    {
        $request->validate([
            'signature_data' => 'required',
        ]);

        DB::beginTransaction();
        try {
            // Save Basic Details - use input() to avoid array conflicts
            $basicData = [
                'user_id' => Auth::id(),
                'dob' => $request->input('dob'),
                'gender' => $request->input('gender'),
                'aadhar_number' => $request->input('aadhar_number'),
                'pan_number' => $request->input('pan_number'),
                'passport_number' => $request->input('passport_number'),
                'alternate_mobile_number' => $request->input('alternate_mobile_number'),
                'whatsapp_number' => $request->input('whatsapp_number'),
                'alternate_email_id' => $request->input('alternate_email_id'),
                'profession' => $request->input('profession'),
                'experience' => $request->input('experience_level'), // This gets the basic details experience
                'Job_type' => $request->input('Job_type'),
                'differently_abled' => $request->input('differently_abled'),
            ];
            BasicDetails::updateOrCreate(
                ['user_id' => Auth::id()],
                $basicData
            );

            // Save Address
            $this->saveAddressData($request);

            // Save Education
            if ($request->has('education')) {
                $this->saveEducationData($request);
            }

            // Save Experience
            if ($request->has('experience')) {
                $this->saveExperienceData($request);
            }

            // Save Skills
            if ($request->has('skills')) {
                $this->saveSkillsData($request);
            }

            // Save Hobbies
            if ($request->has('hobbies')) {
                $this->saveHobbiesData($request);
            }

            // Save Signature
            $signatureData = $request->input('signature_data');
            if (strpos($signatureData, 'data:image') === 0) {
                // It's a drawn signature, save as image
                $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $signatureData));
                $filename = 'signatures/' . Auth::id() . '_' . time() . '.png';
                Storage::disk('public')->put($filename, $imageData);
                Auth::user()->update([
                    'signature_image' => Storage::url($filename),
                    'profile_completed_at' => now()
                ]);
            } else {
                // It's a typed signature
                Auth::user()->update([
                    'signature_image' => $signatureData,
                    'profile_completed_at' => now()
                ]);
            }

            // Update role to employee
            Auth::user()->update(['role' => 'employee']);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Profile saved successfully']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $ex->getMessage()], 500);
        }
    }

    /**
     * View candidate profile
     */
    public function viewProfile()
    {
        $user = Auth::user();
        $basics = $user->basics;
        $presentAddress = $user->presentAddress;
        $permanentAddress = $user->permanentAddress;
        $candidateQualifications = $user->qualifications;
        $candidateSkills = $user->skills;
        $candidateExperiences = $user->experiences;
        $hobbies = CandidateHobby::where('user_id', $user->id)->first();

        return view('users.profile.candidate-profile', compact(
            'user', 'basics', 'presentAddress', 'permanentAddress',
            'candidateQualifications', 'candidateSkills', 'candidateExperiences', 'hobbies'
        ));
    }

    /**
     * Get qualification children for AJAX
     */
    public function getQualificationChildren($id)
    {
        $qualification = \App\Models\Qualification::find($id);
        if (!$qualification) {
            return response()->json([]);
        }
        
        $children = $qualification->children()->get(['id', 'degree as name']);
        return response()->json($children);
    }

    /**
     * Get ALL qualification children recursively with hierarchy levels
     */
    public function getAllQualificationChildren($id)
    {
        $qualification = \App\Models\Qualification::find($id);
        if (!$qualification) {
            return response()->json([]);
        }
        
        $result = [];
        $this->getChildrenRecursive($qualification, $result, 0);
        return response()->json($result);
    }

    /**
     * Recursive helper to get all children with levels
     */
    private function getChildrenRecursive($qualification, &$result, $level)
    {
        try {
            $children = $qualification->children()->get();

            foreach ($children as $child) {
                $result[] = [
                    'id' => $child->id,
                    'name' => $child->degree,
                    'level' => $level
                ];

                $this->getChildrenRecursive($child, $result, $level + 1);
            }

        } catch (\Exception $e) {
            \Log::error('Error: ' . $e->getMessage());
        }
    }

    /**
     * Get industry roles for AJAX
     */
    public function getIndustryRoles($id)
    {
        $industry = \App\Models\Industry::find($id);
        if (!$industry) {
            return response()->json([]);
        }
        
        // Return the industry itself as a role option, or you can have a separate roles table
        // $roles = \App\Models\Industry::where('id', $id)->orWhere('parent_id', $id)->get(['id', 'industry_name as name']);
        $roles = $industry->children()->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->industry_name
            ];
        });
        return response()->json($roles);
    }

    // Helper methods
    private function saveAddressData($request)
    {
        $userId = Auth::id();
        
        // Present Address
        Address::updateOrCreate(
            ['user_id' => $userId, 'type' => 'present_address'],
            [
                'address_1' => $request->present_address_1,
                'address_2' => $request->present_address_2,
                'landmark' => $request->present_landmark,
                'city' => $request->present_city,
                'state' => $request->present_state,
                'zip' => $request->present_zip,
                'country' => $request->present_country,
                'police_station' => $request->present_police_station,
                'panchayat_municipality' => $request->present_panchayat_municipality,
            ]
        );

        // Permanent Address
        Address::updateOrCreate(
            ['user_id' => $userId, 'type' => 'permenant_address'],
            [
                'address_1' => $request->permanent_address_1,
                'address_2' => $request->permanent_address_2,
                'landmark' => $request->permanent_landmark,
                'city' => $request->permanent_city,
                'state' => $request->permanent_state,
                'zip' => $request->permanent_zip,
                'country' => $request->permanent_country,
                'police_station' => $request->permanent_police_station,
                'panchayat_municipality' => $request->permanent_panchayat_municipality,
            ]
        );
    }

    private function saveEducationData($request)
    {
        $educationData = $request->input('education', []);
        
        if (empty($educationData)) {
            return;
        }

        // Delete old qualifications
        \App\Models\CandidateQualification::where('user_id', Auth::id())->delete();

        foreach ($educationData as $index => $edu) {
            $certificatePath = null;
            
            // Handle certificate file upload
            if ($request->hasFile("education.{$index}.certificate")) {
                $certificatePath = $request->file("education.{$index}.certificate")->store('candidate/qualifications', 'public');
            }

            \App\Models\CandidateQualification::create([
                'user_id' => Auth::id(),
                'qualification_id' => $edu['qualification_id'] ?? $edu['main_parent'] ?? null,
                'university' => $edu['university'] ?? '',
                'institution' => $edu['institution'] ?? null,
                'college' => $edu['college'] ?? null,
                'from_year' => $edu['from_year'] ?? null,
                'to_year' => $edu['to_year'] ?? null,
                'percentage' => $edu['percentage'] ?? null,
                'certificate' => $certificatePath,
            ]);
        }
    }

    private function saveExperienceData($request)
    {
        $experienceData = $request->input('experience', []);
        
        if (empty($experienceData)) {
            return;
        }

        // Delete old experiences
        \App\Models\CandidateExperience::where('user_id', Auth::id())->delete();

        foreach ($experienceData as $index => $exp) {
            $certificatePath = null;
            
            // Handle certificate file upload
            if ($request->hasFile("experience.{$index}.certificate")) {
                $certificatePath = $request->file("experience.{$index}.certificate")->store('candidate/experiences', 'public');
            }

            // Handle skills array
            $skills = $exp['skills'] ?? [];
            
            \App\Models\CandidateExperience::create([
                'user_id' => Auth::id(),
                'industry_id' => $exp['industry_id'],
                'role_ids' => json_encode($exp['role_ids'] ?? []),
                'company' => $exp['company'],
                'location' => $exp['location'] ?? null,
                'from_year' => $exp['from_year'],
                'to_year' => ($exp['to_year'] ?? null) === 'current' ? null : ($exp['to_year'] ?? null),
                'duration' => $exp['duration'] ?? null,
                'responsibilities' => $exp['responsibilities'] ?? null,
                'achievements' => $exp['achievements'] ?? null,
                'present_salary' => $exp['present_salary'] ?? null,
                'expected_salary' => $exp['expected_salary'] ?? null,
                'is_current' => ($exp['to_year'] ?? null) === 'current',
                'certificate' => $certificatePath,
                'display_order' => $index,
            ]);
        }
    }

    private function saveSkillsData($request)
    {
        $skillsData = $request->input('skills', []);
        
        if (empty($skillsData)) {
            return;
        }

        // Delete old skills
        \App\Models\CandidateSkill::where('user_id', Auth::id())->delete();

        foreach ($skillsData as $index => $skill) {
            $certificatePath = null;
            
            // Handle certificate file upload
            if ($request->hasFile("skills.{$index}.certificate")) {
                $certificatePath = $request->file("skills.{$index}.certificate")->store('candidate/skills', 'public');
            }

            \App\Models\CandidateSkill::create([
                'user_id' => Auth::id(),
                'skill_id' => $skill['skill_id'],
                'proficiency' => $skill['proficiency'] ?? 'Beginner',
                'certificate' => $certificatePath,
            ]);
        }
    }

    private function saveHobbiesData($request)
    {
        $hobbiesData = $request->input('hobbies');
        CandidateHobby::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'description' => $hobbiesData['description'] ?? null,
                'interests' => $hobbiesData['interests'] ?? null,
            ]
        );
    }

    // ==================== UPDATE METHODS FOR EMPLOYEE DASHBOARD ====================

    /**
     * Update basic information
     */
    public function updateBasic(Request $request)
    {
        try {
            $request->validate([
                'dob' => 'required|date',
                'gender' => 'required|string',
                'aadhar_number' => 'required',
                'experience' => 'required',
                'Job_type' => 'required',
                'differently_abled' => 'required',
            ]);

            $basicDetails = BasicDetails::where('user_id', Auth::id())->first();
            
            $data = $request->except(['_token']);
            
            if ($basicDetails) {
                $basicDetails->update($data);
            } else {
                $data['user_id'] = Auth::id();
                BasicDetails::create($data);
            }

            return response()->json(['success' => true, 'message' => 'Basic information updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update address information
     */
    public function updateAddress(Request $request)
    {
        try {
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

            // Update Present Address
            Address::updateOrCreate(
                ['user_id' => Auth::id(), 'type' => 'present_address'],
                [
                    'address_1' => $request->present_address_1,
                    'address_2' => $request->present_address_2,
                    'landmark' => $request->present_landmark,
                    'city' => $request->present_city,
                    'state' => $request->present_state,
                    'zip' => $request->present_zip,
                    'country' => $request->present_country,
                    'police_station' => $request->present_police_station,
                    'panchayat_municipality' => $request->present_panchayat_municipality,
                ]
            );

            // Update Permanent Address
            Address::updateOrCreate(
                ['user_id' => Auth::id(), 'type' => 'permenant_address'],
                [
                    'address_1' => $request->permanent_address_1,
                    'address_2' => $request->permanent_address_2,
                    'landmark' => $request->permanent_landmark,
                    'city' => $request->permanent_city,
                    'state' => $request->permanent_state,
                    'zip' => $request->permanent_zip,
                    'country' => $request->permanent_country,
                    'police_station' => $request->permanent_police_station,
                    'panchayat_municipality' => $request->permanent_panchayat_municipality,
                ]
            );

            return response()->json(['success' => true, 'message' => 'Addresses updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update education information
     */
    public function updateEducation(Request $request)
    {
        try {
            $request->validate([
                'education' => 'required|array|min:1',
                'education.*.qualification_id' => 'required',
                'education.*.university' => 'required|string',
                'education.*.institution' => 'required|string',
                'education.*.from_year' => 'required|integer',
                'education.*.to_year' => 'required|integer',
            ]);

            DB::beginTransaction();

            // Delete existing qualifications
            CandidateQualification::where('user_id', Auth::id())->delete();

            // Insert new qualifications
            foreach ($request->education as $index => $edu) {
                $certificatePath = null;
                
                // Handle certificate file upload
                if ($request->hasFile("education.{$index}.certificate")) {
                    $certificatePath = $request->file("education.{$index}.certificate")->store('candidate/qualifications', 'public');
                }

                CandidateQualification::create([
                    'user_id' => Auth::id(),
                    'qualification_id' => $edu['qualification_id'],
                    'university' => $edu['university'],
                    'institution' => $edu['institution'] ?? null,
                    'college' => $edu['college'] ?? null,
                    'from_year' => $edu['from_year'],
                    'to_year' => $edu['to_year'],
                    'percentage' => $edu['percentage'] ?? null,
                    'certificate' => $certificatePath,
                ]);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Education updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update skills information
     */
    public function updateSkills(Request $request)
    {
        try {
            $request->validate([
                'skills' => 'required|array|min:1',
                'skills.*.skill_id' => 'required',
                'skills.*.proficiency' => 'required',
            ]);

            DB::beginTransaction();

            // Delete existing skills
            CandidateSkill::where('user_id', Auth::id())->delete();

            // Insert new skills
            foreach ($request->skills as $index => $skill) {
                $certificatePath = null;
                
                // Handle certificate file upload
                if ($request->hasFile("skills.{$index}.certificate")) {
                    $certificatePath = $request->file("skills.{$index}.certificate")->store('candidate/skills', 'public');
                }

                CandidateSkill::create([
                    'user_id' => Auth::id(),
                    'skill_id' => $skill['skill_id'],
                    'proficiency' => $skill['proficiency'],
                    'certificate' => $certificatePath,
                ]);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Skills updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update experience information
     */
    public function updateExperience(Request $request)
    {
        try {
            $request->validate([
                'experience' => 'required|array|min:1',
                'experience.*.industry_id' => 'required',
                'experience.*.company' => 'required|string',
                'experience.*.from_year' => 'required|integer',
                'experience.*.to_year' => 'required',
            ]);

            DB::beginTransaction();

            // Delete existing experiences
            CandidateExperience::where('user_id', Auth::id())->delete();

            // Insert new experiences
            foreach ($request->experience as $index => $exp) {
                $certificatePath = null;
                
                // Handle certificate file upload
                if ($request->hasFile("experience.{$index}.certificate")) {
                    $certificatePath = $request->file("experience.{$index}.certificate")->store('candidate/experiences', 'public');
                }

                CandidateExperience::create([
                    'user_id' => Auth::id(),
                    'industry_id' => $exp['industry_id'],
                    'role_ids' => json_encode($exp['role_ids'] ?? []),
                    'company' => $exp['company'],
                    'location' => $exp['location'] ?? null,
                    'from_year' => $exp['from_year'],
                    'to_year' => ($exp['to_year'] ?? null) === 'current' ? null : ($exp['to_year'] ?? null),
                    'duration' => $exp['duration'] ?? null,
                    'responsibilities' => $exp['responsibilities'] ?? null,
                    'achievements' => $exp['achievements'] ?? null,
                    'present_salary' => $exp['present_salary'] ?? null,
                    'expected_salary' => $exp['expected_salary'] ?? null,
                    'is_current' => ($exp['to_year'] ?? null) === 'current',
                    'certificate' => $certificatePath,
                ]);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Experience updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update hobbies information
     */
    public function updateHobbies(Request $request)
    {
        try {
            $hobbiesData = $request->input('hobbies');
            
            CandidateHobby::updateOrCreate(
                ['user_id' => Auth::id()],
                [
                    'description' => $hobbiesData['description'] ?? null,
                    'interests' => $hobbiesData['interests'] ?? null,
                ]
            );

            return response()->json(['success' => true, 'message' => 'Hobbies updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
