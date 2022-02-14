<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    /**
     * List all Users from database
     */
    function getAllUsers()
    {
        return response()->json(User::All());
    }
}
