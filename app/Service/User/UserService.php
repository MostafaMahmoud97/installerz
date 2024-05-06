<?php


namespace App\Service\User;


use App\Models\Media;
use App\Models\User;
use App\Traits\GeneralFileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class UserService
{
    use GeneralFileService;

    public function show(){
        $user_id = Auth::id();
        $user = User::with("media")->find($user_id);
        return Response::successResponse($user,"data has been fetched success");
    }

    public function update($request){
        $user = Auth::user();
        $user->update($request->all());

        if($request->logo && $request->logo != null){
            $media = $user->media;
            if ($media){
                $this->removeFile($media->file_path);
                $media->delete();
            }

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

        return Response::successResponse([],"user has been updated success");
    }

    public function change_password($request){
        $user = Auth::user();

        if(!Hash::check($request->old_password,$user->password)){
            return Response::errorResponse("incorrect old password");
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return Response::successResponse([],"password has been changed success");
    }

}
