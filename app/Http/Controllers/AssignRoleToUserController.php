<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RoleToUser\AssignRoleToUserRequest;
use Illuminate\Http\Request;

class AssignRoleToUserController extends Controller
{
    public function __invoke(AssignRoleToUserRequest $request)
    {
        $user = User::find($request->user_id);

        $user->assignRole($request->role_id);
        
        return response()->json(['message' => 'Role assigned to user successfully']);
    }
}
