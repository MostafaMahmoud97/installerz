<?php


namespace App\Service\User;


use App\Models\Media;
use App\Models\OurTeam;
use App\Models\User;
use App\Traits\GeneralFileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class OurTeamService
{
    use GeneralFileService;

    public function index(){
        $user_id = Auth::id();
        $User = User::with(["OurTeams" => function($q){
            $q->with("media_cover");
        }])->find($user_id);

        $Team = $User->OurTeams;
        return Response::successResponse($Team,"data has been fetched success");
    }

    public function store($request){
        $user_id = Auth::id();
        $OurTeam = OurTeam::create([
            "user_id" => $user_id,
            "name" => $request->name,
            "position" => $request->position,
            "description" => $request->description
        ]);

        if($request->cover && $request->cover != null){
            $path = "OurTeamCover/";
            $file_name = $this->SaveFile($request->cover,$path);
            $type = $this->getFileType($request->cover);
            Media::create([
                'mediable_type' => $OurTeam->getMorphClass(),
                'mediable_id' => $OurTeam->id,
                'title' => "Cover",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        return Response::successResponse($OurTeam,"data has been created success");
    }

    public function show($id){
        $user_id = Auth::id();
        $OurTeam = OurTeam::with("media_cover")
            ->where("user_id",$user_id)->find($id);

        if (!$OurTeam){
            return Response::errorResponse("Not found any member");
        }

        return Response::successResponse($OurTeam,"data has been fetched success");
    }

    public function update($id,$request){
        $user_id = Auth::id();
        $OurTeam = OurTeam::with("media_cover")
            ->where("user_id",$user_id)->find($id);

        if (!$OurTeam){
            return Response::errorResponse("Not found any member");
        }

        $OurTeam->update($request->all());

        if($request->cover && $request->cover != null){

            $cover = $OurTeam->media_cover;
            if ($cover){
                $this->removeFile($cover->file_path);
                $cover->delete();
            }

            $path = "OurTeamCover/";
            $file_name = $this->SaveFile($request->cover,$path);
            $type = $this->getFileType($request->cover);
            Media::create([
                'mediable_type' => $OurTeam->getMorphClass(),
                'mediable_id' => $OurTeam->id,
                'title' => "Cover",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        return Response::successResponse([],"data has been updated success");
    }

    public function destroy($id){
        $user_id = Auth::id();
        $OurTeam = OurTeam::with("media_cover")
            ->where("user_id",$user_id)->find($id);

        if (!$OurTeam){
            return Response::errorResponse("Not found any member");
        }

        $cover = $OurTeam->media_cover;
        if ($cover){
            $this->removeFile($cover->file_path);
            $cover->delete();
        }

        $OurTeam->delete();

        return Response::successResponse([],"data has been deleted success");

    }
}
