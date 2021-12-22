<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserPostRequest;
use App\Http\Requests\UserLoginRequest;
use App\Repositories\Contracts\IUserRepository;

class AuthController extends Controller
{
    private $repo;
    public function __construct(IUserRepository $repo)
    {
        $this->repo = $repo;
    }

    public function register(Request $request)
    {
        $validate = new UserPostRequest($request->all());
        $data = $validate->parse();
        $user = $this->repo->userRegister($data);
        return $this->buildResponse('success', $user);
    }

    public function login(Request $request)
    {
        $validate = new UserLoginRequest($request->all());
        $data = $validate->parse();
        $user = $this->repo->userLogin($data);
        return $this->buildLoginResponse($user);
    }

    // public function logout()
    // {
    //     try{
    //         auth()->user()->token()->revoke();

    //         return $this->buildResponses('success', 'message', 'you are logouted!');
    //     } catch(\Exception $error){
    //         return $this->buildResponses('fail', 'message', 'fail to logout!');
    //     }
    // }
}
