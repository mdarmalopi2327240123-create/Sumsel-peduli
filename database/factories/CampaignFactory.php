<?php

namespace Database\Factories;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Campaign>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $target = $this->faker->numberBetween(5000000, 100000000);
        $terkumpul = $this->faker->numberBetween(0, $target);

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

        $selected = $this->faker->randomElement($indonesianCampaigns);

        return [
            'judul' => $selected['judul'],
            'deskripsi' => $selected['deskripsi'],
            'kategori' => $selected['kategori'],
            'target' => $target,
            'terkumpul' => $terkumpul,
            'gambar' => null,
            'status' => 'aktif',
            'tanggal_mulai' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'tanggal_selesai' => $this->faker->dateTimeBetween('now', '+60 days'),
        ];
    }
}
