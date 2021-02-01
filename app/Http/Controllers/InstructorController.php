<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Cocur\Slugify\Slugify;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class InstructorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('instructor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('instructor.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $course = new Course();
        $course->title = $request->input('title');
        $course->subtitle = $request->input('subtitle');
        $course->description = $request->input('description');

        $slugify = new Slugify();
        $course->slug = $slugify->slugify($course->title);

        $course->category_id = $request->input('category');
        $course->user_id = Auth::user()->id;

        /* ********************************************************** */
        /*           Traitement du stockage de l'image                */
        /* ********************************************************** */

        // Récupérer l'objet image :
        $image = $request->file('image');

        // Otenir le nom de l'image (sans le chemin) :
        $imageFullName = $image->getClientOriginalName();

        // Obtenir le nom de l'image sans son extension :
        $imageName = pathinfo($imageFullName, PATHINFO_FILENAME);

        // Récupérer l'extension de l'image :
        $extension = $image->getClientOriginalExtension();

        $file = time() . '_' . $imageName . '.' . $extension;

        $image->storeAs('public/courses/' . Auth::user()->id, $file);

        $course->image = $file;

        $course->save();

        return redirect()->route('instructor.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = Course::find($id);
        $categories = Category::all();

        return view('instructor.edit', [
            'course' => $course,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $course = Course::find($id);

        $course->title = $request->input('title');
        $course->subtitle = $request->input('subtitle');
        $course->description = $request->input('description');

        $slugify = new Slugify();
        $course->slug = $slugify->slugify($course->title);

        $course->category_id = $request->input('category');

        if($request->file('image')) {
            $image = $request->file('image');

            // Otenir le nom de l'image (sans le chemin) :
            $imageFullName = $image->getClientOriginalName();

            // Obtenir le nom de l'image sans son extension :
            $imageName = pathinfo($imageFullName, PATHINFO_FILENAME);

            // Récupérer l'extension de l'image :
            $extension = $image->getClientOriginalExtension();

            $file = time() . '_' . $imageName . '.' . $extension;

            $image->storeAs('public/courses/' . Auth::user()->id, $file);

            $course->image = $file;
        }

        $course->save();

        return redirect()->route('instructor.index')->with('success', "Vos modifications ont été enregistrées avec succès !");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::find($id);
        $course->delete();
        return redirect()->route('instructor.index')->with('success', "Le cours a bien été supprimé !");
    }

    public function publish($id)
    {
        $course = Course::find($id);

        // Quelques vérifications avant de passer le cours à l'état "publié" :
        if($course->price && count($course->sections) > 0) {
            $course->is_published = true;
            $course->save();
            return redirect()->back()->with('success', "Votre cours est maintenant en ligne !");
        }

        return redirect()->back()->with('danger', "Votre cours doit avoir un tarif défini, ainsi qu'au moins une section vidéo avant d'être publié !");
    }
}
