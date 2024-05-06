<?php


namespace App\Service\Admin;


use App\Http\Resources\Admin\User\IndexUserPaginateResource;
use App\Models\Media;
use App\Models\User;
use App\Notifications\NotifyUserCreateNewAccount;
use App\Traits\GeneralFileService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Response;

class UserService
{
    use GeneralFileService;

    public function index($request){
        $users = User::with("media")
            ->where("company_name","like","%".$request->search."%");

        if ($request->is_active && $request->is_active != null && $request->is_active != "all"){
            $users = $users->where("is_active",$request->is_active);
        }

        if ($request->is_publish && $request->is_publish != null && $request->is_publish != "all"){
            $users = $users->where("is_publish",$request->is_publish);
        }

        $users = $users->paginate(15);

        return Response::successResponse(IndexUserPaginateResource::make($users),"users have been fetched success");
    }

    public function store($request){
        $user = User::create([
            'company_name' => $request->company_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            "phone" => $request->phone,
            "mail" => $request->mail,
            "address" => $request->address,
            "subdomain" => $request->subdomain,
        ]);

        if($request->logo && $request->logo != null){
            $path = "CompanyLogo/";
            $file_name = $this->SaveFile($request->logo,$path);
            $type = $this->getFileType($request->logo);
            Media::create([
                'mediable_type' => $user->getMorphClass(),
                'mediable_id' => $user->id,
                'title' => "CompanyLogo",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        Notification::send($user,new NotifyUserCreateNewAccount($user->company_name,$request->password,$user->email,"https://www.boxbyld.tech/"));

        return Response::successResponse($user,"user has been created success");
    }

    public function show($id){

    }

    public function update($id,$request){

    }

    public function change_activation_status($id){
        $user = User::find($id);
        if (!$user){
            return Response::errorResponse("Not found user");
        }

        if ($user->is_active == 1){
            $user->is_active = 0;
            $user->save();

            $tokens = $user->tokens;

            foreach ($tokens as $token){
                if($token->scopes[0] == "user"){
                    $token->delete();
                }
            }
        }else{
            $user->is_active = 1;
            $user->save();
        }

        return Response::successResponse([],"status has been changed success");
    }

    public function change_publish_status($id){
        $user = User::find($id);
        if (!$user){
            return Response::errorResponse("Not found user");
        }

        if ($user->is_publish == 1){
            $user->is_publish = 0;
            $user->save();
        }else{
            $user->is_publish = 1;
            $user->save();
        }

        return Response::successResponse([],"status has been changed success");
    }

}
