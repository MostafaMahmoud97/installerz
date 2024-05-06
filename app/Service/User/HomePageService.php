<?php


namespace App\Service\User;


use App\Models\HomePage;
use App\Models\Media;
use App\Models\User;
use App\Traits\GeneralFileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class HomePageService
{
    use GeneralFileService;

    public function showHomePage(){
        $user_id = Auth::id();
        $User = User::with(["HomePage" => function($q){
            $q->with(["media_cover","media_info_cover","media_benefits_cover"]);
        }])->find($user_id);

        return Response::successResponse($User->HomePage,"data has been fetched success");
    }

    public function store($request){
        $user_id = Auth::id();
        $HomePage = HomePage::where("user_id",$user_id)->first();
        if ($HomePage){
            return Response::errorResponse("you can't add new home page data, please update data");
        }

        $HomePage = HomePage::create([
            "user_id" => $user_id,
            "first_title" => $request->first_title,
            "second_title" => $request->second_title,
            "third_title" => $request->third_title,
            "info_title" => $request->info_title,
            "info_description" => $request->info_description,
            "benefits_title" => $request->benefits_title,
            "benefits_description" => $request->benefits_description
        ]);

        if($request->cover && $request->cover != null){
            $path = "HomePageCover/";
            $file_name = $this->SaveFile($request->cover,$path);
            $type = $this->getFileType($request->cover);
            Media::create([
                'mediable_type' => $HomePage->getMorphClass(),
                'mediable_id' => $HomePage->id,
                'title' => "Cover",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        if($request->info_cover && $request->info_cover != null){
            $path = "HomePageInfoCover/";
            $file_name = $this->SaveFile($request->info_cover,$path);
            $type = $this->getFileType($request->info_cover);
            Media::create([
                'mediable_type' => $HomePage->getMorphClass(),
                'mediable_id' => $HomePage->id,
                'title' => "InfoCover",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        if($request->benefits_cover && $request->benefits_cover != null){
            $path = "HomePageBenefitsCover/";
            $file_name = $this->SaveFile($request->benefits_cover,$path);
            $type = $this->getFileType($request->benefits_cover);
            Media::create([
                'mediable_type' => $HomePage->getMorphClass(),
                'mediable_id' => $HomePage->id,
                'title' => "BenefitsCover",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        return Response::successResponse($HomePage,"home page has been created success");
    }

    public function update($request){
        $user_id = Auth::id();
        $HomePage = HomePage::where("user_id",$user_id)->first();
        if (!$HomePage){
            return Response::errorResponse("please enter new home page data");
        }

        $HomePage->update($request->all());

        if($request->cover && $request->cover != null){

            $cover = $HomePage->media_cover;
            if ($cover){
                $this->removeFile($cover->file_path);
                $cover->delete();
            }

            $path = "HomePageCover/";
            $file_name = $this->SaveFile($request->cover,$path);
            $type = $this->getFileType($request->cover);
            Media::create([
                'mediable_type' => $HomePage->getMorphClass(),
                'mediable_id' => $HomePage->id,
                'title' => "Cover",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        if($request->info_cover && $request->info_cover != null){

            $info_cover = $HomePage->media_info_cover;
            if ($info_cover){
                $this->removeFile($info_cover->file_path);
                $info_cover->delete();
            }

            $path = "HomePageInfoCover/";
            $file_name = $this->SaveFile($request->info_cover,$path);
            $type = $this->getFileType($request->info_cover);
            Media::create([
                'mediable_type' => $HomePage->getMorphClass(),
                'mediable_id' => $HomePage->id,
                'title' => "InfoCover",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        if($request->benefits_cover && $request->benefits_cover != null){
            $benefits_cover = $HomePage->media_benefits_cover;
            if ($benefits_cover){
                $this->removeFile($benefits_cover->file_path);
                $benefits_cover->delete();
            }

            $path = "HomePageBenefitsCover/";
            $file_name = $this->SaveFile($request->benefits_cover,$path);
            $type = $this->getFileType($request->benefits_cover);
            Media::create([
                'mediable_type' => $HomePage->getMorphClass(),
                'mediable_id' => $HomePage->id,
                'title' => "BenefitsCover",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        return Response::successResponse($HomePage,"home page has been updated success");
    }


}
