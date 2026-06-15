<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Profile;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Review;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Categories
        $darbs = Category::create(['name' => 'Darbs']);
        $pakalpojumi = Category::create(['name' => 'Pakalpojumi']);
        $remonts = Category::create(['name' => 'Remonts']);
        $dizains = Category::create(['name' => 'Dizains']);
        $programmesana = Category::create(['name' => 'Programmēšana']);

        // Create Users
		$admin = User::create([
			'name'     => 'Admin User',
			'email'    => 'admin@example.com',
			'password' => bcrypt('adminpassword'),
			'role'     => 'admin',
		]);

		$user = User::create([
			'name'     => 'Test User',
			'email'    => 'user@example.com',
			'password' => bcrypt('userpassword'),
			'role'     => 'user',
		]);

		$user2 = User::create([
			'name'     => 'Jānis Bērziņš',
			'email'    => 'janis@example.com',
			'password' => bcrypt('password123'),
			'role'     => 'user',
		]);

		$user3 = User::create([
			'name'     => 'Anna Liepa',
			'email'    => 'anna@example.com',
			'password' => bcrypt('password123'),
			'role'     => 'user',
		]);

        // Create Profiles
        $adminProfile = Profile::create([
            'user_id' => $admin->id,
            'bio' => 'Administratora profils',
            'city' => 'Riga',
        ]);

        $userProfile = Profile::create([
            'user_id' => $user->id,
            'bio' => 'Parasts lietotājs',
            'city' => 'Riga',
        ]);

        $user2Profile = Profile::create([
            'user_id' => $user2->id,
            'bio' => 'Pieredzējis santehniķis ar 10 gadu pieredzi',
            'city' => 'Jelgava',
        ]);

        $user3Profile = Profile::create([
            'user_id' => $user3->id,
            'bio' => 'Grafiskā dizainere un ilustratore',
            'city' => 'Liepāja',
        ]);

        // Create Posts
        $post1 = Post::create([
            'user_id' => $user->id,
            'category_id' => $darbs->id,
            'title' => 'Meklēju santehniķi',
            'description' => 'Nepieciešams salabot virtuves izlietni.',
            'type' => 'service',
            'is_active' => true,
        ]);

        $post2 = Post::create([
            'user_id' => $user2->id,
            'category_id' => $pakalpojumi->id,
            'title' => 'Piedāvāju santehnikas pakalpojumus',
            'description' => 'Veicu santehnikas darbus visā Rīgā un apkārtnē. Ātra un kvalitatīva apkalpošana.',
            'type' => 'offer',
            'is_active' => true,
        ]);

        $post3 = Post::create([
            'user_id' => $user3->id,
            'category_id' => $dizains->id,
            'title' => 'Grafiskā dizaina pakalpojumi',
            'description' => 'Izstrādāju logo, vizītkartes, plakātus un citus dizaina materiālus.',
            'type' => 'offer',
            'is_active' => true,
        ]);

        $post4 = Post::create([
            'user_id' => $admin->id,
            'category_id' => $programmesana->id,
            'title' => 'Meklēju web izstrādātāju',
            'description' => 'Nepieciešams izveidot uzņēmuma mājas lapu ar Laravel.',
            'type' => 'service',
            'is_active' => true,
        ]);

        $post5 = Post::create([
            'user_id' => $user->id,
            'category_id' => $remonts->id,
            'title' => 'Nepieciešams elektriķis',
            'description' => 'Jāveic elektroinstalācijas darbi dzīvoklī.',
            'type' => 'service',
            'is_active' => true,
        ]);

        $post6 = Post::create([
            'user_id' => $user2->id,
            'category_id' => $remonts->id,
            'title' => 'Piedāvāju remonta darbus',
            'description' => 'Veicu dažādus remonta darbus - krāsošana, tapetēšana, flīzēšana.',
            'type' => 'offer',
            'is_active' => false,
        ]);

        // Create Comments
        Comment::create([
            'user_id' => $user2->id,
            'post_id' => $post1->id,
            'content' => 'Sveiki! Es varu palīdzēt ar santehnikas darbiem. Kad būtu ērtāk?',
        ]);

        Comment::create([
            'user_id' => $user->id,
            'post_id' => $post1->id,
            'content' => 'Paldies! Vai varētu šonedēļ?',
        ]);

        Comment::create([
            'user_id' => $admin->id,
            'post_id' => $post2->id,
            'content' => 'Kādi ir jūsu cenu tarifi?',
        ]);

        Comment::create([
            'user_id' => $user2->id,
            'post_id' => $post2->id,
            'content' => 'Cenas atkarīgas no darba apjoma. Varu piedāvāt bezmaksas apskati.',
        ]);

        Comment::create([
            'user_id' => $user->id,
            'post_id' => $post3->id,
            'content' => 'Lieliski darbi! Vai varat parādīt portfolio?',
        ]);

        Comment::create([
            'user_id' => $admin->id,
            'post_id' => $post4->id,
            'content' => 'Projekts joprojām aktuāls, gaidu piedāvājumus!',
        ]);

        // Create Reviews
        Review::create([
            'reviewer_id' => $user->id,
            'user_id' => $user2->id,
            'rating' => 5,
            'content' => 'Izcils santehniķis! Ātri un kvalitatīvi izpildīja darbu. Noteikti ieteikšu citiem.',
        ]);

        Review::create([
            'reviewer_id' => $admin->id,
            'user_id' => $user2->id,
            'rating' => 4,
            'content' => 'Labs speciālists, bet nedaudz kavējās ar termiņiem.',
        ]);

        Review::create([
            'reviewer_id' => $user->id,
            'user_id' => $user3->id,
            'rating' => 5,
            'content' => 'Brīnišķīgs dizains! Anna ir ļoti radoša un profesionāla.',
        ]);

        Review::create([
            'reviewer_id' => $user2->id,
            'user_id' => $user3->id,
            'rating' => 5,
            'content' => 'Izstrādāja logo manam uzņēmumam. Rezultāts pārsniedza cerības!',
        ]);

        Review::create([
            'reviewer_id' => $user3->id,
            'user_id' => $user->id,
            'rating' => 4,
            'content' => 'Patīkama sadarbība, ātri atbild uz ziņām.',
        ]);

        Review::create([
            'reviewer_id' => $user2->id,
            'user_id' => $admin->id,
            'rating' => 5,
            'content' => 'Profesionāla pieeja un skaidra komunikācija.',
        ]);
    }
}