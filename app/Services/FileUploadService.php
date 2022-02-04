<?php

namespace App\Traits\Upload;

use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public function imageUpload($request, string $key, string $pathToStore): string
    {
        $path = '';
        
        if ($request->hasFile($key))
        {
            $file = $request->file($key);

            $originalFilename = $file->getClientOriginalName();
            $fileName = pathinfo($originalFilename, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();

            $newFileName = "$fileName-". time() . ".$extension";
            $path = $pathToStore . $newFileName;

            Storage::disk('local')->put($path, $file);
        }

        return Storage::url($path);
    }

    public function videoUpload($request, string $key, string $pathToStore): string
    {
        $path = '';
        
        if ($request->hasFile($key))
        {
            $file = $request->file($key);

            $originalFilename = $file->getClientOriginalName();
            $fileName = pathinfo($originalFilename, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();

            $newFileName = "$fileName-" . time() . ".${extension}";
            $path = $pathToStore . $newFileName;

            Storage::disk('local')->put($path, $file);
        }

        return Storage::url($path);
    }
}