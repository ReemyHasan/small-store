<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\UserRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAll();
        if ($users) {
            return response()->json([
                "message" => "all users",
                "users" => $users
            ], 200);
        }
    }

    public function store(UserRequest $request)
    {
        $request->validated();
        return DB::transaction(function () use ($request) {
            $user = $this->userService->create($request->except('image', 'password_confirmation'));

            if ($request->hasFile('image') && ($image = $this->userService->handleUploadedImage($request->file('image'), $user))) {
                $userImage = $this->userService->saveImage($image, $user);

                if (!$userImage) {
                    return response()->json(["user" => $user, "message" => "image not saved"]);
                }
            }
            return response()->json(["user" => $user, "message" => "user added successfully"], 201);
        });



    }

    public function show($id)
    {
        $user = $this->userService->getById($id);
        if (!$user)
            return response()->json(["message" => "user not found"], 404);

        return response()->json(['user' => $user]);

    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->userService->getById($id);
        if (!$user) {
            return response()->json(["message" => "user not found"], 404);
        }
        $request->validated();
        return DB::transaction(function () use ($request, $user) {
            $this->userService->update($user, $request->except('image', 'password_confirmation'));


            if ($request->hasFile('image') && ($image = $this->userService->handleUploadedImage($request->file('image'), $user))) {
                $userImage = $this->userService->updateImage($image, $user);

                if (!$userImage) {
                    return response()->json(["user" => $user, "message" => "image not saved"]);
                }
            }

            return response()->json(["message" => "user updated successfully"], 202);
        });

    }

    public function destroy($id)
    {
        $user = $this->userService->getById($id);
        if (!$user)
            return response()->json(["message" => "user not found"], 404);

        return DB::transaction(function () use ($user) {
            if ($this->userService->deleteImage($user) && $this->userService->delete($user)) {
                return response()->json(["message" => "User deleted successfully"], 202);
            }
        });

    }
}
