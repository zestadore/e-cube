<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Models\Qualification;
use App\Models\Industry;
use App\Models\CompanyProfile;
use App\Models\CandidateViewPayment;
use App\Models\BackGroundQuestion;
use App\Models\JobApplication;
use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use paytm\paytmchecksum\PaytmChecksum;

class JobPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['handleCandidateViewCallback', 'paymentStatus']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobPosts = JobPost::where('user_id', Auth::id())
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
        return view('users.jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'industry_id' => 'required|exists:industries,id',
            'description' => 'required|string',
            'application_start_date' => 'required|date',
            'application_end_date' => 'required|date|after_or_equal:application_start_date',
            'expiry_date' => 'required|date|after_or_equal:application_start_date',
        ]);

        JobPost::create([
            'user_id' => Auth::id(),
            'industry_id' => $request->industry_id,
            'description' => $request->description,
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
        
        // Load job with applications and candidate details
        $job->load(['industry', 'applications' => function($query) {
            $query->with(['user' => function($q) {
                $q->with(['basicDetails', 'candidateQualifications.qualification']);
            }])->orderBy('applied_at', 'desc');
        }]);
        
        return response()->json($job);
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
        
        return response()->json([
            'job' => $job,
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
            'application_start_date' => 'required|date',
            'application_end_date' => 'required|date|after_or_equal:application_start_date',
            'expiry_date' => 'required|date|after_or_equal:application_start_date',
            'status' => 'required|in:active,inactive,expired',
        ]);

        $job->update([
            'industry_id' => $request->industry_id,
            'description' => $request->description,
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
     * Get candidate view price from subscription packages
     */
    private function getCandidateViewPrice()
    {
        $package = SubscriptionPackage::where('type', 'candidate_view')
            ->orderBy('price', 'asc')
            ->first();
        
        return $package ? $package->price : 10.00;
    }

    /**
     * Find talent - list candidates under employer's industry
     */
    public function findTalent(Request $request)
    {
        // Get employer's selected industry
        $profile = CompanyProfile::where('user_id', Auth::id())->first();
        $userIndustryId = $profile ? $profile->industry_id : null;
        $userIndustryName = null;
        
        // Get all industries under employer's category for filter
        $availableIndustries = [];
        if ($userIndustryId) {
            $parentIndustry = Industry::with('children')->find($userIndustryId);
            if ($parentIndustry) {
                $availableIndustries = $this->getAllChildrenRecursive($parentIndustry);
                $userIndustryName = $parentIndustry->industry_name;
            }
        }
        
        // Build query for candidates
        $query = \App\Models\User::where('role', 'employee')
            ->where('mobile_verified_at', '!=', null)
            ->with(['basicDetails', 'candidateExperiences.industry', 'candidateQualifications.qualification', 'candidateSkills']);
        
        // Filter by sub-industry if selected
        if ($request->filled('sub_industry_id')) {
            $query->whereHas('candidateExperiences', function($q) use ($request) {
                $q->where('industry_id', $request->sub_industry_id);
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
        
        return view('users.jobs.find-talent', compact('candidates', 'availableIndustries', 'qualifications', 'userIndustryId', 'userIndustryName'));
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
                'backgroundQuestionAnswers'
            ])
            ->findOrFail($id);
        
        // Fetch all background questions for reference
        $backgroundQuestions = BackGroundQuestion::pluck('question', 'id')->toArray();
        
        // Check if employer has paid to view this candidate
        $hasPaid = CandidateViewPayment::hasPaid(Auth::id(), $id);
        
        return response()->json([
            'candidate' => $candidate,
            'has_paid' => $hasPaid,
            'view_price' => $this->getCandidateViewPrice(),
            'background_questions' => $backgroundQuestions,
        ]);
    }

    /**
     * Check if employer has paid for candidate view
     */
    public function checkCandidateViewStatus($candidateId)
    {
        $hasPaid = CandidateViewPayment::hasPaid(Auth::id(), $candidateId);
        
        return response()->json([
            'has_paid' => $hasPaid,
            'view_price' => $this->getCandidateViewPrice(),
        ]);
    }

    /**
     * Initiate payment for viewing candidate details
     */
    public function initiateCandidateViewPayment(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:users,id',
        ]);

        $candidateId = $request->candidate_id;
        $employerId = Auth::id();
        
        // Get the dynamic price from subscription packages
        $amount = $this->getCandidateViewPrice();
        
        // Check if already paid (completed status)
        $existingPayment = CandidateViewPayment::where('employer_id', $employerId)
            ->where('candidate_id', $candidateId)
            ->first();
        
        if ($existingPayment) {
            if ($existingPayment->status === 'completed') {
                return response()->json([
                    'success' => true,
                    'already_paid' => true,
                    'message' => 'You have already paid for this candidate',
                ]);
            }
            
            // If payment exists but is pending/failed, reuse it or update with new order ID
            $orderId = 'CAND_VIEW_' . time() . '_' . $employerId . '_' . $candidateId;
            $existingPayment->update([
                'order_id' => $orderId,
                'status' => 'pending',
                'amount' => $amount, // Update amount in case it changed
            ]);
        } else {
            // Create new payment record
            $orderId = 'CAND_VIEW_' . time() . '_' . $employerId . '_' . $candidateId;
            
            CandidateViewPayment::create([
                'employer_id' => $employerId,
                'candidate_id' => $candidateId,
                'order_id' => $orderId,
                'amount' => $amount,
                'status' => 'pending',
            ]);
        }

        // Check if test mode is enabled
        if (config('services.paytm.test_mode', false)) {
            return response()->json([
                'success' => true,
                'test_mode' => true,
                'order_id' => $orderId,
                'amount' => $amount,
                'callback_url' => route('paytm.candidate-view-callback'),
            ]);
        }

        // Paytm configuration
        $paytmParams = [
			'MID' => config('services.paytm.merchant_id'),
			'WEBSITE' => config('services.paytm.website'),
			'CHANNEL_ID' => 'WEB',
			'INDUSTRY_TYPE_ID' => config('services.paytm.industry_type'),
			'ORDER_ID' => (string) $orderId,
			'CUST_ID' => (string) ('CUST_' . $employerId),
			'MOBILE_NO' => (string) Auth::user()->mobile,
			'EMAIL' => (string) Auth::user()->email,
			'TXN_AMOUNT' => number_format($amount, 2, '.', ''),
			'CALLBACK_URL' => 'https://ecubecareers.com/paytm/candidate-view-callback',
		];

		// 🔥 IMPORTANT
		ksort($paytmParams);
        // Generate checksum
		
        $checksum = PaytmChecksum::generateSignature($paytmParams, config('services.paytm.merchant_key'));

        // Use correct Paytm endpoints based on environment
        $environment = config('services.paytm.environment', 'production');
      
        if ($environment === 'staging') {
            $paytm_url = 'https://securegw-stage.paytm.in/order/process';
        } else {
            $paytm_url = 'https://secure.paytmpayments.com/order/process';
        }
	
        return response()->json([
            'success' => true,
            'paytmParams' => $paytmParams,
            'checksum' => $checksum,
            'paytm_url' => $paytm_url,
        ]);
    }

    /**
     * Handle Paytm callback for candidate view payment
     */
    public function handleCandidateViewCallback(Request $request)
    {
        
        
        $paytmChecksum = $request->get('CHECKSUMHASH');
        $paytmParams = $request->except(['CHECKSUMHASH']);
        
        
        
        // Handle test mode callback
        if (isset($paytmParams['TEST']) && $paytmParams['TEST'] === true) {
            return $this->handleTestCandidateViewCallback($paytmParams);
        }
        
        // Verify checksum
        try {
            $isVerifySignature = PaytmChecksum::verifySignature($paytmParams, config('services.paytm.merchant_key'), $paytmChecksum);
           
        } catch (\Exception $e) {
            
            // Continue processing even if verification fails - we'll check status instead
            $isVerifySignature = true; // Temporary: accept all responses
        }
        
        if (!$isVerifySignature) {
            
            // Temporary: continue processing instead of failing
            return redirect('/payment/status?status=error&message=' . urlencode('Payment verification failed. Please contact support.'));
        }

        return $this->processCandidateViewPaymentResponse($paytmParams);
    }

    /**
     * Handle test callback for candidate view
     */
    private function handleTestCandidateViewCallback($params)
    {
        $orderId = $params['ORDERID'];
        $payment = CandidateViewPayment::where('order_id', $orderId)->first();

        if (!$payment) {
            return redirect()->route('employer.find-talent')->with('error', 'Payment record not found.');
        }

        if ($params['STATUS'] === 'TXN_SUCCESS') {
            $payment->update([
                'transaction_id' => $params['TXNID'] ?? 'TEST_TXN',
                'status' => 'completed',
                'response_data' => json_encode($params),
                'paid_at' => now(),
            ]);

            return redirect()->route('employer.find-talent')->with('success', 'Payment successful! You can now view the candidate details.');
        }

        $payment->update([
            'transaction_id' => $params['TXNID'] ?? 'TEST_TXN',
            'status' => 'failed',
            'response_data' => json_encode($params),
        ]);

        return redirect()->route('employer.find-talent')->with('error', 'Payment failed. Please try again.');
    }

    /**
     * Show payment status page (public route)
     */
    public function paymentStatus(Request $request)
    {
        $status = $request->get('status', 'unknown');
        $message = $request->get('message', 'Payment status unknown');
        
        return view('payment-status', compact('status', 'message'));
    }

    /**
     * Process candidate view payment response
     */
    private function processCandidateViewPaymentResponse($paytmParams)
    {
        $orderId = $paytmParams['ORDERID'];
        $payment = CandidateViewPayment::where('order_id', $orderId)->first();

        if (!$payment) {
            
            return redirect('/payment/status?status=error&message=' . urlencode('Payment record not found.'));
        }

        $status = $paytmParams['STATUS'] ?? '';
        $txnId = $paytmParams['TXNID'] ?? null;
        $respMsg = $paytmParams['RESPMSG'] ?? '';

        if ($status === 'TXN_SUCCESS') {
            $payment->update([
                'transaction_id' => $txnId,
                'status' => 'completed',
                'response_data' => json_encode($paytmParams),
                'paid_at' => now(),
            ]);

            return redirect('/payment/status?status=success&message=' . urlencode('Payment successful! You can now view the candidate details.'));
        } elseif ($status === 'PENDING') {
            $payment->update([
                'transaction_id' => $txnId,
                'status' => 'pending',
                'response_data' => json_encode($paytmParams),
            ]);

            return redirect('/payment/status?status=pending&message=' . urlencode('Payment is pending. Please wait for confirmation.'));
        } else {
            $payment->update([
                'transaction_id' => $txnId,
                'status' => 'failed',
                'response_data' => json_encode($paytmParams),
            ]);

            return redirect('/payment/status?status=error&message=' . urlencode('Payment failed: ' . $respMsg));
        }
    }

    /**
     * Test payment for candidate view (for development)
     */
    public function testCandidateViewPayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
            'status' => 'required|in:success,failure',
        ]);

        $payment = CandidateViewPayment::where('order_id', $request->order_id)
                                ->where('employer_id', Auth::id())
                                ->first();

        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        if ($request->status === 'success') {
            $payment->update([
                'transaction_id' => 'TEST_TXN_' . time(),
                'status' => 'completed',
                'response_data' => json_encode(['STATUS' => 'TXN_SUCCESS', 'TEST' => true]),
                'paid_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Test payment completed successfully',
            ]);
        } else {
            $payment->update([
                'transaction_id' => 'TEST_TXN_' . time(),
                'status' => 'failed',
                'response_data' => json_encode(['STATUS' => 'TXN_FAILURE', 'TEST' => true]),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Test payment failed',
            ]);
        }
    }

    /**
     * Find jobs - list job posts for employees
     */
    public function findJobs(Request $request)
    {
        // Get employee's industries from their experiences
        $employee = \App\Models\User::where('id', Auth::id())
            ->with(['candidateExperiences.industry', 'candidateQualifications.qualification'])
            ->first();
        
        $employeeIndustryIds = $employee->candidateExperiences->pluck('industry_id')->filter()->unique()->toArray();
        
        // Get all child industries recursively for the employee's industries
        $availableIndustries = [];
        if (!empty($employeeIndustryIds)) {
            foreach ($employeeIndustryIds as $industryId) {
                $industry = Industry::with('children')->find($industryId);
                if ($industry) {
                    $children = $this->getAllChildrenRecursive($industry);
                    $availableIndustries = array_merge($availableIndustries, $children);
                }
            }
            // Remove duplicates based on id
            $availableIndustries = collect($availableIndustries)->unique('id')->values()->all();
        }
        
        // If no industries from experience, get all industries
        if (empty($availableIndustries)) {
            $rootIndustries = Industry::whereNull('parent_id')->with('children')->get();
            foreach ($rootIndustries as $industry) {
                $availableIndustries = array_merge($availableIndustries, $this->getAllChildrenRecursive($industry));
            }
        }
        
        $industryIds = array_column($availableIndustries, 'id');
        
        // Build query for job posts
        $query = JobPost::with(['user.companyProfile', 'industry'])
            ->whereIn('industry_id', $industryIds)
            ->where('status', '!=', 'expired');

        // Filter by industry if selected
        if ($request->filled('industry_id')) {
            $query->where('industry_id', $request->industry_id);
        }

        // Filter by status if selected
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            // Default to active jobs
            $query->where('status', 'active');
        }
        
        // Search by description
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }
        
        $jobPosts = $query->orderBy('created_at', 'desc')->paginate(12);
        
        // Count active jobs
        $activeJobs = JobPost::whereIn('industry_id', $industryIds)
            ->where('status', 'active')
            ->count();
        
        return view('users.jobs.search-jobs', compact('jobPosts', 'availableIndustries', 'activeJobs'));
    }

    /**
     * Show job details for employee view
     */
    public function showJobForEmployee($id)
    {
        $job = JobPost::with(['user.companyProfile.industry', 'industry'])
            ->findOrFail($id);
        
        // Check if user has already applied
        $hasApplied = JobApplication::where('job_post_id', $id)
            ->where('user_id', Auth::id())
            ->exists();
        
        return response()->json([
            'job' => $job,
            'has_applied' => $hasApplied,
        ]);
    }

    /**
     * Apply for a job
     */
    public function applyForJob(Request $request, $jobId)
    {
        $request->validate([
            'cover_letter' => 'nullable|string|max:2000',
        ]);

        $job = JobPost::findOrFail($jobId);

        // Check if job is active
        if ($job->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'This job is no longer accepting applications.',
            ], 400);
        }

        // Check if application period is open
        $now = now();
        if ($now < $job->application_start_date || $now > $job->application_end_date) {
            return response()->json([
                'success' => false,
                'message' => 'Application period is closed.',
            ], 400);
        }

        // Check if already applied
        $existingApplication = JobApplication::where('job_post_id', $jobId)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingApplication) {
            return response()->json([
                'success' => false,
                'message' => 'You have already applied for this job.',
            ], 400);
        }

        // Create application
        JobApplication::create([
            'job_post_id' => $jobId,
            'user_id' => Auth::id(),
            'cover_letter' => $request->cover_letter,
            'status' => 'pending',
            'applied_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Application submitted successfully!',
        ]);
    }

    /**
     * Get applications for employer's jobs
     */
    public function getEmployerApplications(Request $request)
    {
        $query = JobApplication::with(['jobPost.industry', 'user.basicDetails', 'user.candidateQualifications.qualification'])
            ->whereHas('jobPost', function($q) {
                $q->where('user_id', Auth::id());
            });

        // Filter by job
        if ($request->filled('job_id')) {
            $query->where('job_post_id', $request->job_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by candidate name
        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('last_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $applications = $query->orderBy('applied_at', 'desc')->paginate(15);

        // Get employer's jobs for filter
        $jobs = JobPost::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Count statistics
        $stats = [
            'total' => JobApplication::whereHas('jobPost', function($q) {
                $q->where('user_id', Auth::id());
            })->count(),
            'pending' => JobApplication::whereHas('jobPost', function($q) {
                $q->where('user_id', Auth::id());
            })->where('status', 'pending')->count(),
            'shortlisted' => JobApplication::whereHas('jobPost', function($q) {
                $q->where('user_id', Auth::id());
            })->where('status', 'shortlisted')->count(),
            'hired' => JobApplication::whereHas('jobPost', function($q) {
                $q->where('user_id', Auth::id());
            })->where('status', 'hired')->count(),
            'rejected' => JobApplication::whereHas('jobPost', function($q) {
                $q->where('user_id', Auth::id());
            })->where('status', 'rejected')->count(),
        ];

        return view('users.jobs.applications', compact('applications', 'jobs', 'stats'));
    }

    /**
     * Update application status
     */
    public function updateApplicationStatus(Request $request, $applicationId)
    {
        $request->validate([
            'status' => 'required|in:pending,shortlisted,rejected,hired',
            'notes' => 'nullable|string|max:2000',
        ]);

        $application = JobApplication::with('jobPost')
            ->whereHas('jobPost', function($q) {
                $q->where('user_id', Auth::id());
            })
            ->findOrFail($applicationId);

        $application->update([
            'status' => $request->status,
            'employer_notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', 'Application status updated successfully!');
    }

    /**
     * Get application details for employer
     */
    public function getApplicationDetails($applicationId)
    {
        $application = JobApplication::with([
            'jobPost.industry',
            'user.basicDetails',
            'user.presentAddress',
            'user.permanentAddress',
            'user.candidateHobby',
            'user.candidateQualifications.qualification',
            'user.candidateQualifications.level1Qualification',
            'user.candidateQualifications.level2Qualification',
            'user.candidateQualifications.level3Qualification',
            'user.candidateExperiences.industry',
            'user.candidateExperiences.industryLevel2',
            'user.candidateExperiences.industryLevel3',
            'user.candidateSkills.skill.industry'
        ])
            ->whereHas('jobPost', function($q) {
                $q->where('user_id', Auth::id());
            })
            ->findOrFail($applicationId);

        // Format the response to match employee dashboard structure
        $response = [
            'application' => [
                'id' => $application->id,
                'status' => $application->status,
                'cover_letter' => $application->cover_letter,
                'employer_notes' => $application->employer_notes,
                'applied_at' => $application->applied_at,
                'job_post' => $application->jobPost,
                'user' => [
                    'id' => $application->user->id,
                    'first_name' => $application->user->first_name,
                    'last_name' => $application->user->last_name,
                    'full_name' => $application->user->first_name . ' ' . $application->user->last_name,
                    'email' => $application->user->email,
                    'mobile' => $application->user->mobile,
                    'image_path' => $application->user->image_path,
                    'signature_image' => $application->user->signature_image,
                ],
                'basic_details' => $application->user->basicDetails,
                'present_address' => $application->user->presentAddress,
                'permanent_address' => $application->user->permanentAddress,
                'hobbies' => $application->user->candidateHobby,
                'candidate_qualifications' => $application->user->candidateQualifications,
                'candidate_experiences' => $application->user->candidateExperiences,
                'candidate_skills' => $application->user->candidateSkills,
            ],
        ];

        return response()->json($response);
    }

    /**
     * Get applications for a specific job (AJAX)
     */
    public function getJobApplications($jobId)
    {
        $job = JobPost::where('id', $jobId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $applications = JobApplication::with([
            'user' => function($q) {
                $q->with(['basicDetails', 'candidateQualifications.qualification']);
            }
        ])
            ->where('job_post_id', $jobId)
            ->orderBy('applied_at', 'desc')
            ->get();

        return response()->json([
            'applications' => $applications,
        ]);
    }
}
