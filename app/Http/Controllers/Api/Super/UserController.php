<?php

namespace App\Http\Controllers\Api\Super;

use App\user;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Super\UserResource;


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
}
