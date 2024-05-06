<?php


namespace App\Service\User;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class AuthService
{
    public function login($request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('passport_token',["user"])-> accessToken;
            $success['user'] =  $user;

            if ($user->is_active == 0){
                return Response::errorResponse("you can't login now, you can contact with admin");
            }

            return Response::successResponse($success,"User login successfully.");
        }
        else{
            return Response::errorResponse("Unauthorised");
        }
    }

    public function forgot_password($request){

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if($status == Password::RESET_LINK_SENT){
            return Response::successResponse([],$status);
        }

        if ($status == Password::RESET_THROTTLED){
            return Response::errorResponse('reset message is sent to mail');
        }elseif ($status == Password::INVALID_USER){
            return Response::errorResponse('this user not found');
        }

        return Response::errorResponse($status);
    }

    public function callback_reset($request){
        return redirect()->to('http://localhost:8000/new-password?token='.$request->token."&email=".$request->email);
    }

    public function reset_password($request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8'
        ]);

        $status = Password::reset(
            $request->only('email','password','password_confirmation','token'),
            function ($user) use ($request){
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60)
                ])->save();
            }
        );

        if ($status == Password::PASSWORD_RESET){
            return Response::successResponse([],"password reset successfully");
        }

        return Response::errorResponse($status,[],500);
    }
}
