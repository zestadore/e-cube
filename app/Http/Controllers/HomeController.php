<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\Qualification;
use App\Models\ComputerAndOtherSkill;
use App\Models\Industry;
use App\Models\BackGroundQuestion;
use App\Models\BackgroundQuestionAnswer;
use App\Models\PaymentMethod;
use App\Models\SubscriptionPackage;
use App\Models\User;
use App\Models\JobPost;
use App\Models\JobApplication;
use App\Models\PaymentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        switch (Auth::user()->role) {
            case 'admin':
                return redirect('/admin');
                break;
            case 'super_admin':
                return redirect()->route('admin.dashboard');
                break;
            case 'employee':
                return redirect()->route('employee.dashboard');
                break;
            case 'employer':
                return redirect('/employer');
                break;
            default:
                return redirect('/select-option');
                break;
        }
    }

    public function adminDashboard(){
        // Get live statistics
        $totalEmployees = User::where('role', 'employee')->count();
        $totalEmployers = User::where('role', 'employer')->count();
        $totalJobPosts = JobPost::count();
        $totalApplications = JobApplication::count();
        $totalRevenue = PaymentHistory::where('status', 'completed')->sum('amount');
        $recentApplications = JobApplication::with(['user', 'jobPost'])->latest()->take(5)->get();
        
        // Monthly data for charts (last 6 months)
        $months = [];
        $employeeData = [];
        $employerData = [];
        $jobPostData = [];
        $applicationData = [];
        $revenueData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $months[] = $month->format('M Y');
            
            $employeeData[] = User::where('role', 'employee')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
                
            $employerData[] = User::where('role', 'employer')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
                
            $jobPostData[] = JobPost::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
                
            $applicationData[] = JobApplication::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
                
            $revenueData[] = PaymentHistory::where('status', 'completed')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('amount');
        }
        
        // Application status distribution
        $applicationStatusData = [
            'pending' => JobApplication::where('status', 'pending')->count(),
            'shortlisted' => JobApplication::where('status', 'shortlisted')->count(),
            'rejected' => JobApplication::where('status', 'rejected')->count(),
            'hired' => JobApplication::where('status', 'hired')->count(),
        ];
        
        // Top industries by job posts
        $topIndustries = \DB::table('job_posts')
            ->join('industries', 'job_posts.industry_id', '=', 'industries.id')
            ->select('industries.industry_name', \DB::raw('count(*) as total'))
            ->groupBy('industries.industry_name')
            ->orderByDesc('total')
            ->take(5)
            ->get();
        
        // Recent users (last 5)
        $recentUsers = User::whereIn('role', ['employee', 'employer'])
            ->latest()
            ->take(5)
            ->get();
        
        // Today's stats
        $todayEmployees = User::where('role', 'employee')->whereDate('created_at', today())->count();
        $todayEmployers = User::where('role', 'employer')->whereDate('created_at', today())->count();
        $todayApplications = JobApplication::whereDate('created_at', today())->count();
        $todayRevenue = PaymentHistory::where('status', 'completed')->whereDate('created_at', today())->sum('amount');
        
        return view('admin.dashboard.index', compact(
            'totalEmployees',
            'totalEmployers',
            'totalJobPosts',
            'totalApplications',
            'totalRevenue',
            'recentApplications',
            'months',
            'employeeData',
            'employerData',
            'jobPostData',
            'applicationData',
            'revenueData',
            'applicationStatusData',
            'topIndustries',
            'recentUsers',
            'todayEmployees',
            'todayEmployers',
            'todayApplications',
            'todayRevenue'
        ));
    }

    public function chooseType(){
        $basics=Auth::user()->basics;
        if($basics){
            return view('choose_type');
            return redirect()->route('basic-details.index');
        }
        return view('choose_type');
    }

    public function registerAsJobSeeker(){
        $qualifications = Qualification::get();
        $skills = ComputerAndOtherSkill::get();
        $industries = Industry::get();
        $basics=Auth::user()->basics;
        $presentAddress = Auth::user()->presentAddress;
        $permanentAddress = Auth::user()->permanentAddress;
        $candidateQualifications = Auth::user()->qualifications;
        $candidateSkills = Auth::user()->skills;
        $candidateExperiences = Auth::user()->experiences;
        
        // Use enhanced registration view
        return view('users.registration.candidate-enhanced', compact(
            'qualifications',
            'skills',
            'industries',
            'basics',
            'presentAddress',
            'permanentAddress',
            'candidateQualifications',
            'candidateSkills',
            'candidateExperiences'
        ));
    }

    public function registerAsEmployer(){
        $industries = Industry::get();
        $profile=null;
        return view('users.registration.employer',compact('industries','profile'));
    }

    public function employeeDashboard(){
        if(count(Auth::user()->backGroundQuestions)){
            return view('users.dashboard.employee-enhanced');
        }else{
            return redirect()->route('employee.background-questions');
        }
    }

    public function employerDashboard(){
        return view('users.dashboard.employer');
    }

    public function backGroundQuestion(){
        $questions=BackGroundQuestion::get();
        $answers=BackgroundQuestionAnswer::where('user_id',Auth::user()->id)->first();
        return view('users.background-questions.index',compact('questions','answers'));
    }

    public function saveBackgroundQuestion(Request $request){
       $data=[
           'user_id'=>Auth::user()->id,
           'answers'=>json_encode($request->answers)
       ];
       $answer=BackgroundQuestionAnswer::where('user_id',Auth::user()->id)->first();
       if($answer){
           $answer->update($data);
       }else{
           BackgroundQuestionAnswer::create($data);
       }
       return redirect()->route('employee.dashboard')->with('success','Background question updated successfully');
    }

    public function changePassword()
    {
        return view('users.profile.change_password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);
        $res=Auth::user()->update(['password'=>Hash::make($request->password)]);
        if($res){
            return redirect()->back()->with(['success'=>'Password updated successfully']);
        }else{
            return redirect()->back()->with(['error'=>'Failed to update the password']);
        }
    }

    public function authUserProfile()
    {
        return view('users.profile.profile');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
			'first_name' => 'required',
            'mobile'=>'required',
            'image'=>'nullable|mimes:jpeg,jpg,png|max:2048',
		]);
        $image=Null;
        $user=Auth::user();
        if($request->file('image')){
            if($user->image!=null){
                unlink(public_path('uploads/profiles/'. $user->image));
            }
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('uploads/profiles'), $filename);
            $image= $filename;
        }
        $data=[
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'mobile'=>$request->mobile,
            'image'=>$image
        ];
        $res=$user->update($data);
        if($res){
            return redirect()->back()->with('success', 'Successfully updated the data.');
        }else{
            return redirect()->back()->with('error', 'Failed to update the data. Please try again.');
        }
    }

    public function subscriptionPackages()
    {
        $role=Auth::user()->role;
        switch ($role) {
            case "employee":
                $packages=SubscriptionPackage::where('type','employee')->get();
                break;
            case "employer":
                $packages=SubscriptionPackage::where('type','employer')->get();
                break;
            default:
                $packages=SubscriptionPackage::get();
                break;
        }
        $paymentMethods=PaymentMethod::where('status',1)->get();
        return view('users.subscription.packages',compact('packages','paymentMethods'));
    }
}
