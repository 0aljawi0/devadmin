<?php

namespace App\Traits;

use Storage;
use Image;

trait UploadImage
{
    public static function upload($image, $editor = false, $returnJustName = false, $thumbnail = true, $width = 200, $height = 200)
    {
        //get filename with extension
        $filenamewithextension = $image->getClientOriginalName();

        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

        //get file extension
        $extension = $image->getClientOriginalExtension();

        //fixed time
        $s_time = time();

        //filename Original
        $filenametostore = $filename . '_' . $s_time . '.' . $extension;

        // Store Original
        // $image->store('images/'.$filenametostore, 'public_html');
        if ($editor) Storage::disk('public_html')->putFileAs('editor/', $image, $filenametostore);
        else Storage::disk('public_html')->putFileAs('images/', $image, $filenametostore);

        if ($thumbnail) {
            $filenamethumb = $filename . '_' . $s_time . '.' . $extension;
            // $image->store('images/thumbnail/'.$filenamethumb, 'public_html');
            Storage::disk('public_html')->putFileAs('thumbnail/', $image, $filenamethumb);

            $path = getcwd() . '/storage/thumbnail/' . $filenamethumb;

            $img = Image::make($path);

            $imgPixelSize = $img->width() . ' x ' . $img->height() . ' pixel';
            $imgFileSize = $img->filesize();

            $w = $width;
            $h = $height;

            $img->width() > $img->height() ? $w = null : $h = null;
            $img->resize($w, $h, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });

            $img->resizeCanvas($width, $height, 'center', false, array(255, 255, 255, 1));

            $img->save($path);
        }

        if ($returnJustName) {
            return $filenametostore;
        } else {
            $data = [
                'title' => $filename,
                'pixel' => $imgPixelSize,
                'size' => $imgFileSize,
                'type' => $extension,
                'image' => $filenametostore
            ];

            return $data;
        }
    }

    public static function delete($image, $thumbnail = true)
    {
        Storage::disk('public_html')->delete('images/' . $image);

        if ($thumbnail) {
            Storage::disk('public_html')->delete('thumbnail/' . $image);
        }
    }
}
