<?php


namespace App\Service\User;


use App\Models\Media;
use App\Models\Project;
use App\Traits\GeneralFileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ProjectService
{
    use GeneralFileService;

    public function index($request){
        $Projects = Project::with("media_thumbnail")
            ->where("user_id",Auth::id())
            ->where("address","like","%".$request->search."%")->get();

        return Response::successResponse($Projects,"projects have been fetched success");
    }

    public function store($request){
        $user_id = Auth::id();

        $Project = Project::create([
            "user_id" => $user_id,
            "address" => $request->address,
            "type" => $request->type,
            "date" => $request->date,
        ]);

        if($request->thumbnail && $request->thumbnail != null){
            $path = "ProjectImages/";
            $file_name = $this->SaveFile($request->thumbnail,$path);
            $type = $this->getFileType($request->thumbnail);
            Media::create([
                'mediable_type' => $Project->getMorphClass(),
                'mediable_id' => $Project->id,
                'title' => "Thumbnail",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        if($request->gallery && $request->gallery != null && count($request->gallery) > 0){
            $path = "ProjectImages/";
            foreach ($request->gallery as $item){
                $file_name = $this->SaveFile($item,$path);
                $type = $this->getFileType($item);
                Media::create([
                    'mediable_type' => $Project->getMorphClass(),
                    'mediable_id' => $Project->id,
                    'title' => "Gallery",
                    'type' => $type,
                    'directory' => $path,
                    'filename' => $file_name
                ]);
            }
        }

        return Response::successResponse($Project,"data has been created success");
    }

    public function store_gallery($request){
        $Project = Project::where("user_id",Auth::id())->find($request->project_id);

        if (!$Project){
            return Response::errorResponse("not found project");
        }

        if ($Project->gallery && $Project->gallery != null){
            $path = "ProjectImages/";
            $file_name = $this->SaveFile($request->gallery,$path);
            $type = $this->getFileType($request->gallery);
            Media::create([
                'mediable_type' => $Project->getMorphClass(),
                'mediable_id' => $Project->id,
                'title' => "Gallery",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        return Response::successResponse([],"data has been created success");
    }

    public function show($id){
        $Project = Project::with(["media_thumbnail","media_gallery"])
            ->where("user_id",Auth::id())->find($id);

        if (!$Project){
            return Response::errorResponse("not found project");
        }

        return Response::successResponse($Project,"data has been fetched success");
    }

    public function update($id,$request){
        $Project = Project::where("user_id",Auth::id())->find($id);

        if (!$Project){
            return Response::errorResponse("not found project");
        }

        $Project->update($request->all());

        if($request->thumbnail && $request->thumbnail != null){
            $thumbnail = $Project->media_thumbnail;
            if ($thumbnail){
                $this->removeFile($thumbnail->file_path);
                $thumbnail->delete();
            }

            $path = "ProjectImages/";
            $file_name = $this->SaveFile($request->thumbnail,$path);
            $type = $this->getFileType($request->thumbnail);
            Media::create([
                'mediable_type' => $Project->getMorphClass(),
                'mediable_id' => $Project->id,
                'title' => "Thumbnail",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        return Response::successResponse([],"project has been updated success");
    }

    public function destroy($id){
        $Project = Project::where("user_id",Auth::id())->find($id);

        if (!$Project){
            return Response::errorResponse("not found project");
        }

        $thumbnail = $Project->media_thumbnail;
        if ($thumbnail){
            $this->removeFile($thumbnail->file_path);
            $thumbnail->delete();
        }

        $gallery = $Project->media_gallery;

        foreach ($gallery as $item){
            $this->removeFile($item->file_path);
            $item->delete();
        }

        $Project->delete();

        return Response::successResponse([],"data has been deleted");
    }

    public function destroy_gallery($request){
        $Project = Project::where("user_id",Auth::id())->find($request->project_id);

        if (!$Project){
            return Response::errorResponse("not found project");
        }

        $gallery = $Project->media_gallery;
        foreach ($gallery as $item){
            if($item->id == $request->gallery_id){
                $this->removeFile($item->file_path);
                $item->delete();

                return Response::successResponse([],"image has been deleted success");
            }
        }

        return Response::errorResponse("not found image");
    }
}
