<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Models\Qualification;
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
        return view('users.jobs.index', compact('jobPosts'));
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
            'job_title' => 'required|string|max:255',
            'description' => 'required|string',
            'qualification_id' => 'required|exists:qualifications,id',
            'application_start_date' => 'required|date',
            'application_end_date' => 'required|date|after_or_equal:application_start_date',
            'expiry_date' => 'required|date|after_or_equal:application_start_date',
        ]);

        JobPost::create([
            'user_id' => Auth::id(),
            'job_title' => $request->job_title,
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
        
        return response()->json($job->load('qualification'));
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
            'job_title' => 'required|string|max:255',
            'description' => 'required|string',
            'qualification_id' => 'required|exists:qualifications,id',
            'application_start_date' => 'required|date',
            'application_end_date' => 'required|date|after_or_equal:application_start_date',
            'expiry_date' => 'required|date|after_or_equal:application_start_date',
            'status' => 'required|in:active,inactive,expired',
        ]);

        $job->update([
            'job_title' => $request->job_title,
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
}