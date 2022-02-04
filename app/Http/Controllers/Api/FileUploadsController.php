<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Upload\ImageUploadRequest;
use App\Http\Requests\Upload\VideoUploadRequest;
use App\Services\FileUploadService;

class FileUploadsController extends Controller
{
    public function image(ImageUploadRequest $request, FileUploadService $service)
    {   
        $url = $service->imageUpload($request, $request->directory);

        return $this->success("Image uploaded successfully.", [
            'url' => $url
        ]);
    }

    public function video(VideoUploadRequest $request, FileUploadService $service)
    {   
        $url = $service->videoUpload($request, $request->directory);

        return $this->success("Video uploaded successfully.", [
            'url' => $url
        ]);
    }
}
