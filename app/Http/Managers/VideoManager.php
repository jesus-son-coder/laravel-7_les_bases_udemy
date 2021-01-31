<?php

namespace App\Http\Managers;

use Illuminate\Support\Facades\Auth;

class VideoManager
{
    public function videoStorage($video)
    {
        // Traitement d'une video :
        // ------------------------
        $fileFullname = $video->getClientOriginalName();
        $filename = pathinfo($fileFullname, PATHINFO_FILENAME);
        $extension = $video->getClientOriginalExtension();
        $file = time() . '_' . $filename . "." . $extension;
        $video->storeAs('public/courses_sections/' . Auth::user()->id, $file);
        return $file;
    }
}
