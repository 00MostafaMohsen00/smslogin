<?php
namespace App\Repositries;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\UserRepositryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepositry implements UserRepositryInterface
{
    public function create()
    {
        return view('users.create');
    }
    public function store(Request $request)
    {
        $request->validate( [
            'user_name'=>'required|string',
            'email'=>'required|email|unique:users,email',
            'mobile_number'=>'required|numeric|unique:users,mobile_number',
            'password' => 'required|confirmed|min:6',
        ]);
        User::create([
            'user_name' => $request->user_name,
            'email' => $request->email,
            'password' =>Hash::make($request->password),
            'mobile_number' => $request->mobile_number,
        ]);
        return redirect()->route('dashboard')->with('Add', 'User Created Successfully');
    }
    public function show($id)
    {
        $user=User::findOrFail($id);
        return view('users.edit',get_defined_vars());
    }

    public function update($request)
    {
        $request->validate( [
            'user_name'=>'required|string',
            'email'=>'required|email|unique:users,email,'.$request->id,
            'mobile_number'=>'required|numeric|unique:users,mobile_number,'.$request->id,
        ]);
        $user=User::findOrFail($request->id);
            $user->user_name = $request->user_name;
            $user->email = $request->email;
            $user->mobile_number = $request->mobile_number;
            if($request->password){
                $request->validate([
                    'password' => 'sometimes|confirmed|min:6',
                ]);
                $user->password = Hash::make($request->password);
            }
            $user->save();

        return redirect()->route('dashboard')->with('edit', 'User Updated Successfully');

    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('dashboard')->with('delete','User Deleted Successfully . . . ');
    }
}

