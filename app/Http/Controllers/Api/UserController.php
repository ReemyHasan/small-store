<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\UserRequest;
use App\Models\User;
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
        $this->authorize('view','App\Models\User');
        $users = User::filterBy(request()->all())->get();
        if ($users) {
            return response()->json([
                "message" => "all users",
                "users" => $users
            ], 200);
        }
    }

    public function store(UserRequest $request)
    {
        $this->authorize('create','App\Models\User');
        $request->validated();
        return DB::transaction(function () use ($request) {
            $user = $this->userService->create($request->except('image', 'password_confirmation'));

            $user->createToken('auth_token')->plainTextToken;
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
        $this->authorize('view','App\Models\User');
        $user = $this->userService->getById($id);
        if (!$user)
            return response()->json(["message" => "user not found"], 404);

        return response()->json(['user' => $user]);

    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->userService->getById($id);
        $this->authorize('update',$user);

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
        $this->authorize('delete',$user);
        if (!$user)
            return response()->json(["message" => "user not found"], 404);

        return DB::transaction(function () use ($user) {
            if ($this->userService->deleteImage($user) && $this->userService->delete($user)) {
                return response()->json(["message" => "User deleted successfully"], 202);
            }
        });

    }
}
