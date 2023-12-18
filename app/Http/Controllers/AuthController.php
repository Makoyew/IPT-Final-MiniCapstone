<?php

namespace App\Http\Controllers;

use App\Jobs\CustomerJob;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm() {
        if (auth()->check()) {
            return redirect()->route('dashboard'); // Redirect authenticated users to the dashboard
        }
        return view('auth.login');
    }

    public function registerForm() {
        if (auth()->check()) {
            return redirect()->route('dashboard'); // Redirect authenticated users to the dashboard
        }

        return view('auth.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->email_verified_at == null) {
            return redirect('/')->with('error', 'Sorry your account is not yet verified.');
        }

        $login = auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        if (!$login) {
            return back()->with('error', 'Invalid Credentials.');
        }

        return redirect('/dashboard');
        // $credentials = $request->only('email', 'password');
        // if (Auth::attempt($credentials)) {
        //     if (Auth::user()->email_verified_at) {
        //         return view('dashboard');
        //     } else {
        //         Auth::logout();
        //         return redirect()->route('loginForm')->with('error', 'Email not verified. Please check your email for verification instructions.');
        //     }
        // }

        // return redirect()->route('loginForm')->with('error', 'Invalid credentials');
    }

    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function dashboard()
{
        if (Auth::check()) {
            $userCount = User::count();
            $enrollmentCount = Enrollment::count();
            $courseCount = Course::count();

            return view('dashboard', compact('userCount', 'enrollmentCount', 'courseCount'));
        }

        return redirect()->route('loginForm');
    }

    public function register(Request $request) {
        $request->validate([
            'name'  => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|string|min:6'
        ]);

        $token = Str::random(24);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'remember_token' => $token
        ]);

        // dispatch(new CustomerJob($user->id));
        CustomerJob::dispatch($user);
        // Mail::send('auth.verification-mail', ['user' => $user], function($mail) use($user){
        //     $mail->to($user->email);
        //     $mail->subject('Account Verification');
        // });

        return redirect('/')->with('message', 'Your account has been created. Please check email for the verification.');
    }

    public function verification(User $user, $token) {
        if($user->remember_token !== $token) {
            return redirect('/')->with('error', 'Invalid token.');
        }

        $user->email_verified_at = now();
        $user->save();

        return redirect('/')->with('message', 'Your account has been verified');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/')->with('message', 'Logged out successfully.');
    }

}
