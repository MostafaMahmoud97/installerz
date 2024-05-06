<?php


namespace App\Service\User;


use App\Models\HomePage;
use App\Models\HomePageStandOut;
use App\Models\Media;
use App\Traits\GeneralFileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class StandOutSectionService
{
    use GeneralFileService;

    public function index(){
        $user_id = Auth::id();
        $HomePage = HomePage::with(["StandOutSection" => function($q){
            $q->with(["media_cover","media_icon"]);
        }])->where("user_id",$user_id)->first();
        if (!$HomePage){
            return Response::errorResponse("please enter new home page data first");
        }

        $StandOuts = $HomePage->StandOutSection;
        return Response::successResponse($StandOuts,"data has been fetched success");
    }

    public function store($request){
        $user_id = Auth::id();
        $HomePage = HomePage::where("user_id",$user_id)->first();
        if (!$HomePage){
            return Response::errorResponse("please enter new home page data first");
        }

        $StandOut = HomePageStandOut::create([
            "home_page_id" => $HomePage->id,
            "title" => $request->title,
            "description" => $request->description
        ]);

        if($request->cover && $request->cover != null){
            $path = "StandOutCover/";
            $file_name = $this->SaveFile($request->cover,$path);
            $type = $this->getFileType($request->cover);
            Media::create([
                'mediable_type' => $StandOut->getMorphClass(),
                'mediable_id' => $StandOut->id,
                'title' => "Cover",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        if($request->icon && $request->icon != null){
            $path = "StandOutIcon/";
            $file_name = $this->SaveFile($request->icon,$path);
            $type = $this->getFileType($request->icon);
            Media::create([
                'mediable_type' => $StandOut->getMorphClass(),
                'mediable_id' => $StandOut->id,
                'title' => "Icon",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        return Response::successResponse($StandOut,"data has been created success");
    }

    public function show($id){
        $user_id = Auth::id();
        $HomePage = HomePage::where("user_id",$user_id)->first();
        if (!$HomePage){
            return Response::errorResponse("please enter new home page data first");
        }

        $StandOut = HomePageStandOut::with(["media_cover","media_icon"])
            ->where("home_page_id",$HomePage->id)->find($id);

        if (!$StandOut){
            return Response::errorResponse("Not found data");
        }

        return Response::successResponse($StandOut,"data has been fetched success");
    }

    public function update($id,$request){
        $user_id = Auth::id();
        $HomePage = HomePage::where("user_id",$user_id)->first();
        if (!$HomePage){
            return Response::errorResponse("please enter new home page data first");
        }

        $StandOut = HomePageStandOut::where("home_page_id",$HomePage->id)->find($id);

        if (!$StandOut){
            return Response::errorResponse("Not found data");
        }

        $StandOut->update($request->all());

        if($request->cover && $request->cover != null){

            $cover = $StandOut->media_cover;
            if ($cover){
                $this->removeFile($cover->file_path);
                $cover->delete();
            }

            $path = "StandOutCover/";
            $file_name = $this->SaveFile($request->cover,$path);
            $type = $this->getFileType($request->cover);
            Media::create([
                'mediable_type' => $StandOut->getMorphClass(),
                'mediable_id' => $StandOut->id,
                'title' => "Cover",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        if($request->icon && $request->icon != null){
            $icon = $StandOut->media_icon;
            if ($icon){
                $this->removeFile($icon->file_path);
                $icon->delete();
            }

            $path = "StandOutIcon/";
            $file_name = $this->SaveFile($request->icon,$path);
            $type = $this->getFileType($request->icon);
            Media::create([
                'mediable_type' => $StandOut->getMorphClass(),
                'mediable_id' => $StandOut->id,
                'title' => "Icon",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        return Response::successResponse([],"data has been updated success");
    }

    public function destroy($id){
        $user_id = Auth::id();
        $HomePage = HomePage::where("user_id",$user_id)->first();
        if (!$HomePage){
            return Response::errorResponse("please enter new home page data first");
        }

        $StandOut = HomePageStandOut::where("home_page_id",$HomePage->id)->find($id);

        if (!$StandOut){
            return Response::errorResponse("Not found data");
        }

        $cover = $StandOut->media_cover;
        if ($cover){
            $this->removeFile($cover->file_path);
            $cover->delete();
        }

        $icon = $StandOut->media_icon;
        if ($icon){
            $this->removeFile($icon->file_path);
            $icon->delete();
        }

        $StandOut->delete();

        return Response::successResponse([],"data has been deleted success");
    }

}
