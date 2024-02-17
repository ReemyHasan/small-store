<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

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
        return response()->json($users);
    }

    public function store(UserRequest $request)
    {
        $validated = $request->validated();
        $user = $this->userService->create($validated);
        if ($user) {
        return response()->json(["user"=> $user, "message"=>"user added successfully"],201);
        } else {
            return response()->json(["user"=> null,"message"=> "error"],0);
        }
    }

    public function show($id)
    {
        $user = $this->userService->getById($id);
        if ($user != null) {
            return response()->json($user);

        } else {
            return response()->json(["message" => "user not found"], 404);
        }
    }

    public function update(UserRequest $request, $id)
    {
        $user = $this->userService->getById($id);
        if ($user != null) {
            $validated = $request->validated();
            $this->userService->update($user, $validated);
            return response()->json(["message" => "user updated successfully"], 202);
        } else {
            return response()->json(["message" => "user not found"], 404);
        }
    }

    public function destroy($id)
    {
        $user = $this->userService->getById($id);
        if ($user != null) {
            $this->userService->delete($user);
            return response()->json(["message" => "user deleted successfully"], 202);
        } else {
            return response()->json(["message" => "user not found"], 404);
        }
    }
}
