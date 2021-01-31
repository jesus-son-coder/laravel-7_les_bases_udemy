<?php

namespace Database\Seeders;

use App\Models\Category;
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
        $slugify = new Slugify();
        $course->slug = $slugify->slugify($course->title);
        $course->description = "That’s it! Now, if a flash message exists, we just need to print it on the page. Let’s do that in base.html.twig. The session object is available via app.session. Use it to check to see if we have any success flash messages. If we do, let’s print the messages inside a styled container. You’ll typically only have one message at a time, but the flash bag is flexible enough to store any number";
        $course->price = 19.99;
        // Récupérer un Id aléatoire dans la table Category :
        $course->category_id = Category::all()->random(1)->first()->id;
        $course->save();

        $course = new Course();
        $course->title = "Wordpress et création de site ecommerce";
        $course->subtitle = "Construire un site emcommerce complet avec Wordpress";
        $slugify = new Slugify();
        $course->slug = $slugify->slugify($course->title);
        $course->description = "That’s it! Now, if a flash message exists, we just need to print it on the page. Let’s do that in base.html.twig. The session object is available via app.session. Use it to check to see if we have any success flash messages. If we do, let’s print the messages inside a styled container. You’ll typically only have one message at a time, but the flash bag is flexible enough to store any number";
        $course->price = 14.99;
        $course->category_id = Category::all()->random(1)->first()->id;
        $course->save();

        $course = new Course();
        $course->title = "Les bases de Laravel 7";
        $course->subtitle = "Créer une plateforme d'enseignement avec Laravel 7";
        $slugify = new Slugify();
        $course->slug = $slugify->slugify($course->title);
        $course->description = "That’s it! Now, if a flash message exists, we just need to print it on the page. Let’s do that in base.html.twig. The session object is available via app.session. Use it to check to see if we have any success flash messages. If we do, let’s print the messages inside a styled container. You’ll typically only have one message at a time, but the flash bag is flexible enough to store any number";
        $course->price = 39.99;
        $course->category_id = Category::all()->random(1)->first()->id;
        $course->save();
    }
}
