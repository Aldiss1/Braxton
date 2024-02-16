<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('Auth.login');
    }

    public function checkCredential()
    {
        $credential = Request()->input('credential');
        $fieldType = filter_var($credential, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->marge([$fieldType => $credential]);
        return $fieldType;
    }
    public function login()
    {
        try{
            //cek clien login dengan username
            $credentialType = $this->checkCredential();
            //validasi username
            if($credentialType === "username") {
                $credentialValidation = 'username|required';
            }else{
                $credentialValidation = 'required';
                $user = User::where('username', request('credential'))->first();
            }
            $validation = Validator::make(request()->all(),[
                'credential' => $credentialValidation,
                'password' => "required",
            ]);
           if ($$validator->fails()) {
                return redirect('/')->withErrors($validator)->withInput();
            }
            // khusus untuk client jika login dari username
            if ($credentialType == 'username') {
                if ($user == null) {
                    //ketika user login dengan username, kemudian username tidak ditemukan
                    return redirect('/')->with('error', 'Username tidak ditemukan');
                } else {
                    $username = $user->username;
                }
            }
            $credential = $email ?? request('credential');
            $password = request('password');
            $credentials = [
                'username' => $credential,
                'password' => $password,
            ];
            $user = User::with('roles')->where('username', $credential)->first();
            if (!$user) {
                return redirect('/')->with('error', 'Email tidak ditemukan');
            }
            if (!Hash::check($password, $user->password, [])) {
                return redirect('/')->with('error', 'Password salah');
            }
            Auth::login($user);
            if ($user->hasRole('admin')) {
                return redirect('/admin')->with('status', 'Login berhasil');
            }
            if ($user->hasRole('kasir')) {
                return redirect('/kasir')->with('status', 'Login berhasil');
            }
        } catch (Exception $error) {
            return redirect('/')->with('error', $error);

        }
    }
}
