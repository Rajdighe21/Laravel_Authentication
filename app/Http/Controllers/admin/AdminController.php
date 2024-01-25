<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    public function index()
    {
        return view("admin.login");
    }


    public function authenticate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required | email',
            'password' => 'required'
        ]);

        if ($validator->passes()) {

            if (
                Auth::guard('admin')->attempt(
                    ['email' => $request->email, 'password' => $request->password],
                    $request->get('remember')
                )
            ) {
                $admin = Auth::guard('admin')->user();

                return redirect()->route('admin.dashboard');

            } else {
               return redirect()->route('admin.login')->with('error',"Ether Email/password is incorrect");
            }

        } else {

            return redirect()->route('admin.login')->withErrors($validator)->withInput($request->only('email'));

        }

    }
}
