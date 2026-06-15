<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Donation;
use App\Models\CampaignUpdate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create categories
        $categories = [
            ['nama' => 'Kesehatan', 'icon' => '🏥', 'warna' => '#dc3545'],
            ['nama' => 'Pendidikan', 'icon' => '📚', 'warna' => '#007bff'],
            ['nama' => 'Bencana Alam', 'icon' => '⛈️', 'warna' => '#ff6b6b'],
            ['nama' => 'Sosial', 'icon' => '🤝', 'warna' => '#198754'],
            ['nama' => 'Lingkungan', 'icon' => '🌱', 'warna' => '#20c997'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => Str::slug($category['nama'])],
                [
                    'nama' => $category['nama'],
                    'deskripsi' => 'Kategori ' . $category['nama'],
                    'icon' => $category['icon'],
                    'warna' => $category['warna'],
                ]
            );
        }

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Peduli',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'status' => 'aktif',
            ]
        );

        // Create fundraiser user
        $fundraiser = User::firstOrCreate(
            ['email' => 'fundraiser@gmail.com'],
            [
                'name' => 'Sahrul Fundraiser',
                'password' => bcrypt('password'),
                'role' => 'fundraiser',
                'status' => 'aktif',
            ]
        );

        // Create donatur user
        $donatur = User::firstOrCreate(
            ['email' => 'donatur@gmail.com'],
            [
                'name' => 'Lopi Donatur',
                'password' => bcrypt('password'),
                'role' => 'donatur',
                'status' => 'aktif',
            ]
        );

        // Create sample campaigns by fundraiser
        $campaigns = Campaign::factory(10)->create([
            'user_id' => $fundraiser->id,
            'category_id' => Category::inRandomOrder()->first()->id,
            'status' => 'aktif',
        ]);

        // Create donations for each campaign by donatur
        foreach ($campaigns as $campaign) {
            Donation::factory(5)->create([
                'campaign_id' => $campaign->id,
                'user_id' => $donatur->id,
                'status' => 'completed',
            ]);

            // Create campaign updates by fundraiser
            CampaignUpdate::factory(2)->create([
                'campaign_id' => $campaign->id,
                'user_id' => $fundraiser->id,
            ]);

            // Update campaign terkumpul
            $totalDonations = $campaign->donations()->where('status', 'completed')->sum('amount');
            $campaign->update(['terkumpul' => $totalDonations]);
        }
    }
}
