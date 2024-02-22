<?php

namespace App\Services;

use App\Models\User;
use App\Traits\CommonService;

class UserService
{
    use CommonService;
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
    public function handleUploadedImage($image, $user)
    {
        return HandleUploadedImage($image, $user, 'users');
    }
}
