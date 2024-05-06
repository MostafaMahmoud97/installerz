<?php


namespace App\Service\User;


use App\Models\AboutMePage;
use App\Models\InfoAboutMePage;
use App\Models\Media;
use App\Models\SubInfoAboutMePage;
use App\Traits\GeneralFileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AboutMeService
{
    use GeneralFileService;

    public function showAboutMe(){
        $user_id = Auth::id();
        $AboutMe = AboutMePage::with(["media_cover","InfoAboutMe" => function($q){
            $q->with("SubInfo");
        }])->where("user_id",$user_id)->first();

        if (!$AboutMe){
            return Response::errorResponse("not found about me");
        }

        return Response::successResponse($AboutMe,"data has been fetched success");
    }

    public function store($request){
        $user_id = Auth::id();
        $AboutMe = AboutMePage::where("user_id",$user_id)->first();
        if ($AboutMe){
            return Response::errorResponse("you can't add new about me data, please update data");
        }

        $AboutMe = AboutMePage::create([
            "user_id" => $user_id,
            "first_title" => $request->first_title,
            "second_title" => $request->second_title,
            "description" => $request->description
        ]);

        if($request->cover && $request->cover != null){
            $path = "AboutMeCover/";
            $file_name = $this->SaveFile($request->cover,$path);
            $type = $this->getFileType($request->cover);
            Media::create([
                'mediable_type' => $AboutMe->getMorphClass(),
                'mediable_id' => $AboutMe->id,
                'title' => "Cover",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        if($request->info_about_me && count($request->info_about_me) > 0){
            foreach ($request->info_about_me as $info){
                $InfoAboutMe = InfoAboutMePage::create([
                    "about_me_id" => $AboutMe->id,
                    "title" => $info["title"]
                ]);

                if($info["sub_info"] && count($info["sub_info"]) > 0){
                    foreach ($info["sub_info"] as $sub_info){
                        SubInfoAboutMePage::create([
                            "info_about_me_id" => $InfoAboutMe->id,
                            "title" => $sub_info["title"],
                            "description" => $sub_info["description"]
                        ]);
                    }
                }
            }
        }

        return Response::successResponse($AboutMe,"data has been created success");
    }

    public function store_info_about_me($request){
        $user_id = Auth::id();
        $AboutMe = AboutMePage::where("user_id",$user_id)->first();

        if (!$AboutMe){
            return Response::errorResponse("not found about me");
        }

        $Info = InfoAboutMePage::create([
            "about_me_id" => $AboutMe->id,
            "title" => $request->title
        ]);

        foreach ($request->sub_info as $sub_info){
            SubInfoAboutMePage::create([
                "info_about_me_id" => $Info->id,
                "title" => $sub_info["title"],
                "description" => $sub_info["description"]
            ]);
        }

        return Response::successResponse($Info,"data has been created success");

    }

    public function store_sub_info_about_me($request){
        $user_id = Auth::id();
        $AboutMe = AboutMePage::where("user_id",$user_id)->first();

        if (!$AboutMe){
            return Response::errorResponse("not found about me");
        }

        $Info = InfoAboutMePage::where(["about_me_id" => $AboutMe->id])->find($request->info_id);
        if (!$Info){
            return Response::errorResponse("not found info about me");
        }

        foreach ($request->sub_info as $sub_info){
            SubInfoAboutMePage::create([
                "info_about_me_id" => $Info->id,
                "title" => $sub_info["title"],
                "description" => $sub_info["description"]
            ]);
        }

        return Response::successResponse([],"data has been created success");

    }


    public function update_about_me($request){
        $user_id = Auth::id();
        $AboutMe = AboutMePage::where("user_id",$user_id)->first();

        if (!$AboutMe){
            return Response::errorResponse("not found about me");
        }

        $AboutMe->update($request->all());

        if($request->cover && $request->cover != null){

            $cover = $AboutMe->media_cover;
            if ($cover){
                $this->removeFile($cover->file_path);
                $cover->delete();
            }

            $path = "AboutMeCover/";
            $file_name = $this->SaveFile($request->cover,$path);
            $type = $this->getFileType($request->cover);
            Media::create([
                'mediable_type' => $AboutMe->getMorphClass(),
                'mediable_id' => $AboutMe->id,
                'title' => "Cover",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        return Response::successResponse([],"data has been updated success");
    }

    public function update_info_about_me($id,$request){
        $user_id = Auth::id();
        $AboutMe = AboutMePage::where("user_id",$user_id)->first();

        if (!$AboutMe){
            return Response::errorResponse("not found about me");
        }

        $InfoAboutMe = $AboutMe->InfoAboutMe;

        foreach ($InfoAboutMe as $info){
            if($info->id == $id){
                $info->update($request->all());

                return Response::successResponse([],"data has been updated success");
            }
        }

        return Response::errorResponse("not found info about me");

    }

    public function update_sub_info_about_me($id,$request){
        $user_id = Auth::id();
        $AboutMe = AboutMePage::where("user_id",$user_id)->first();

        if (!$AboutMe){
            return Response::errorResponse("not found about me");
        }

        $InfoAboutMe = InfoAboutMePage::with(["SubInfo" => function($q) use ($id){
            $q->where("id",$id);
        }])->where("about_me_id",$AboutMe->id)
            ->whereHas("SubInfo", function ($q) use ($id){
                $q->where("id",$id);
            })->first();

        if (!$InfoAboutMe){
            return Response::errorResponse("not found sub info about me");
        }

        $SubInfo = $InfoAboutMe->SubInfo->first();

        if (!$SubInfo){
            return Response::errorResponse("not found sub info about me");
        }

        $SubInfo->update($request->all());

        return Response::successResponse([],"data has been updated success");
    }

    public function destroy_info_about_me($id){
        $user_id = Auth::id();
        $AboutMe = AboutMePage::where("user_id",$user_id)->first();

        if (!$AboutMe){
            return Response::errorResponse("not found about me");
        }

        $InfoAboutMe = $AboutMe->InfoAboutMe->where("id",$id)->first();

        if (!$InfoAboutMe){
            return Response::errorResponse("not found info about me");
        }

        $SubInfo = $InfoAboutMe->SubInfo;
        foreach ($SubInfo as $item){
            $item->delete();
        }

        $InfoAboutMe->delete();

        return Response::successResponse([],"data has been deleted success");
    }

    public function destroy_sub_info_about_me($id){
        $user_id = Auth::id();
        $AboutMe = AboutMePage::where("user_id",$user_id)->first();

        if (!$AboutMe){
            return Response::errorResponse("not found about me");
        }

        $InfoAboutMe = InfoAboutMePage::with(["SubInfo" => function($q) use ($id){
            $q->where("id",$id);
        }])->where("about_me_id",$AboutMe->id)
            ->whereHas("SubInfo", function ($q) use ($id){
                $q->where("id",$id);
            })->first();

        if (!$InfoAboutMe){
            return Response::errorResponse("not found sub info about me");
        }

        $SubInfo = $InfoAboutMe->SubInfo->first();

        if (!$SubInfo){
            return Response::errorResponse("not found sub info about me");
        }

        $SubInfo->delete();

        return Response::successResponse([],"data has been deleted success");
    }
}
