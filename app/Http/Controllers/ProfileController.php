<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile($id)
    {
        $user = User::with(['questions','answers','answers.question'])->find($id);
        return view('profile')->with('user', $user);
    }
}
