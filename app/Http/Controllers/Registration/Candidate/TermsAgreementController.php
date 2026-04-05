<?php

namespace App\Http\Controllers\Registration\Candidate;

use App\Http\Controllers\Controller;
use App\Models\TermsAgreement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TermsAgreementController extends Controller
{
    /**
     * Show Education Guidelines Page
     */
    public function educationGuidelines()
    {
        $user = Auth::user();
        $hasAgreed = TermsAgreement::where('user_id', $user->id)
            ->where('type', 'education')
            ->where('agreed', true)
            ->exists();

        if ($hasAgreed) {
            return redirect()->route('experience.guidelines');
        }

        return view('users.registration.guidelines.education');
    }

    /**
     * Show Experience Guidelines Page
     */
    public function experienceGuidelines()
    {
        $user = Auth::user();
        $hasAgreed = TermsAgreement::where('user_id', $user->id)
            ->where('type', 'experience')
            ->where('agreed', true)
            ->exists();

        if ($hasAgreed) {
            return redirect()->route('register-as-job-seeker');
        }

        return view('users.registration.guidelines.experience');
    }

    /**
     * Store Education Agreement
     */
    public function agreeEducation(Request $request)
    {
        $request->validate([
            'agreed' => 'required|accepted',
        ]);

        TermsAgreement::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'type' => 'education',
            ],
            [
                'agreed' => true,
                'agreed_at' => now(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]
        );

        return redirect()->route('experience.guidelines');
    }

    /**
     * Store Experience Agreement
     */
    public function agreeExperience(Request $request)
    {
        $request->validate([
            'agreed' => 'required|accepted',
        ]);

        TermsAgreement::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'type' => 'experience',
            ],
            [
                'agreed' => true,
                'agreed_at' => now(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]
        );

        return redirect()->route('register-as-job-seeker');
    }
}