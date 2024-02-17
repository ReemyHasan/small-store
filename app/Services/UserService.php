<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserService
{
    public function getAll(){
        $users = User::getRecords();
        return $users;
    }
    public function create($data){
        $data['password']= Hash::make($data['password']);
        return User::create($data);
    }
    public function getById($id){
        return User::getRecord($id);
    }
    public function update($user, $validated){
        return $user->update($validated);
    }
    public function delete($user){
        return $user->delete();
    }

}
