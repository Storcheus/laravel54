<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;

class UserController
{
    /**
     * Display items.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::all();
        return view('users.index')->with('users',$users);
    }

    /**
     * Update item.
     *
     * @param  Request  $request
     * @param  int  $user_id
     * @return Response
     */
    public function update(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $user->update($request->all());
        return response()->json($user);
    }

    /**
     * Get item.
     *
     * @param  int  $user_id
     * @return Response
     */
    public function show($user_id)
    {
        $user = User::find($user_id);
        return response()->json($user);
    }

    /**
     * Remove item.
     *
     * @param  int  $user_id
     * @return Response
     */
    public function destroy($user_id)
    {
        $user = User::destroy($user_id);
        return response()->json($user);
    }

    /**
     * Save item.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $user = User::create($request->input());
        return response()->json($user);
    }
}