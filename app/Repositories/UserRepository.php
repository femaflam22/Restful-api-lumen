<?php
namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\IUserRepository;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

class UserRepository extends GenericRepository implements IUserRepository
{
    public function __construct()
    {
        parent::__construct(app(User::class));
    }

    public function userRegister(array $data)
    {
        unset($data['confirm_password']);
        $data['password'] = Hash::make($data['password']);
        $register = $this->model->create($data);
        $access_token = $register->createToken('users')->accessToken;
        $refresh_token = $register->createToken('users')->refreshToken;
        $result = array(
            'username' => $data['username'],
            'password' => $data['password'],
            'email' => $data['email'],
            'access_token' => $access_token,
            'refresh_token' => $refresh_token
        );

        return $result;
    }

    public function userLogin(array $data)
    {
        // $user = $this->model->where('email', '=', $data['username'])->first();

        $client = new Client();
        try{
            return $client->post('http://localhost:9000/auth/token', [
                "form_params" => [
                    "client_secret" => "GcQkpnRHDOVpYF7E2HbuaeyxuTlL93puytbDoS1O",
                    "grant_type" => "password",
                    "client_id" => 2,
                    "username" => $data['email'],
                    "password" => $data['password']
                ]
                ]);
        } catch(BadResponseException $err){
            $result = array(
                'message' => $err->getMessage()
            );
            return $result;
        }

        // if($user){
        //     $password = $data['password'];

        //     if(Hash::check($password, $user['password'])){
        //         // $token = $user->createToken('users')->accessToken;
        //         $result = array(
        //             'username' => $data['username'],
        //             'password' => $data['password'],
        //             // 'token' => $token
        //         );
        //     } else {
        //         $result = array(
        //             'message' => "password doesn't match"
        //         );
        //     }
        // } else {
        //     $result = array(
        //         'message' => "email not found"
        //     );
        // }
        // return $result;
    }
}