<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ImageHandler extends Controller
{
    public static function upload_img($file, $prefix, $folder)
    {
        // upload the image
        $newName = $prefix . "_" . Str::random(20) . "." . $file->getClientOriginalExtension();

        $path = $file->path();
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $response = Http::asMultipart()->post('https://api.cloudinary.com/v1_1/dvcw17rg2/image/upload', [
            'file' => $base64,
            'folder' => "$folder/",
            'public_id' => $newName,
            'timestamp' => now(),
            'api_key' => '593242438967521',
            'upload_preset' => 'nlwbzdep'
        ])->json();

        return [
            'public_id' => $response['public_id'],
            'secure_url' => $response['secure_url']
        ];
    }

    public static function delete_img($file)
    {
        $timestamp = time();
        $signature = sha1("public_id=$file&timestamp=$timestamp" . "8W_O2jLKna5pKOH717JvrJ1-nyo");

        Http::post('https://api.cloudinary.com/v1_1/dvcw17rg2/image/destroy', [
            'public_id' => $file,
            'timestamp' => $timestamp,
            'api_key' => '593242438967521',
            'signature' => $signature
        ]);
    }
}
