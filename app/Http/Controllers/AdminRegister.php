<?php

namespace App\Http\Controllers;

use App\Models\AdminReg;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class AdminRegister extends Controller
{
    public function registeradmin(Request $adminreg){
        $validateAdmin = $adminreg->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20', // Adjust max length as per your needs
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        $newadmin = new AdminReg;



        $newadmin->name = $validateAdmin['name'];
        $newadmin->phone = $validateAdmin['phone'];
        $newadmin->email = $validateAdmin['email'];
        $newadmin->password = $validateAdmin['password'];


        $newadmin->save();


        return redirect()->route('admin.login');

    }

    public function registerlog(Request $logreq)
    {
        // Validate the input
        $logreq->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Retrieve the input values
        $email = $logreq->input('email');
        $password = $logreq->input('password');

        // Find the user with the given email
        $user = AdminReg::where('email', $email)->first();

        // Check if the user exists and the password matches
        if ($user && $password == $user->password) {
            // Store the admin ID in the session
            session(['admin_id' => $user->id]);

            // Redirect to the admin dashboard
            return redirect()->route('admin.dashboard');
        } else {
            // If login fails, redirect back with an error message
            return back()->withErrors(['login' => 'Invalid credentials, please try again.'])->withInput();
        }
    }
}
