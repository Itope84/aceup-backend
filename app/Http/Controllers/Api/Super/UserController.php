<?php

namespace App\Http\Controllers\Api\Super;

use App\user;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Super\UserResource;
use App\Http\Requests\Super\UserRequest;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index()
    {
        if(request()->role) {
            $users = User::whereRole(request()->role)->latest()->paginate(20);
        } else {
            $users = User::latest()->paginate(10);
        }
        return UserResource::collection($users);
    }

    public function store(UserRequest $request)
    {
        $data = $request->only(['email', 'password', 'first_name', 'last_name']);

        $data['role'] = User::EDITOR_TYPE;

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return new UserResource($user);
    }
}
