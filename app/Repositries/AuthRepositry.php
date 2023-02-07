<?php
namespace App\Repositries;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\AuthRepositryInterface;
use App\Models\User;

class AuthRepositry implements AuthRepositryInterface
{
    public function index(){
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|exists:admins,email',
            'password'=>'required'
        ]);
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('dashboard');
        }
        else{
            return redirect()->back()->with('delete','Invalid Credentials');
        }
    }
    public function dashboard()
    {
        $users=User::all();
        return view('home',get_defined_vars());
    }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }


}

