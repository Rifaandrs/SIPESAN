<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Saran;
use App\Models\SaranHistory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin (Wakasek Humas)
        $this->call(AdminUserSeeder::class);

        // 2. Akun Regular User (Pihak Eksternal)
        $user = User::updateOrCreate(
            ['email' => 'user@sipesan.local'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        // 3. Kategori Saran Sekolah
        $categoriesData = [
            ['nama' => 'Fasilitas Sekolah', 'deskripsi' => 'Gedung, ruang kelas, toilet, sarana olahraga, dan inventaris sekolah'],
            ['nama' => 'Pelayanan Administrasi', 'deskripsi' => 'Tata usaha, surat keterangan, legalisir, dan pelayanan loket'],
            ['nama' => 'Pembelajaran', 'deskripsi' => 'Kurikulum, media ajar, proses belajar mengajar, dan bimbingan konseling'],
            ['nama' => 'Lingkungan Sekolah', 'deskripsi' => 'Kebersihan, penghijauan, sanitasi, dan kantin sehat'],
            ['nama' => 'Keamanan', 'deskripsi' => 'Keamanan gerbang, ketertiban jam masuk/pulang, dan parkir'],
            ['nama' => 'Kegiatan Sekolah', 'deskripsi' => 'Ekstrakurikuler, pentas seni, perlombaan, dan perayaan sekolah'],
            ['nama' => 'Lainnya', 'deskripsi' => 'Saran dan masukan umum lainnya'],
        ];

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[$cat['nama']] = Category::firstOrCreate(['nama' => $cat['nama']], $cat);
        }

        // 4. Data Contoh Saran Eksternal (Sesuai Desain Mockup)
        $sampleSarans = [
            [
                'kode_saran' => 'SPN-2026-00125',
                'user_id' => $user->id,
                'nama_pengirim' => 'Budi Santoso',
                'kontak_pengirim' => '081234567890 / budi@email.com',
                'status_pengirim' => 'Orang Tua/Wali',
                'is_anonim' => false,
                'category_id' => $categories['Fasilitas Sekolah']->id,
                'judul' => 'Peningkatan fasilitas toilet sekolah',
                'isi' => 'Saya menyarankan agar fasilitas toilet siswa di lantai 2 dapat diperbaiki kran airnya dan ditingkatkan kebersihannya secara berkala demi kenyamanan anak-anak.',
                'status' => 'Dalam Proses Tindak Lanjut',
                'ditujukan_kepada' => 'Bagian Sarana dan Prasarana',
                'catatan_tindak_lanjut' => 'Saran telah diteruskan kepada bagian sarana dan prasarana untuk dilakukan pemeriksaan langsung dan perbaikan.',
                'tanggal_tindak_lanjut' => now()->subDays(1),
                'created_at' => now()->subDays(2),
                'histories' => [
                    ['status' => 'Saran Dikirim', 'catatan' => 'Saran berhasil disubmit oleh pengirim.', 'created_at' => now()->subDays(2)->setTime(10, 15)],
                    ['status' => 'Saran Diterima', 'catatan' => 'Saran diterima dan diverifikasi oleh Humas.', 'created_at' => now()->subDays(2)->setTime(11, 2)],
                    ['status' => 'Sedang Diverifikasi', 'catatan' => 'Diverifikasi kelayakan dan kelengkapan informasi.', 'created_at' => now()->subDays(2)->setTime(14, 30)],
                    ['status' => 'Dalam Proses Tindak Lanjut', 'catatan' => 'Diteruskan ke Bagian Sarana dan Prasarana.', 'created_at' => now()->subDays(1)->setTime(9, 0)],
                ],
            ],
            [
                'kode_saran' => 'SPN-2026-00124',
                'user_id' => null,
                'nama_pengirim' => 'Rian Hidayat',
                'kontak_pengirim' => '085712345678',
                'status_pengirim' => 'Alumni',
                'is_anonim' => false,
                'category_id' => $categories['Pembelajaran']->id,
                'judul' => 'Penambahan materi workshop literasi digital',
                'isi' => 'Sebagai alumni, saya berharap sekolah dapat mengadakan workshop literasi digital dan pengenalan coding dasar untuk adik-adik kelas.',
                'status' => 'Dalam Proses Tindak Lanjut',
                'ditujukan_kepada' => 'Bagian Kurikulum',
                'catatan_tindak_lanjut' => 'Akan diagendakan dalam kegiatan jeda semester.',
                'tanggal_tindak_lanjut' => now()->subDays(3),
                'created_at' => now()->subDays(4),
                'histories' => [
                    ['status' => 'Saran Dikirim', 'catatan' => 'Saran disubmit.', 'created_at' => now()->subDays(4)],
                    ['status' => 'Dalam Proses Tindak Lanjut', 'catatan' => 'Diteruskan ke tim kurikulum.', 'created_at' => now()->subDays(3)],
                ],
            ],
            [
                'kode_saran' => 'SPN-2026-00123',
                'user_id' => null,
                'nama_pengirim' => 'Warga Sekitar',
                'kontak_pengirim' => '087899887766',
                'status_pengirim' => 'Masyarakat',
                'is_anonim' => true,
                'category_id' => $categories['Lingkungan Sekolah']->id,
                'judul' => 'Penataan tempat sampah di pinggir jalan depan gerbang',
                'isi' => 'Mohon tempat sampah depan gerbang sekolah agar selalu tertutup supaya tidak menimbulkan bau bagi warga yang melintas.',
                'status' => 'Selesai',
                'ditujukan_kepada' => 'Bagian Sarana dan Prasarana',
                'catatan_tindak_lanjut' => 'Tempat sampah telah diganti dengan tong berpenutup dan sampah rutin diangkut setiap pagi.',
                'tanggal_tindak_lanjut' => now()->subDays(5),
                'created_at' => now()->subDays(6),
                'histories' => [
                    ['status' => 'Saran Dikirim', 'catatan' => 'Saran anonim disubmit.', 'created_at' => now()->subDays(6)],
                    ['status' => 'Dalam Proses Tindak Lanjut', 'catatan' => 'Pengadaan tong sampah baru.', 'created_at' => now()->subDays(5)],
                    ['status' => 'Selesai', 'catatan' => 'Tindak lanjut selesai dan tuntas.', 'created_at' => now()->subDays(4)],
                ],
            ],
            [
                'kode_saran' => 'SPN-2026-00122',
                'user_id' => null,
                'nama_pengirim' => 'Hj. Siti Rohmah',
                'kontak_pengirim' => 'siti.rohmah@komite.org',
                'status_pengirim' => 'Komite',
                'is_anonim' => false,
                'category_id' => $categories['Pelayanan Administrasi']->id,
                'judul' => 'Layanan legalisir ijazah secara daring/online',
                'isi' => 'Kami mengusulkan adanya form online untuk pengajuan permohonan legalisir agar alumni tidak perlu mengantre lama di kantor TU.',
                'status' => 'Sedang Diverifikasi',
                'ditujukan_kepada' => 'Bagian Tata Usaha',
                'catatan_tindak_lanjut' => 'Sedang dikoordinasikan dengan staf TU.',
                'tanggal_tindak_lanjut' => now()->subDays(2),
                'created_at' => now()->subDays(3),
                'histories' => [
                    ['status' => 'Saran Dikirim', 'catatan' => 'Saran disubmit.', 'created_at' => now()->subDays(3)],
                    ['status' => 'Sedang Diverifikasi', 'catatan' => 'Verifikasi usulan komite.', 'created_at' => now()->subDays(2)],
                ],
            ],
            [
                'kode_saran' => 'SPN-2026-00121',
                'user_id' => null,
                'nama_pengirim' => 'Polsek Purwakarta',
                'kontak_pengirim' => '0264-123456',
                'status_pengirim' => 'Instansi',
                'is_anonim' => false,
                'category_id' => $categories['Keamanan']->id,
                'judul' => 'Pengaturan lalu lintas saat jam kepulangan siswa',
                'isi' => 'Kerjasama penjagaan satpam sekolah untuk membantu menyeberangkan siswa di jalan raya agar tidak terjadi penumpukan kendaraan.',
                'status' => 'Baru',
                'ditujukan_kepada' => 'Bagian Kesiswaan & Satpam',
                'catatan_tindak_lanjut' => null,
                'tanggal_tindak_lanjut' => null,
                'created_at' => now()->subHours(5),
                'histories' => [
                    ['status' => 'Saran Dikirim', 'catatan' => 'Saran diterima dari instansi mitra.', 'created_at' => now()->subHours(5)],
                ],
            ],
        ];

        foreach ($sampleSarans as $data) {
            $histories = $data['histories'] ?? [];
            unset($data['histories']);

            $saran = Saran::updateOrCreate(
                ['kode_saran' => $data['kode_saran']],
                $data
            );

            foreach ($histories as $hist) {
                SaranHistory::firstOrCreate(
                    [
                        'saran_id' => $saran->id,
                        'status' => $hist['status'],
                    ],
                    [
                        'catatan' => $hist['catatan'],
                        'diperbarui_oleh' => 'Wakasek Humas',
                        'created_at' => $hist['created_at'],
                        'updated_at' => $hist['created_at'],
                    ]
                );
            }
        }
    }
}
