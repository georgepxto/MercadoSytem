<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\DashboardManager;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login attempt
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Try to authenticate as dashboard manager first
        if (Auth::guard('dashboard_manager')->attempt($credentials, $request->filled('remember'))) {
            // Debug: log que admin fez login
            \Log::info('Admin login successful for: ' . $credentials['email']);
            
            // Regenerate session to prevent session fixation
            $request->session()->regenerate();
            
            return redirect('/admin/dashboard');
        }

        // Try to authenticate as regular user
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();
            
            // Check if user has dashboard access
            if (!$user->hasDashboardAccess()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Você não tem acesso autorizado ao dashboard.',
                ]);
            }

            // Regenerate session to prevent session fixation
            $request->session()->regenerate();
            
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não coincidem com nossos registros.',
        ]);
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        if (Auth::guard('dashboard_manager')->check()) {
            Auth::guard('dashboard_manager')->logout();
        } else {
            Auth::logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
