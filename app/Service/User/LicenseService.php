<?php


namespace App\Service\User;


use App\Models\License;
use App\Models\Media;
use App\Traits\GeneralFileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class LicenseService
{
    use GeneralFileService;

    public function show_license(){
        $user_id = Auth::id();
        $License = License::with(["media_workers_comp","media_liability_insurance"])
            ->where("user_id",$user_id)->first();

        if (!$License){
            return Response::errorResponse("not found license");
        }

        return Response::successResponse($License,"License has been fetched success");
    }

    public function store($request){
        $user_id = Auth::id();
        $License = License::where("user_id",$user_id)->first();
        if ($License){
            return Response::errorResponse("you can't add new license data, please update data");
        }

        $License = License::create([
            "user_id" => $user_id,
            "title" => $request->title,
            "license_number" => $request->license_number,
            "description" => $request->description
        ]);

        if($request->workers_comp && $request->workers_comp != null){
            $path = "License/";
            $file_name = $this->SaveFile($request->workers_comp,$path);
            $type = $this->getFileType($request->workers_comp);
            Media::create([
                'mediable_type' => $License->getMorphClass(),
                'mediable_id' => $License->id,
                'title' => "Workers Comp",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        if($request->liability_insurance && $request->liability_insurance != null){
            $path = "License/";
            $file_name = $this->SaveFile($request->liability_insurance,$path);
            $type = $this->getFileType($request->liability_insurance);
            Media::create([
                'mediable_type' => $License->getMorphClass(),
                'mediable_id' => $License->id,
                'title' => "Liability Insurance",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        return Response::successResponse($License,"data has been created success");
    }

    public function update($request){
        $user_id = Auth::id();
        $License = License::where("user_id",$user_id)->first();
        if (!$License){
            return Response::errorResponse("not found license");
        }

        $License->update($request->all());

        if($request->workers_comp && $request->workers_comp != null){

            $workers_comp = $License->media_workers_comp;
            if ($workers_comp){
                $this->removeFile($workers_comp->file_path);
                $workers_comp->delete();
            }

            $path = "License/";
            $file_name = $this->SaveFile($request->workers_comp,$path);
            $type = $this->getFileType($request->workers_comp);
            Media::create([
                'mediable_type' => $License->getMorphClass(),
                'mediable_id' => $License->id,
                'title' => "Workers Comp",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        if($request->liability_insurance && $request->liability_insurance != null){

            $liability_insurance = $License->media_liability_insurance;
            if ($liability_insurance){
                $this->removeFile($liability_insurance->file_path);
                $liability_insurance->delete();
            }

            $path = "License/";
            $file_name = $this->SaveFile($request->liability_insurance,$path);
            $type = $this->getFileType($request->liability_insurance);
            Media::create([
                'mediable_type' => $License->getMorphClass(),
                'mediable_id' => $License->id,
                'title' => "Liability Insurance",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        return Response::successResponse([],"data has been updated success");
    }
}
