<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Services\UserService;

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
        $validated = $request->validated();
        $user = $this->userService->create($request->except('image', 'password_confirmation'));
        if ($user) {
            if ($request->hasFile('image')) {
                if ($image = $this->userService->handleUploadedImage($request->file('image'), $user)) {
                    $userImage = $this->userService->saveImage($image, $user);
                    $user->image;
                    if ($userImage)
                        return response()->json(["user" => $user, "message" => "user added successfully"], 201);
                    else {
                        return response()->json(["user" => $user, "message" => "image not saved"]);
                    }
                }
            }
            return response()->json(["user" => $user, "message" => "user added successfully"], 201);
        }
        return response()->json(["message" => "user not saved"]);

    }

    public function show($id)
    {
        $user = $this->userService->getById($id);
        if ($user != null) {
            return response()->json(['user' => $user]);

        } else {
            return response()->json(["message" => "user not found"], 404);
        }
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->userService->getById($id);
        if ($user != null) {
            $request->validated();
            $this->userService->update($user, $request->except('image','password_confirmation'));
            if ($request->hasFile('image')) {
                if ($image = $this->userService->handleUploadedImage($request->file('image'), $user)) {
                    $userImage = $user->image()->update(
                        [
                            'url' => $image,
                        ]
                    );
                    if ($userImage)
                        return response()->json(["user" => $user, "message" => "user updated successfully"], 202);
                    else {
                        return response()->json(["user" => $user, "message" => "image not saved"]);
                    }
                }
            }
            return response()->json(["message" => "user updated successfully"], 202);
        } else {
            return response()->json(["message" => "user not found"], 404);
        }
    }

    public function destroy($id)
    {
        $user = $this->userService->getById($id);
        if ($user != null) {
            $user->image()->delete();
            if ($this->userService->delete($user))
                return response()->json(["message" => "user deleted successfully"], 202);
        } else {
            return response()->json(["message" => "user not found"], 404);
        }
    }
}
