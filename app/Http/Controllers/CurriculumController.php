<?php

namespace App\Http\Controllers;

use App\Http\Managers\VideoManager;
use App\Models\Course;
use App\Models\Section;
use Cocur\Slugify\Slugify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CurriculumController extends Controller
{
    protected $videoManager;

    public function __construct(VideoManager $videoManager)
    {
        $this->videoManager = $videoManager;
    }

    public function index($id)
    {
        $course = Course::find($id);

        return view('instructor.curriculum.index',[
            'course' => $course
        ]);
    }

    public function create($id)
    {
        $course = Course::find($id);
        return view('instructor.curriculum.create', [
            'course' => $course
        ]);
    }

    public function store(Request $request, $id)
    {
        $course = Course::find($id);

        $section = new Section();
        $section->name = $request->input('section_name');

        $slugify = new Slugify();
        $section->slug = $slugify->slugify($section->name);

        $section->course_id = $id;

        // Traitement de la video :
        // ------------------------
        $video = $request->file('section_video');
        $videoFile = $this->videoManager->videoStorage($video);
        $section->video = $videoFile;

        // Calcul du Temps de la video :
        // -----------------------------
        $playtime = $this->videoManager->getVideoDuration($videoFile);
        $section->playtime_seconds = $playtime;

        $section->save();

        return redirect()->route('instructor.curriculum.index', $course->id);

    }

    public function edit($id, $sectionId)
    {
        $course = Course::find($id);
        $section = Section::find($sectionId);

        return view('instructor.curriculum.edit', [
            'course' => $course,
            'section' => $section
        ]);
    }

    public function update(Request $request, $id, $sectionId)
    {
        $course = Course::find($id);
        $section = Section::find($sectionId);
        $slugify = new Slugify();

        if($request->input('section_name')){
            $section->name = $request->input('section_name');
            $section->slug = $slugify->slugify($section->name);
        }

        if($request->file('section_video')) {
            // Traitement de la video :
            // ------------------------
            $video = $request->file('section_video');
            $videoFile = $this->videoManager->videoStorage($video);
            $section->video = $videoFile;

            // Calcul du Temps de la video :
            // -----------------------------
            $playtime = $this->videoManager->getVideoDuration($videoFile);
            $section->playtime_seconds = $playtime;
        }

        $section->save();

        return redirect()->route('instructor.curriculum.index', $course->id)->with('success', 'La section a bien été modifiée !');

    }

    public function destroy($id, $sectionId)
    {
        $course = Course::find($id);
        $section = Section::find($sectionId);

        // Supression de la video :
        $fileToDelete = 'public/courses_sections/' . Auth::user()->id . '/' . $section->video;
        if(Storage::exists($fileToDelete)) {
            Storage::delete($fileToDelete); 
        }

        $section->delete();

        return redirect()->route('instructor.curriculum.index', [
            'id' => $course->id
        ])->with('success', "La section a bien été supprimée !");
    }
}
