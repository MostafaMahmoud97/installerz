<?php


namespace App\Service\Guest;


use App\Models\Job;
use App\Models\Media;
use App\Models\User;
use App\Traits\GeneralFileService;
use Illuminate\Support\Facades\Response;

class JobService
{
    use GeneralFileService;

    public function submit_job($request){
        $user = User::find($request->user_id);
        if($user->is_publish != 1){
            return Response::errorResponse("You can't submit job now");
        }

        $Job = Job::create($request->all());


        if($request->site_survey_file && $request->site_survey_file != null){
            $path = "Job/";
            $file_name = $this->SaveFile($request->site_survey_file,$path);
            $type = $this->getFileType($request->site_survey_file);
            Media::create([
                'mediable_type' => $Job->getMorphClass(),
                'mediable_id' => $Job->id,
                'title' => "Site Survey",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        if($request->design_needed_file && $request->design_needed_file != null){
            $path = "Job/";
            $file_name = $this->SaveFile($request->design_needed_file,$path);
            $type = $this->getFileType($request->design_needed_file);
            Media::create([
                'mediable_type' => $Job->getMorphClass(),
                'mediable_id' => $Job->id,
                'title' => "Design Needed",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        return Response::successResponse([],"job has been sent successfully");
    }
}
