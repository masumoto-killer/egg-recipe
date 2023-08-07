<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function viewProfile(User $user)
    {
        $user = auth()->user();
        return view('profile',['user' => $user,]);
    }
}
