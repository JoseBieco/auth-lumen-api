<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * List all Users from database
     */
    function getAllUsers()
    {
        return response()->json(User::All());
    }

    /**
     * Get one entity from model User by id
     * @param $id int Author identifier
     */
    function getById($id)
    {
        return response()->json(User::find($id));
    }

    /**
     * Delete one entity from User model by id
     * @param $id int Author identifier
     */
    function delete($id)
    {
        User::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }

    // TODO:
    /**
     * - Update : {
     *  name,
     *  profile_picture
     * }
     *
     * - Change email
     * - Change password
     */

    /**
     * Update entity from User model
     * @param $id int User identifier
     * @param $request User
     */
    function update($id, Request $request)
    {
        if ($this->validUpdate($request)) {
            return response(["message" => "Can't update the email and password!"], 400);
        }

        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json($user, 200);
    }

    private function validUpdate(Request $request): bool
    {
        return $request->input('password') || $request->input('email');
    }
}
