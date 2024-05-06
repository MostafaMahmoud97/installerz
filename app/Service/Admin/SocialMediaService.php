<?php


namespace App\Service\Admin;


use App\Models\Media;
use App\Models\SocialMedia;
use App\Traits\GeneralFileService;
use Illuminate\Support\Facades\Response;

class SocialMediaService
{
    use GeneralFileService;

    public function index(){
        $SocialMedia = SocialMedia::with("media")->get();
        return Response::successResponse($SocialMedia,"media have been fetched success");
    }

    public function store($request){
        $SocialMedia = SocialMedia::create($request->all());

        if($request->logo && $request->logo != null){
            $path = "SocialMedia/";
            $file_name = $this->SaveFile($request->logo,$path);
            $type = $this->getFileType($request->logo);
            Media::create([
                'mediable_type' => $SocialMedia->getMorphClass(),
                'mediable_id' => $SocialMedia->id,
                'title' => "SocialMedia",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        return Response::successResponse($SocialMedia,"Media has been created success");
    }

    public function show($id){
        $SocialMedia = SocialMedia::with("media")->find($id);
        if (!$SocialMedia){
            return Response::errorResponse("Not found social media");
        }

        return Response::successResponse($SocialMedia,"media has been fetched success");
    }

    public function update($id,$request){
        $SocialMedia = SocialMedia::with("media")->find($id);
        if (!$SocialMedia){
            return Response::errorResponse("Not found social media");
        }

        $SocialMedia->update($request->all());

        if($request->logo && $request->logo != null){
            $media = $SocialMedia->media;
            if($media){
                $this->removeFile($media->file_path);
                $media->delete();
            }

            $path = "SocialMedia/";
            $file_name = $this->SaveFile($request->logo,$path);
            $type = $this->getFileType($request->logo);
            Media::create([
                'mediable_type' => $SocialMedia->getMorphClass(),
                'mediable_id' => $SocialMedia->id,
                'title' => "SocialMedia",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        return Response::successResponse([],"media has been updated success");
    }

    public function destroy($id){
        $SocialMedia = SocialMedia::with("media")->find($id);
        if (!$SocialMedia){
            return Response::errorResponse("Not found social media");
        }

        $media = $SocialMedia->media;
        if ($media){
            $this->removeFile($media->file_path);
            $media->delete();
        }

        $SocialMedia->delete();

        return Response::successResponse([],"media has been deleted success");
    }
}
