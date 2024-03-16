<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\UpdatePermissionsRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class PermissionRoleController extends Controller
{
    public function updateRolePermissions(Request $request, $roleId)
    {
        $this->authorize('update','App\Models\Permission');
        $request->validated();
        $role = Role::findOrFail($roleId);
        $role->permissions()->sync($request->permissions);

        return response()->json(['message' => 'Role permissions updated successfully']);
    }
}
