<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\User;

class AdminController extends Controller
{
    //
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            # code...
            $data = $request->input();
            // dd($data); die;
            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password'],'admin'=>'1'])) {
                # code...
                // echo "Success"; die;
                // Session::put('adminSession',$data['email']);
                return redirect('/admin/dashboard');
            }else{
                // echo "Failed"; die;
                return redirect('/admin')->with('flash_message_error','invalid Username or Password');
            }
        }
        return view('admin.admin_login');
    }
 
    // 
    public function dashboard(){
        return view('admin.dashboard');
    }

    public function settings(){
        return view('admin.settings');
    }

    public function checkPassword( Request $request) {
        $data = $request->all();
        $current_password = $data['current_pwd'];
        $check_password = User::where(['admin' => '1'])->first();
        if (Hash::check($current_password, $check_password->password)) {
            # code...
            echo "true"; die;
        }else{
            echo "false"; die;
        }
    }

    public function logout(){
        Session::flush();
        return redirect('/admin')->with('flash_message_success','successfully Logged out');
    }
}
