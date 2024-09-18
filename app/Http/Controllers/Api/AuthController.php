<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\{AuthenticateResource,UserResource};
use App\Http\Requests\Api\{StoreUserRequest,UpdateUserRequest};
use App\Services\UserService;

class AuthController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function signIn(Request $request)
    {
        // Check if the request has the required fields
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            /** @var User $user */
            $user = Auth::user();

            return new AuthenticateResource([
                'plain_text_token' => $user->createToken('auth')->plainTextToken,
                'user' => $user,
            ], 201);
        }

        return response()->json('Unauthorized', 401);
    }

    public function signOut(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }

    public function signUp(StoreUserRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $user = $this->userService->create($request->validated());

            return new AuthenticateResource([
                'plain_text_token' => $user->createToken('auth')->plainTextToken,
                'user' => $user,
            ], 201);
        });
    }

    public function show(Request $request)
    {
        return new UserResource($request->user());
    }

    public function update(UpdateUserRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $user = $request->user();

            $this->userService->update($user, $request->validated());

            return new UserResource($user);
        });
    }
}
