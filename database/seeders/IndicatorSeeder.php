<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Indicator;
use Illuminate\Database\Seeder;

class IndicatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Indeks Pembangunan Manusia (IPM)',
                'description' => 'Indikator untuk mengukur keberhasilan pembangunan kualitas hidup manusia di suatu daerah.',
                'location' => 'Kabupaten Madiun',
                'total_views' => 120,
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'name' => 'Tingkat Pengangguran Terbuka (TPT)',
                'description' => 'Persentase angkatan kerja yang belum mendapatkan pekerjaan.',
                'location' => 'Kota Surabaya',
                'total_views' => 210,
                'created_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'name' => 'Persentase Penduduk Miskin',
                'description' => 'Proporsi penduduk dengan pengeluaran di bawah garis kemiskinan.',
                'location' => 'Kabupaten Malang',
                'total_views' => 85,
                'created_at' => Carbon::now()->subDays(15),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'name' => 'Upah Minimum Provinsi (UMP)',
                'description' => 'Data tahunan terkait penetapan upah minimum di setiap provinsi.',
                'location' => 'Provinsi Jawa Timur',
                'total_views' => 300,
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'name' => 'Sanitasi Layak',
                'description' => 'Indikator jumlah rumah tangga dengan akses terhadap sanitasi layak.',
                'location' => 'Kabupaten Banyuwangi',
                'total_views' => 70,
                'created_at' => Carbon::now()->subDays(40),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'name' => 'Akses Air Bersih',
                'description' => 'Persentase penduduk dengan akses terhadap sumber air bersih.',
                'location' => 'Kabupaten Kediri',
                'total_views' => 95,
                'created_at' => Carbon::now()->subDays(25),
                'updated_at' => Carbon::now()->subDays(4),
            ],
            [
                'name' => 'Pertumbuhan Ekonomi',
                'description' => 'Laju pertumbuhan Produk Domestik Regional Bruto (PDRB) suatu daerah.',
                'location' => 'Kota Batu',
                'total_views' => 160,
                'created_at' => Carbon::now()->subDays(12),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'name' => 'Angka Partisipasi Sekolah (APS)',
                'description' => 'Persentase anak usia sekolah yang masih bersekolah.',
                'location' => 'Kabupaten Ponorogo',
                'total_views' => 110,
                'created_at' => Carbon::now()->subDays(8),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'name' => 'Rasio Gini',
                'description' => 'Indikator ketimpangan distribusi pendapatan di suatu wilayah.',
                'location' => 'Kabupaten Blitar',
                'total_views' => 250,
                'created_at' => Carbon::now()->subDays(18),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'name' => 'Angka Harapan Hidup',
                'description' => 'Rata-rata perkiraan umur harapan hidup bayi baru lahir.',
                'location' => 'Provinsi Jawa Timur',
                'total_views' => 400,
                'created_at' => Carbon::now()->subDays(35),
                'updated_at' => Carbon::now()->subDays(2),
            ],
        ];

        foreach ($data as $item) {
            Indicator::updateOrCreate(
                ['name' => $item['name']],
                $item
            );
        }
    }
}
