<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\Roles\GetRolesRequest;
use App\Http\Requests\Roles\StoreRolesRequest;
use App\Http\Requests\Roles\UpdateRolesRequest;
use Illuminate\Support\Facades\Auth;
class RoleController extends Controller
{
    public function index(GetRolesRequest $request)
    {
        $roles = Role::paginate($request->per_page ?? 10);

        return response()->json($roles);
    }

    public function store(StoreRolesRequest $request)
    {
        $data = $request->validated();

        $role = Role::create($data);

        $role->syncPermissions($data['permissions']);

        return response()->json($role);
    }

    public function show(Role $role)
    {
        return response()->json($role);
    }

    public function update(UpdateRolesRequest $request, Role $role)
    {
        $data = $request->validated();

        $role->update($data);

        $role->syncPermissions($data['permissions']);

        return response()->json($role);
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json(null, 204);
    }
}
