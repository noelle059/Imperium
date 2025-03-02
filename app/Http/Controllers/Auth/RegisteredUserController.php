<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Define custom error messages
        $messages = [
            'name.required' => 'The name field is required.',
            'name.regex' => 'The name may only contain letters and spaces.',
            'last_name.required' => 'The last name field is required.',
            'last_name.regex' => 'The last name may only contain letters and spaces.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.lowercase' => 'The email must be in lowercase.',
            'email.max' => 'The email may not be greater than 255 characters.',
            'email.unique' => 'The email has already been taken.',
            'contact_number.required' => 'The contact number field is required.',
            'contact_number.size' => 'The contact number must be exactly 11 digits.',
            'contact_number.regex' => 'The contact number must start with 09 and be followed by 9 digits.',
            'contact_number.unique' => 'The contact number has already been taken.',
            'password.required' => 'The password field is required.',
            'password.confirmed' => 'The password confirmation does not match.',
            'g-recaptcha-response.required' => 'Please complete the reCAPTCHA.',
        ];
    
        try {
            $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[\p{L} ]+$/u' 
                ],
                'last_name' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[\p{L} ]+$/u' 
                ],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User   ::class],
                'contact_number'=> [
                    'required',
                    'string',
                    'size:11', 
                    'regex:/^09[0-9]{9}$/',
                    'unique:'.User   ::class,
                ],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'g-recaptcha-response' => 'required', // Validate the reCAPTCHA response
            ], $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Redirect back with input and errors
            return redirect()->back()->withInput()->withErrors($e->validator);
        }
    
        // Verify the reCAPTCHA response
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
        ]);
    
        $responseBody = json_decode($response->getBody());
    
        // Log the response for debugging
        \Log::info('reCAPTCHA response:', (array) $responseBody);
    
        if (!$responseBody->success) {
            return redirect()->back()->withErrors(['recaptcha' => 'reCAPTCHA verification failed.']);
        }
    
        // Proceed with user registration
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'contact_number' => $request->contact_number,
        ]);
    
        event(new Registered($user));
    
        Auth::login($user);
    
        return redirect(route('dashboard', absolute: false));
    }
}
