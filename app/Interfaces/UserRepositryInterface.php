<?php
namespace App\Interfaces;
use Illuminate\Http\Request;

interface UserRepositryInterface {
    public function create();
    public function store(Request $request);
    public function show($id);
    public function update($request);
    public function destroy($id);
}
