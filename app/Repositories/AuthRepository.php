<?php


namespace App\Repositories;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
    /**
     * @var User
     */
    private User $model;

    /**
     * AuthRepository constructor.
     */
    public function __construct()
    {
        $this->model = new User();
    }

    public function createUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);

        return $this->model->create($data);
    }

    public function login(array $data)
    {
        $user = $this->model->where('email', $data['email'])->first();
        if(!$user) return response()->json(['error' => 'Unauthorized'], 401);

        if (!$token = auth()->attempt($data)) return response()->json(['message' => 'Could not authenticate you.'], 401);

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function me()
    {
        return auth()->user();
    }

    private function respondWithToken(string $token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
