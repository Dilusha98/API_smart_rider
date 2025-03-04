<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
       
        $user = Auth::user();
        $user_role = Auth::user()->user_role;

        $permissionIds = DB::table('save_permissions')
        ->where('user_role', $user_role)
        ->pluck('permission');
       

        $permissions = DB::table('user_permissions')
            ->whereIn('upi', $permissionIds)
            ->pluck('tle');
        
        session(['permissions' => $permissions->toArray()]);

        // if ($user->role == 'student') {
        //     return redirect('/student-dashboard');
        // }

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
