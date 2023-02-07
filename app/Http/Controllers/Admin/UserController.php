<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\UserRepositryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;
    public function __construct(UserRepositryInterface $user)
    {
        $this->user=$user;
    }
    public function create()
    {
        return $this->user->create();
    }


    public function store(Request $request)
    {
        return $this->user->store($request);
    }

    public function show($id)
    {
        return $this->user->show($id);
    }


    public function update(Request $request, $id)
    {
        return $this->user->update($request);
    }


    public function destroy($id)
    {
        return $this->user->destroy($id);
    }
}
