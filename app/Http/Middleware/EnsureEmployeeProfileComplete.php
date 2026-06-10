<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmployeeProfileComplete
{
    /**
     * Routes an employee may still reach while their profile is incomplete.
     * Everything else is redirected to the profile-completion screen.
     */
    protected array $allowedRoutes = [
        // Profile-completion screen itself
        'jobseeker.register',
        // Step / AJAX save endpoints used by the profile builder
        'basic-details.index',
        'basic-details.store',
        'basic-details.show',
        'basic-details.create',
        'basic-details.edit',
        'basic-details.update',
        'basic-details.destroy',
        'save-candidate-address',
        'save-candidate-qualification',
        'save-candidate-skill',
        'save-candidate-experience',
        'save-candidate-profile',
        // Guideline / agreement steps
        'education.guidelines',
        'education.agree',
        'experience.guidelines',
        'experience.agree',
        // Always let the user log out
        'logout',
    ];

    /**
     * Force employees with an unfinished profile into the profile-completion
     * flow before they can reach any other screen. This applies even before
     * email verification, since profile completion comes first.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->role === 'employee' && is_null($user->profile_completed_at)) {
            $routeName = optional($request->route())->getName();

            // Allow the profile-build routes and the hierarchical dropdown
            // data the form fetches (qualifications / industries / skills).
            $allowed = in_array($routeName, $this->allowedRoutes, true)
                || $request->is('api/*');

            if (! $allowed) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Please complete your profile to continue.',
                        'redirect' => route('jobseeker.register'),
                    ], 403);
                }

                return redirect()->route('jobseeker.register')
                    ->with('warning', 'Please complete your profile to continue.');
            }
        }

        return $next($request);
    }
}
