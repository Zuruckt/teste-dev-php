<?php

namespace App\Http\Controllers;

use App\Repositories\AuthRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $repository;

    /**
     * AuthController constructor.
     * @param $repository
     */
    public function __construct(AuthRepository $repository)
    {
        $this->repository = $repository;
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|exists:App\Models\User,email',
            'password' => 'required'
        ]);

        return $this->repository->login($request->all());
    }

    public function logout(Request $request)
    {
        $this->repository->logout();
    }

    public function me()
    {
        return $this->repository->me();
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:App\Models\User,email',
            'password' => 'required|confirmed'
        ]);

        return $this->repository->createUser($request->all());
    }

    public function refresh()
    {
        return $this->repository->refresh();
    }
}
