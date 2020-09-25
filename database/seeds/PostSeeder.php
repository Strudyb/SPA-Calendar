<?php

use Carbon\Carbon;
use Faker\Factory;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $path =  base_path().'/resources/views/pages';
        $files = File::allFiles($path);


        app()->setLocale('en');

        foreach ($files as $key => $value) {
            $fileName = substr($value->getFileName(),0,-10);
            Post::create(
                [
               'title' => $fileName,
               'user_id' => User::where('role','admin')->first()->id,
               'content' =>  'Page Info',
               'status' => 1,
               'type' => 'page',
               'seo_title' =>   'Seo Title',
               'seo_description' => 'Seo Description',
               'created_at' => Carbon::now(),
           ]
             
       );
  }



       // Post::factory(10)->create();
        //factory(Post::class, 100)->create();
    }
}
