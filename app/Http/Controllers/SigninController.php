<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Twilio\Rest\Client;

class SigninController extends Controller
{
    /**
     * Sends sms to user using Twilio's programmable sms client
     * @param String $message Body of sms
     * @param Number $recipients string or array of phone number of recepient
     */
    private function sendMessage($message, $recipient)
    {
        $account_sid = 'AC03692c801cd5c6cde0ca0e215f32d80a';
        $auth_token = 'b4565be0566e1f1a3638f6560b620ad6';
        $twilio_number = '+19896933392';
        // $client = new Client($account_sid, $auth_token);
        // $client->messages->create($recipient, 
        //         ['from' => $twilio_number, 'body' => $message] );
    }
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        // dd($request->all());
        $user = User::where('email',$request->email)->first();
        if (!$user->verified) {
            // auth()->logout();
            return back()->with('warning', 'You need to confirm your account. We have sent you an activation code, please check your email.');
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $otp = random_int(100000, 999999);
            $user = User::where('id',Auth::user()->id)->get();
            $user[0]->otp = $otp;
            $user[0]->save();

            $this->sendMessage("Your Megason Diagnostic Clinics account was logged in. To proceed, ' . $user[0]->otp . ' is your OTP. \n Don't share this with anyone. This will expire in 60 minutes.", $user[0]->contact_number);

            return redirect()->intended('home');
        }else{
            return redirect()->back()->withErrors(['Invalid email or password']);
        }
    }
}