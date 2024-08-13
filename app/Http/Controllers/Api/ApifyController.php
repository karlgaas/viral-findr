<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Search;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ApifyController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function login()
    {
        return view('login');
    }

    public function signIn(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->input('remember');
        if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            session()->flash('message', 'Logged in successfully.');
            return redirect()->intended('dashboard');
        } else {
            session()->flash('error', 'The provided credentials do not match our records.');
        }
    }

    public function showSignupForm()
    {
        return view('register');
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Account created successfully. Please login.');
    }

    public function home()
    {
        return view('home');
    }

    public function index()
    {
        return view('research');
    }

    public function search(Request $request)
    {
      try {
        $username = $request->input('username');
        set_time_limit(36000); // 10 hours
        // Define the path to your Node.js script and arguments
        $scriptPath = base_path('scripts/fetchInstagramData.js');
        $command = "node $scriptPath $username 2>&1";

        // Execute the command
        $output = [];
        $returnValue = 0;
        exec($command, $output, $returnValue);

        // Handle the result
        if ($returnValue !== 0) {
            Log::error("Error executing Node.js script: " . implode("\n", $output));
            return response()->json(['error' => 'Failed to fetch data'], 500);
        }
        $data = [];
        foreach ($output as $data) {
            // Convert JSON string to array
            $data = json_decode($data, true);

            // Make sure $data is an array
            if (is_array($data)) {
                // Push new elements if needed
                array_push($data, ['newKey' => 'newValue']);
            } else {
                // Handle the case where $data is not an array
                return response()->json(['error' => 'Invalid data format'], 400);
            }
        }
        return view('research', ['data' => $data]);

      } catch (\Throwable $th) {
        dd($th);
      }
    }
}
