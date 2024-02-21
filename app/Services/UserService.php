<?php

namespace App\Services;

use App\Models\User;

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
    public function handleUploadedImage($image, $user)
    {
        return HandleUploadedImage($image,$user,'users');
    }
    public function saveImage($image, $user)
    {
        return $user->image()->create(
            [
                'url' => $image,
            ]
        );
    }
}
