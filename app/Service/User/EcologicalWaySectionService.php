<?php


namespace App\Service\User;


use App\Models\HomePage;
use App\Models\HomePageEcologicalWay;
use App\Models\Media;
use App\Traits\GeneralFileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class EcologicalWaySectionService
{
    use GeneralFileService;

    public function index(){
        $user_id = Auth::id();
        $HomePage = HomePage::with(["EcologicalSection" => function($q){
            $q->with(["media_icon"]);
        }])->where("user_id",$user_id)->first();
        if (!$HomePage){
            return Response::errorResponse("please enter new home page data first");
        }

        $EcologicalSection = $HomePage->EcologicalSection;
        return Response::successResponse($EcologicalSection,"data has been fetched success");
    }

    public function store($request){
        $user_id = Auth::id();
        $HomePage = HomePage::where("user_id",$user_id)->first();
        if (!$HomePage){
            return Response::errorResponse("please enter new home page data first");
        }

        $EcologicalSection = HomePageEcologicalWay::create([
            "home_page_id" => $HomePage->id,
            "title" => $request->title,
            "description" => $request->description
        ]);


        if($request->icon && $request->icon != null){
            $path = "EcologicalIcon/";
            $file_name = $this->SaveFile($request->icon,$path);
            $type = $this->getFileType($request->icon);
            Media::create([
                'mediable_type' => $EcologicalSection->getMorphClass(),
                'mediable_id' => $EcologicalSection->id,
                'title' => "Icon",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        return Response::successResponse($EcologicalSection,"data has been created success");
    }

    public function show($id){
        $user_id = Auth::id();
        $HomePage = HomePage::where("user_id",$user_id)->first();
        if (!$HomePage){
            return Response::errorResponse("please enter new home page data first");
        }

        $EcologicalSection = HomePageEcologicalWay::with(["media_icon"])
            ->where("home_page_id",$HomePage->id)->find($id);

        if (!$EcologicalSection){
            return Response::errorResponse("Not found data");
        }

        return Response::successResponse($EcologicalSection,"data has been fetched success");
    }

    public function update($id,$request){
        $user_id = Auth::id();
        $HomePage = HomePage::where("user_id",$user_id)->first();
        if (!$HomePage){
            return Response::errorResponse("please enter new home page data first");
        }

        $EcologicalSection = HomePageEcologicalWay::where("home_page_id",$HomePage->id)->find($id);

        if (!$EcologicalSection){
            return Response::errorResponse("Not found data");
        }

        $EcologicalSection->update($request->all());


        if($request->icon && $request->icon != null){
            $icon = $EcologicalSection->media_icon;
            if ($icon){
                $this->removeFile($icon->file_path);
                $icon->delete();
            }

            $path = "EcologicalIcon/";
            $file_name = $this->SaveFile($request->icon,$path);
            $type = $this->getFileType($request->icon);
            Media::create([
                'mediable_type' => $EcologicalSection->getMorphClass(),
                'mediable_id' => $EcologicalSection->id,
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

        $EcologicalSection = HomePageEcologicalWay::where("home_page_id",$HomePage->id)->find($id);

        if (!$EcologicalSection){
            return Response::errorResponse("Not found data");
        }

        $icon = $EcologicalSection->media_icon;
        if ($icon){
            $this->removeFile($icon->file_path);
            $icon->delete();
        }

        $EcologicalSection->delete();

        return Response::successResponse([],"data has been deleted success");
    }
}
