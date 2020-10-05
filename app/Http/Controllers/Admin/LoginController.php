<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function getLogin()
    {
        return view('admin.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $remember_me = $request->has('remember_me' ) ? true : false;

        if (auth()->guard('admin')->attempt(['email'    => $request->input('email'), 'password' => $request->input('password')])) {
            //notify()->success('تم الدخول بنجاح');
            return redirect()->route('admin.dashboard');
        }
        //notify()->error('خطأ في ادخال البيانات نرجو المحاولة مجددا');
        return redirect()->back()->with(['error' => 'هناك خطأ بالبيانات .']);
    }
}
