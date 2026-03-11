<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Organizer;
use App\Models\Category;
use App\Models\Event;
use App\Models\FavEvent;
use App\Models\AdminUser;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed users
        $user = User::create([
            'email' => 'user1@example.com',
            'password' => Hash::make('password'),
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone_number' => '0123456789',
            'date_of_birth' => '2000-01-01',
        ]);

        // Seed organizers (only in organizers table)
        $organizer = Organizer::create([
            'email' => 'org1@example.com',
            'password' => Hash::make('password'),
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'phone_number' => '0987654321',
            'date_of_birth' => '1995-05-05',
            'organization_name' => 'EventOrg',
        ]);

        // Seed categories
        $cat1 = Category::create(['name' => 'Music']);
        $cat2 = Category::create(['name' => 'Business']);
        $cat3 = Category::create(['name' => 'Technology']);
        $cat4 = Category::create(['name' => 'Conference']);
        $cat5 = Category::create(['name' => 'Workshop']);
        $cat6 = Category::create(['name' => 'Seminar']);
        $cat7 = Category::create(['name' => 'Webinar']);
        $cat8 = Category::create(['name' => 'Sports']);
        $cat9 = Category::create(['name' => 'Education']);
        $cat10 = Category::create(['name' => 'Other']);

        // Seed events
        $event1 = Event::create([
            'organizer_id' => $organizer->organizer_id,
            'title' => 'Music Festival',
            'description' => 'A great music event.',
            'category_id' => $cat1->category_id,
            'start_date' => '2024-08-01',
            'end_date' => '2024-08-02',
            'start_time' => '18:00:00',
            'end_time' => '23:00:00',
            'price' => 0,
            'location' => 'City Hall',
            'link' => 'https://musicfest.com',
            'picture_url' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=800&q=80', // Music
        ]);
        $event2 = Event::create([
            'organizer_id' => $organizer->organizer_id,
            'title' => 'Tech Conference',
            'description' => 'A tech event.',
            'category_id' => $cat3->category_id,
            'start_date' => '2024-09-10',
            'end_date' => '2024-09-12',
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'price' => 50.00,
            'location' => 'Convention Center',
            'link' => 'https://techconf.com',
            'picture_url' => 'https://images.unsplash.com/photo-1515187029135-18ee286d815b?w=800&q=80', // Tech
        ]);

        // Seed favorite events
        FavEvent::create([
            'user_id' => $user->user_id,
            'event_id' => $event1->event_id,
        ]);
        FavEvent::create([
            'user_id' => $user->user_id,
            'event_id' => $event2->event_id,
        ]);

        // Seed user admin
        AdminUser::create([
            'email' => 'admin@example.com',
            'password' => Hash::make('adminpass'),
            'first_name' => 'Admin',
            'last_name' => 'User',
            'phone_number' => '011223344',
            'date_of_birth' => '1984-04-04',
        ]);

        // List of high-quality Unsplash image URLs (Landscape 16:9 ratio for better display)
        $imageUrls = [
            'https://images.unsplash.com/photo-1540575467063-178a5093df99?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&h=450&q=80', // Tech/Conference
            'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&h=450&q=80', // Concert/Crowd
            'https://images.unsplash.com/photo-1511578314322-379afb476865?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&h=450&q=80', // Creative/Workshop
            'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&h=450&q=80', // Party/Social
            'https://images.unsplash.com/photo-1523580494863-6f3031224c94?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&h=450&q=80', // Education/Class
            'https://images.unsplash.com/photo-1505373877841-8d25f7d46678?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&h=450&q=80', // Tech/Coding
            'https://images.unsplash.com/photo-1475721027767-p74302e66b6e?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&h=450&q=80', // Music/Band
            'https://images.unsplash.com/photo-1560439514-e960a3ef5019?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&h=450&q=80', // Business/Meeting
            'https://images.unsplash.com/photo-1529070538774-1843cb3265df?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&h=450&q=80', // Networking
            'https://images.unsplash.com/photo-1531058098628-718b73ef09cd?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&h=450&q=80', // Nightlife
            'https://images.unsplash.com/photo-1524178232363-1fb2b075b955?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&h=450&q=80', // Seminar
            'https://images.unsplash.com/photo-1594122230689-45899d9e6f69?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&h=450&q=80', // Art/Gallery
        ];

        // Seed 20 additional events with random/fake data
        $faker = \Faker\Factory::create();
        $categories = [$cat1->category_id, $cat2->category_id, $cat3->category_id, $cat4->category_id, $cat5->category_id];

        for ($i = 0; $i < 20; $i++) {
            Event::create([
                'organizer_id' => $organizer->organizer_id,
                'title' => $faker->catchPhrase . ' Event',
                'description' => $faker->paragraph,
                'category_id' => $faker->randomElement($categories),
                'start_date' => $faker->dateTimeBetween('+1 days', '+1 year')->format('Y-m-d'),
                'end_date' => $faker->dateTimeBetween('+1 days', '+2 years')->format('Y-m-d'),
                'start_time' => $faker->time('H:i:s'),
                'end_time' => $faker->time('H:i:s'),
                'price' => $faker->randomElement([0, $faker->randomFloat(2, 5, 100)]),
                'location' => $faker->city,
                'link' => $faker->url,
                // Use a random image from our curated list
                'picture_url' => $faker->randomElement($imageUrls),
            ]);
        }
    }
}
