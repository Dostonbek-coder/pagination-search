<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('name','like','%'.request('q').'%')->paginate(request('per_page',10));
        return response()->json($users);
    }
}
