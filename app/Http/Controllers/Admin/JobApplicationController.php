<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\JobPost;
use App\Models\Industry;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = JobApplication::with([
            'jobPost.industry', 
            'jobPost.user.companyProfile', 
            'user.basicDetails', 
            'user.candidateQualifications.qualification'
        ]);

        // Filter by job
        if ($request->filled('job_id')) {
            $query->where('job_post_id', $request->job_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by industry
        if ($request->filled('industry_id')) {
            $query->whereHas('jobPost', function($q) use ($request) {
                $q->where('industry_id', $request->industry_id);
            });
        }

        // Filter by candidate name
        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $applications = $query->orderBy('applied_at', 'desc')->paginate(20);

        // Get all jobs for filter
        $jobs = JobPost::with('industry')->orderBy('created_at', 'desc')->get();

        // Get all industries for filter
        $industries = Industry::orderBy('industry_name')->get();

        // Count statistics
        $stats = [
            'total' => JobApplication::count(),
            'pending' => JobApplication::where('status', 'pending')->count(),
            'shortlisted' => JobApplication::where('status', 'shortlisted')->count(),
            'hired' => JobApplication::where('status', 'hired')->count(),
            'rejected' => JobApplication::where('status', 'rejected')->count(),
        ];

        return view('admin.applications.index', compact('applications', 'jobs', 'industries', 'stats'));
    }

    public function show($id)
    {
        $application = JobApplication::with([
            'jobPost.industry',
            'jobPost.user.companyProfile',
            'jobPost.qualification',
            'user.basicDetails',
            'user.candidateQualifications.qualification',
            'user.candidateExperiences.industry',
            'user.candidateSkills.skill'
        ])->findOrFail($id);

        return response()->json([
            'application' => $application,
        ]);
    }

    public function destroy($id)
    {
        $application = JobApplication::findOrFail($id);
        $application->delete();

        return redirect()->back()->with('success', 'Application deleted successfully!');
    }
}