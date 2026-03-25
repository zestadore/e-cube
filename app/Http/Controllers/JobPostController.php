<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Models\Qualification;
use App\Models\Industry;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobPosts = JobPost::where('user_id', Auth::id())
                          ->with('qualification')
                          ->orderBy('created_at', 'desc')
                          ->get();
        
        // Get the user's selected parent industry
        $profile = CompanyProfile::where('user_id', Auth::id())->first();
        $userIndustryId = $profile ? $profile->industry_id : null;
        
        // Get all child industries recursively under the user's parent industry
        $jobIndustries = [];
        if ($userIndustryId) {
            $parentIndustry = Industry::with('children')->find($userIndustryId);
            if ($parentIndustry) {
                $jobIndustries = $this->getAllChildrenRecursive($parentIndustry);
            }
        }
        
        return view('users.jobs.index', compact('jobPosts', 'jobIndustries'));
    }

    /**
     * Get all children industries recursively
     */
    private function getAllChildrenRecursive($industry, $level = 0)
    {
        $result = [];
        
        // Add current industry
        $result[] = [
            'id' => $industry->id,
            'name' => str_repeat('— ', $level) . $industry->industry_name,
            'level' => $level
        ];
        
        // Get children recursively
        if ($industry->children && $industry->children->count() > 0) {
            foreach ($industry->children as $child) {
                $result = array_merge($result, $this->getAllChildrenRecursive($child, $level + 1));
            }
        }
        
        return $result;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $qualifications = Qualification::all();
        return view('users.jobs.create', compact('qualifications'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'industry_id' => 'required|exists:industries,id',
            'description' => 'required|string',
            'qualification_id' => 'required|exists:qualifications,id',
            'application_start_date' => 'required|date',
            'application_end_date' => 'required|date|after_or_equal:application_start_date',
            'expiry_date' => 'required|date|after_or_equal:application_start_date',
        ]);

        JobPost::create([
            'user_id' => Auth::id(),
            'industry_id' => $request->industry_id,
            'description' => $request->description,
            'qualification_id' => $request->qualification_id,
            'application_start_date' => $request->application_start_date,
            'application_end_date' => $request->application_end_date,
            'expiry_date' => $request->expiry_date,
            'status' => 'active',
        ]);

        return redirect()->route('employer.jobs.index')->with('success', 'Job posted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobPost $job)
    {
        // Check if the job belongs to the authenticated user
        if ($job->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return response()->json($job->load(['qualification', 'industry']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobPost $job)
    {
        // Check if the job belongs to the authenticated user
        if ($job->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $qualifications = Qualification::all();
        return response()->json([
            'job' => $job,
            'qualifications' => $qualifications
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobPost $job)
    {
        // Check if the job belongs to the authenticated user
        if ($job->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'industry_id' => 'required|exists:industries,id',
            'description' => 'required|string',
            'qualification_id' => 'required|exists:qualifications,id',
            'application_start_date' => 'required|date',
            'application_end_date' => 'required|date|after_or_equal:application_start_date',
            'expiry_date' => 'required|date|after_or_equal:application_start_date',
            'status' => 'required|in:active,inactive,expired',
        ]);

        $job->update([
            'industry_id' => $request->industry_id,
            'description' => $request->description,
            'qualification_id' => $request->qualification_id,
            'application_start_date' => $request->application_start_date,
            'application_end_date' => $request->application_end_date,
            'expiry_date' => $request->expiry_date,
            'status' => $request->status,
        ]);

        return redirect()->route('employer.jobs.index')->with('success', 'Job updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobPost $job)
    {
        // Check if the job belongs to the authenticated user
        if ($job->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $job->delete();

        return redirect()->route('employer.jobs.index')->with('success', 'Job deleted successfully!');
    }

    /**
     * Find talent - list candidates under employer's industry
     */
    public function findTalent(Request $request)
    {
        // Get employer's selected industry
        $profile = CompanyProfile::where('user_id', Auth::id())->first();
        $userIndustryId = $profile ? $profile->industry_id : null;
        
        // Get all industries under employer's category for filter
        $availableIndustries = [];
        if ($userIndustryId) {
            $parentIndustry = Industry::with('children')->find($userIndustryId);
            if ($parentIndustry) {
                $availableIndustries = $this->getAllChildrenRecursive($parentIndustry);
            }
        }
        // Build query for candidates
        $query = \App\Models\User::where('role', 'employee')
            ->where('mobile_verified_at', '!=', null)
            ->with(['basicDetails', 'candidateExperiences.industry', 'candidateQualifications.qualification', 'candidateSkills']);
        
        // Filter by industry if selected
        if ($request->filled('industry_id')) {
            $query->whereHas('candidateExperiences', function($q) use ($request) {
                $q->where('industry_id', $request->industry_id);
            });
        } elseif ($userIndustryId) {
            // Show candidates from employer's industry category
            $industryIds = array_column($availableIndustries, 'id');
            $query->whereHas('candidateExperiences', function($q) use ($industryIds) {
                $q->whereIn('industry_id', $industryIds);
            });
        }
        
        // Filter by qualification if selected
        if ($request->filled('qualification_id')) {
            $query->whereHas('candidateQualifications', function($q) use ($request) {
                $q->where('qualification_id', $request->qualification_id);
            });
        }
        
        // Filter by experience years
        if ($request->filled('experience_years')) {
            $query->whereHas('candidateExperiences', function($q) use ($request) {
                $q->where('years_of_experience', '>=', $request->experience_years);
            });
        }
        
        // Search by name
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        $candidates = $query->orderBy('created_at', 'desc')->paginate(12);
        
        // Get qualifications for filter
        $qualifications = Qualification::all();
        
        return view('users.jobs.find-talent', compact('candidates', 'availableIndustries', 'qualifications', 'userIndustryId'));
    }

    /**
     * Show candidate details
     */
    public function showCandidate($id)
    {
        $candidate = \App\Models\User::where('role', 'employee')
            ->where('mobile_verified_at', '!=', null)
            ->with([
                'basicDetails',
                'addresses',
                'candidateQualifications.qualification',
                'candidateSkills.skill',
                'candidateExperiences.industry',
                'backgroundQuestionAnswers.question'
            ])
            ->findOrFail($id);
        
        return response()->json($candidate);
    }
}