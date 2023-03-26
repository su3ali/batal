<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function loginForm()
    {
        $pageConfigs = ['bodyCustomClass' => 'login-bg', 'isCustomizer' => false];

        return view('dashboard.auth.login', ['pageConfigs' => $pageConfigs]);
    }

    public function doLogin(LoginRequest $request)
    {
        $remember_me = $request->has('remember_me');
        if (!Auth::guard('dashboard')->attempt(['email' => $request->email, 'password' => $request->password], $remember_me)) {
            return back()
                ->with('message', trans('dash.logged_in_faild_data'))
                ->with('class', 'alert alert-danger');
        }
        // MK_REPORT('dashboard_auth_signin', 'Logged in successfully', '');
        return redirect()->route('dashboard.home')
            ->with('message', trans('dash.logged_in_successfully'))
            ->with('class', 'alert alert-success');
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        auth('dashboard')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin');
    }
}
