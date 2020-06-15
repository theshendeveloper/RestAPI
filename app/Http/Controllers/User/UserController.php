<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::all();
        return $this->showAll($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed',
        ]);
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['admin'] = User::REGULAR_USER;
        $user = User::create($data);
        return $this->showOne($user,201);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'email'=>'email|unique:users,email,'.$user->id,
            'password'=>'min:6|confirmed',
            'admin' => 'in:'.User::ADMIN_USER . ',' . User::REGULAR_USER,
        ]);
        if ($request->has('name')){
            $user->name = $request->name;
        }
        if ($request->has('email')){
            $user->email = $request->email;
        }
        if ($request->has('password')){
            $user->password = bcrypt($request->password);
        }
        if ($request->has('admin')){
            $user->admin = $request->admin;
        }
        if (!$user->isDirty()){
            return $this->errorResponse('You need to specify a different value to update',422);
        }
        $user->save();
        return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->showOne($user);

    }
}
