<?php

namespace App\Http\Controllers;

use App\User;
use App\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController
{
    /**
     * Display items.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::with('address')->paginate(5);
        return view('users.index', compact('users'));
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
        $validation = Validator::make($request->only('firstname', 'lastname','email', 'personal_code'), [
            'firstname' => 'required|min:3',
            'lastname' => 'required|min:3',
            'email' => 'required|email',
            'personal_code' => 'required|min:3',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' =>$validation->errors()->all()]);
        } else {

            $user = User::find($user_id);
            $user->firstname = $request->input('firstname');
            $user->lastname = $request->input('lastname');
            $user->email = $request->input('email');
            $user->personal_code = $request->input('personal_code');
            $user->save();

            $addAddress = $request->input('address');
            $deletedAddress = $request->input('deletedAddress');

            if (!empty($deletedAddress)) {
                Address::destroy($deletedAddress);
            }

            if (!empty($addAddress)) {
                foreach ($addAddress as $item) {

                    $address = Address::find($item['id']);

                    if (count($address) > 0) {
                        $address->country = !empty($item['country']) ? $item['country'] : '';
                        $address->city = !empty($item['address']) ? $item['address'] : '';
                        $address->address = !empty($item['address']) ? $item['address'] : '';
                        $address->save();
                    } elseif (!empty($item['country'])) {
                        $addressNew = new Address();
                        $addressNew->user_id = $user_id;
                        $addressNew->country = !empty($item['country']) ? $item['country'] : '';
                        $addressNew->city = !empty($item['address']) ? $item['address'] : '';
                        $addressNew->address = !empty($item['address']) ? $item['address'] : '';
                        $addressNew->save();
                    }
                }
            }

            return response()->json([
                'user' => $user,
                'message' => 'User has been updated'
            ]);
        }
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
        $user['address'] = Address::where('user_id', $user_id)->get();
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
        if ($user) {
            Address::where('user_id', $user_id)->delete();

            return response()->json([
                'user' => $user,
                'message' => 'User has been deleted'
            ]);
        } else {
            return response()->json(['errors' => 'not found user id']);
        }
    }

    /**
     * Save item.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->only('firstname', 'lastname','email', 'personal_code'), [
            'firstname' => 'required|min:3',
            'lastname' => 'required|min:3',
            'email' => 'required|email',
            'personal_code' => 'required|min:3',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()->all()]);
        } else {

            $user = new User();
            $user->firstname = $request->input('firstname');
            $user->lastname = $request->input('lastname');
            $user->email = $request->input('email');
            $user->personal_code = $request->input('personal_code');
            $user->save();

            $list = $request->input('address');

            if (count($list) > 0) {
                foreach ($list as $k => $v) {
                    $address = new Address();
                    $address->user_id = $user->id;
                    $address->country =  $v['country'];
                    $address->city =  $v['address'];
                    $address->address = $v['address'];
                    $address->save();
                }
            }

            return response()->json([
                'user' => $user,
                'message' => 'User has been added'
            ]);
        }
    }
}