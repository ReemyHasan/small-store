<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\UpdatePermissionsRequest;
use App\Models\Role;

class PermissionRoleController extends Controller
{
    public function updateRolePermissions(UpdatePermissionsRequest $request, $roleId)
    {
        $this->authorize('update','App\Models\Permission');
        $request->validated();
        $role = Role::findOrFail($roleId);

        $permissionsToUpdate = $request->input('permissions');

        foreach ($permissionsToUpdate as $permission) {
            $role->permissions()->syncWithoutDetaching([$permission['id'] => ['allow' => $permission['allow']]]);
        }

        return response()->json([
            'message' => 'Role permissions updated successfully',
            'role'=>$role->load(['permissions'])]);

    }
}
