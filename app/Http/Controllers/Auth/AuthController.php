<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Interfaces\AuthRepositryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $auth;
    public function __construct(AuthRepositryInterface $auth)
    {
        $this->auth=$auth;
    }
    public function index(){
        return $this->auth->index();
    }
    public function login(Request $request){
        return $this->auth->login($request);
    }
    public function dashboard(){
        return $this->auth->dashboard();
    }
    public function logout(Request $request){
        return $this->auth->logout($request);
    }
}
