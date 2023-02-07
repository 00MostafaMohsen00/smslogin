<?php
namespace App\Interfaces;
use Illuminate\Http\Request;

interface AuthRepositryInterface {
    public function index();
    public function login(Request $request);
    public function dashboard();
    public function logout(Request $request);

}
