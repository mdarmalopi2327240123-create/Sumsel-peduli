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

        // Create sample campaigns by fundraiser without depending on Faker
        $indonesianCampaigns = [
            [
                'judul' => 'Bantu Pengobatan Ade Irma Penderita Kelainan Jantung',
                'deskripsi' => 'Ade Irma (5 tahun) membutuhkan biaya operasi kelainan katup jantung segera di RSUD setempat. Mari ringankan beban keluarganya.',
                'kategori' => 'Kesehatan'
            ],
            [
                'judul' => 'Renovasi Jembatan Putus Penghubung Desa Tertinggal',
                'deskripsi' => 'Akses utama anak-anak sekolah terputus akibat banjir bandang. Mari bantu bangun kembali jembatan kokoh untuk keselamatan mereka.',
                'kategori' => 'Bencana Alam'
            ],
            [
                'judul' => 'Beasiswa Pendidikan Anak Yatim & Dhuafa Sumsel',
                'deskripsi' => 'Membantu biaya SPP dan perlengkapan sekolah anak-anak yatim agar tidak putus sekolah dan bisa meraih cita-cita mereka.',
                'kategori' => 'Pendidikan'
            ],
            [
                'judul' => 'Paket Sembako Murah untuk Lansia Terlantar',
                'deskripsi' => 'Penyaluran paket bahan pokok bagi lansia kurang mampu di wilayah perkampungan kumuh Sumatera Selatan.',
                'kategori' => 'Sosial'
            ],
            [
                'judul' => 'Gerakan Penanaman 1000 Mangrove di Pesisir Sumsel',
                'deskripsi' => 'Mencegah abrasi pantai dan melestarikan ekosistem laut dengan menanam pohon mangrove bersama relawan lingkungan.',
                'kategori' => 'Lingkungan'
            ],
            [
                'judul' => 'Bantuan Alat Dengar untuk Anak Tuna Rungu',
                'deskripsi' => 'Bantu anak-anak tuna rungu kurang mampu agar dapat mendengar suara indahnya dunia dan bersekolah dengan normal.',
                'kategori' => 'Kesehatan'
            ],
            [
                'judul' => 'Penyediaan Air Bersih Desa Kekeringan',
                'deskripsi' => 'Membangun sumur bor dan instalasi filter air bersih untuk warga desa yang terdampak kekeringan panjang.',
                'kategori' => 'Bencana Alam'
            ],
            [
                'judul' => 'Pengadaan Ambulans Gratis Layanan Umat',
                'deskripsi' => 'Membeli unit ambulans untuk melayani rujukan medis darurat warga miskin secara gratis 24 jam.',
                'kategori' => 'Kesehatan'
            ]
        ];

        $donaturNames = ['Budi', 'Siti', 'Joko', 'Rina', 'Andi', 'Dewi', 'Hendra', 'Mega'];
        $paymentMethods = ['Transfer Bank', 'E-Wallet', 'Kartu Kredit'];

        foreach ($indonesianCampaigns as $item) {
            $target = rand(5000000, 100000000);
            
            $campaign = Campaign::create([
                'user_id' => $fundraiser->id,
                'category_id' => Category::inRandomOrder()->first()->id,
                'judul' => $item['judul'],
                'deskripsi' => $item['deskripsi'],
                'kategori' => $item['kategori'],
                'target' => $target,
                'terkumpul' => 0,
                'gambar' => null,
                'status' => 'aktif',
                'tanggal_mulai' => now()->subDays(rand(1, 30)),
                'tanggal_selesai' => now()->addDays(rand(10, 60)),
            ]);

            // Create 5 donations for each campaign
            $totalDonations = 0;
            for ($i = 0; $i < 5; $i++) {
                $amount = rand(50000, 1000000);
                $totalDonations += $amount;
                $donorName = $donaturNames[array_rand($donaturNames)];
                
                Donation::create([
                    'campaign_id' => $campaign->id,
                    'user_id' => $donatur->id,
                    'amount' => $amount,
                    'donor_name' => $donorName,
                    'donor_email' => strtolower($donorName) . '@gmail.com',
                    'donor_phone' => '08' . rand(10000000, 99999999),
                    'status' => 'completed',
                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                    'transaction_id' => 'TX-' . rand(100000, 999999),
                    'notes' => 'Semoga berkah dan membantu.',
                ]);
            }

            // Create 2 campaign updates
            for ($j = 1; $j <= 2; $j++) {
                CampaignUpdate::create([
                    'campaign_id' => $campaign->id,
                    'user_id' => $fundraiser->id,
                    'judul' => 'Update Perkembangan Campaign Ke-' . $j,
                    'konten' => 'Berikut adalah detail perkembangan dari program bantuan ini. Terima kasih kepada seluruh donatur atas kontribusinya.',
                ]);
            }

            // Update campaign terkumpul
            $campaign->update(['terkumpul' => $totalDonations]);
        }
    }
}
