<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ImageHandler extends Controller
{
    public static function upload_img($file, $prefix, $folder)
    {
        // upload the image
        $newName = $prefix . "_" . Str::random(20) . "." . $file->getClientOriginalExtension();
        $destinationPath = public_path('/' . $folder);
        $file->move($destinationPath, $newName);

        return $newName;
    }

    public static function delete_img($file, $folder)
    {
        // remove image
        $image_path = public_path('/' . $folder . '/') . $file;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }
}
