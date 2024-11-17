<?php

use App\Model\Article;
use App\Model\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Tag::class, 20)->create();

        // Get all the roles attaching up to 3 random tags to each article
        $tags = Tag::all();

        // Populate the pivot table
        Article::all()->where('type', 'posts')->each(function ($articles) use ($tags) {
            $articles->tag()->attach(
                $tags->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
