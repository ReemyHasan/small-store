<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAll()
    {
        $users = User::getRecords();
        return $users;
    }
    public function create($data)
    {
        $user = new User();
        $user->forceFill($data);
        $user->save();
        return $user;
    }
    public function getById($id)
    {
        return User::getRecord($id);
    }
    public function update($user, $validated)
    {
        return $user->update($validated);
    }
    public function delete($user)
    {
        return $user->delete();
    }

}
