<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('admin_authenticated')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $adminEmail = env('ADMIN_EMAIL', 'gadcatsu@gmail.com');
        $adminPassword = env('ADMIN_PASSWORD', 'Fr4nzJermido.');

        if ($credentials['email'] === $adminEmail && $credentials['password'] === $adminPassword) {
            session(['admin_authenticated' => true]);
            session(['admin_email' => $credentials['email']]);
            
            // Log login activity
            LogActivity::logLogin($credentials['email']);
            
            return redirect()->route('admin.dashboard')->with('success', 'Login successful!');
        }

        return back()->withErrors(['credentials' => 'Invalid email or password.']);
    }

    public function logout()
    {
        // Log logout activity
        $email = session('admin_email');
        LogActivity::logLogout();
        
        session()->forget('admin_authenticated');
        session()->forget('admin_email');
        
        return redirect()->route('admin.login')->with('success', 'Logout successful!');
    }
}
