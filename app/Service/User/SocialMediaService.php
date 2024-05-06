<?php


namespace App\Service\User;


use App\Http\Resources\User\SocialMedia\IndexSocialMedia;
use App\Models\SocialMedia;
use App\Models\UserSocialMedia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class SocialMediaService
{
    public function get_media_icons(){
        $SocialMedia = SocialMedia::with("media")->get();
        return Response::successResponse($SocialMedia,"icons have been fetched success");
    }

    public function index(){
        $user = Auth::user();
        $SocialMedia = $user->UserSocialMedia;
        return Response::successResponse(IndexSocialMedia::collection($SocialMedia),"media has been fetched success");
    }

    public function store($request){
        $UserSocial = UserSocialMedia::where(["user_id"=>Auth::id(),"social_media_id" => $request->social_id])->first();
        if ($UserSocial){
            return Response::errorResponse("this media is exists");
        }

        $user = Auth::user();
        $user->UserSocialMedia()->attach($request->social_id,["link" => $request->link]);

        return Response::successResponse([],"media has been created success");
    }

    public function update($id,$request){
        $UserSocial = UserSocialMedia::where(["user_id"=>Auth::id(),"social_media_id" => $id])->first();
        if (!$UserSocial){
            return Response::errorResponse("not found media");
        }

        $UserSocial->update([
            "link" => $request->link
        ]);

        return Response::successResponse([],"media has been updated success");
    }

    public function destroy($id){
        $user = Auth::user();
        $user->UserSocialMedia()->detach($id);
        return Response::successResponse([],"media has been deleted success");
    }


}
