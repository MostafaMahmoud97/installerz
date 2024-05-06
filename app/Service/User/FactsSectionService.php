<?php


namespace App\Service\User;


use App\Models\HomePage;
use App\Models\HomePageFact;
use App\Models\Media;
use App\Traits\GeneralFileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class FactsSectionService
{
    use GeneralFileService;

    public function index(){
        $user_id = Auth::id();
        $HomePage = HomePage::with(["FactsSection" => function($q){
            $q->with(["media_icon"]);
        }])->where("user_id",$user_id)->first();
        if (!$HomePage){
            return Response::errorResponse("please enter new home page data first");
        }

        $FactsSection = $HomePage->FactsSection;
        return Response::successResponse($FactsSection,"data has been fetched success");
    }

    public function store($request){
        $user_id = Auth::id();
        $HomePage = HomePage::where("user_id",$user_id)->first();
        if (!$HomePage){
            return Response::errorResponse("please enter new home page data first");
        }

        $FactsSection = HomePageFact::create([
            "home_page_id" => $HomePage->id,
            "number" => $request->number,
            "title" => $request->title
        ]);


        if($request->icon && $request->icon != null){
            $path = "FactsIcon/";
            $file_name = $this->SaveFile($request->icon,$path);
            $type = $this->getFileType($request->icon);
            Media::create([
                'mediable_type' => $FactsSection->getMorphClass(),
                'mediable_id' => $FactsSection->id,
                'title' => "Icon",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        return Response::successResponse($FactsSection,"data has been created success");
    }

    public function show($id){
        $user_id = Auth::id();
        $HomePage = HomePage::where("user_id",$user_id)->first();
        if (!$HomePage){
            return Response::errorResponse("please enter new home page data first");
        }

        $FactsSection = HomePageFact::with(["media_icon"])
            ->where("home_page_id",$HomePage->id)->find($id);

        if (!$FactsSection){
            return Response::errorResponse("Not found data");
        }

        return Response::successResponse($FactsSection,"data has been fetched success");
    }

    public function update($id,$request){
        $user_id = Auth::id();
        $HomePage = HomePage::where("user_id",$user_id)->first();
        if (!$HomePage){
            return Response::errorResponse("please enter new home page data first");
        }

        $FactsSection = HomePageFact::where("home_page_id",$HomePage->id)->find($id);

        if (!$FactsSection){
            return Response::errorResponse("Not found data");
        }

        $FactsSection->update($request->all());

        if($request->icon && $request->icon != null){
            $icon = $FactsSection->media_icon;
            if ($icon){
                $this->removeFile($icon->file_path);
                $icon->delete();
            }

            $path = "FactsIcon/";
            $file_name = $this->SaveFile($request->icon,$path);
            $type = $this->getFileType($request->icon);
            Media::create([
                'mediable_type' => $FactsSection->getMorphClass(),
                'mediable_id' => $FactsSection->id,
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

        $FactsSection = HomePageFact::where("home_page_id",$HomePage->id)->find($id);

        if (!$FactsSection){
            return Response::errorResponse("Not found data");
        }

        $icon = $FactsSection->media_icon;
        if ($icon){
            $this->removeFile($icon->file_path);
            $icon->delete();
        }

        $FactsSection->delete();

        return Response::successResponse([],"data has been deleted success");
    }
}
