<?php

namespace Database\Seeders;

use App\Models\Course;
use Cocur\Slugify\Slugify;
use Illuminate\Database\Seeder;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $course = new Course();
        $course->title = "Les bases de Symfony 4";
        $course->subtitle = "Apprendre à créer un site avec Symfony 4";
        $course->description = "That’s it! Now, if a flash message exists, we just need to print it on the page. Let’s do that in base.html.twig. The session object is available via app.session. Use it to check to see if we have any success flash messages. If we do, let’s print the messages inside a styled container. You’ll typically only have one message at a time, but the flash bag is flexible enough to store any number";
        $course->price = 19.99;

        $slugify = new Slugify();
        $course->slug = $slugify->slugify($course->title);

        $course->save();
    }
}
