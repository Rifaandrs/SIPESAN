<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Saran;
use App\Models\SaranHistory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DummySaranSeeder extends Seeder
{
    /**
     * Seed 12 dummy saran (untuk testing pagination).
     * Semua saran bersifat eksternal (user_id = null) dan nama pengirim dapat anonim atau tidak.
     */
    public function run(): void
    {
        // Pastikan kategori ada
        $catMap = Category::pluck('id', 'nama')->toArray();
        $cats = [
            $catMap['Fasilitas Sekolah']    ?? 1,
            $catMap['Pelayanan Administrasi']?? 2,
            $catMap['Pembelajaran']          ?? 3,
            $catMap['Lingkungan Sekolah']    ?? 4,
            $catMap['Keamanan']              ?? 5,
            $catMap['Kegiatan Sekolah']      ?? 6,
            $catMap['Lainnya']               ?? 7,
        ];

        $statuses = [
            'Baru', 'Baru', 'Baru',
            'Diterima',
            'Sedang Diverifikasi',
            'Dalam Proses Tindak Lanjut',
            'Selesai',
            'Ditolak',
            'Baru', 'Selesai', 'Dalam Proses Tindak Lanjut', 'Sedang Diverifikasi',
        ];

        $sample = [
            ['cat' => $cats[0], 'nama' => 'Rina Marlina',      'judul' => 'Perbaikan atap kelas XII IPA 2 yang bocor',            'status_pengirim' => 'Orang Tua/Wali', 'is_anonim' => false],
            ['cat' => $cats[1], 'nama' => 'Ani Saputra',      'judul' => 'Penambahan buku pelajaran di perpustakaan',          'status_pengirim' => 'Orang Tua/Wali', 'is_anonim' => false],
            ['cat' => $cats[2], 'nama' => 'Pengirim Anonim',  'judul' => 'Peningkatan jaringan Wi‑Fi sekolah',                 'status_pengirim' => 'Siswa',          'is_anonim' => true],
            ['cat' => $cats[3], 'nama' => 'Pak Darmawan',     'judul' => 'Penghijauan halaman sekolah dengan tanaman hias',    'status_pengirim' => 'Masyarakat',     'is_anonim' => false],
            ['cat' => $cats[4], 'nama' => 'Bpk. Sunarya',    'judul' => 'Pemasangan CCTV di koridor lantai 1 dan 2',          'status_pengirim' => 'Orang Tua/Wali', 'is_anonim' => false],
            ['cat' => $cats[5], 'nama' => 'Komunitas Pelajar','judul' => 'Pengadaan lomba debat antar kelas',                  'status_pengirim' => 'Masyarakat',     'is_anonim' => false],
            ['cat' => $cats[6], 'nama' => 'Pengirim Anonim',  'judul' => 'Pemasangan papan informasi digital di lobby',        'status_pengirim' => 'Komite',         'is_anonim' => true],
            ['cat' => $cats[0], 'nama' => 'Faisal Akbar',    'judul' => 'Penyediaan locker penyimpanan tas siswa',           'status_pengirim' => 'Siswa',          'is_anonim' => false],
            ['cat' => $cats[2], 'nama' => 'Drs. Suherman',   'judul' => 'Pengadaan kelas tambahan untuk siswa berprestasi',   'status_pengirim' => 'Komite',         'is_anonim' => false],
            ['cat' => $cats[3], 'nama' => 'OSIS SMPN 2',     'judul' => 'Pembuatan taman baca di pojok sekolah',              'status_pengirim' => 'Siswa',          'is_anonim' => false],
            ['cat' => $cats[1], 'nama' => 'Ibu Lilis',       'judul' => 'Pembukaan layanan konsultasi online dengan guru BK','status_pengirim' => 'Orang Tua/Wali', 'is_anonim' => false],
            ['cat' => $cats[4], 'nama' => 'RT 04 Setiamanah','judul' => 'Pemasangan pagar pengaman jalan depan sekolah',       'status_pengirim' => 'Masyarakat',     'is_anonim' => false],
        ];

        // Tentukan kode saran selanjutnya
        $last = Saran::where('kode_saran', 'like', 'SPN-2026-%')
            ->orderBy('kode_saran', 'desc')
            ->value('kode_saran');
        $nextNum = $last ? ((int) substr($last, 9)) + 1 : 128;

        foreach ($sample as $idx => $item) {
            $status = $statuses[$idx] ?? 'Baru';
            $kode   = 'SPN-2026-' . str_pad($nextNum++, 5, '0', STR_PAD_LEFT);
            $daysAgo = rand(1, 30);
            $saran = Saran::create([
                'kode_saran'          => $kode,
                'user_id'             => null,
                'nama_pengirim'       => $item['nama'],
                'kontak_pengirim'     => '08' . rand(100000000, 999999999),
                'status_pengirim'     => $item['status_pengirim'],
                'is_anonim'           => $item['is_anonim'],
                'category_id'         => $item['cat'],
                'judul'               => $item['judul'],
                'isi'                 => 'Isi saran dummy untuk keperluan testing pagination. Data ini di‑generate secara otomatis.',
                'status'              => $status,
                'ditujukan_kepada'    => in_array($status, ['Dalam Proses Tindak Lanjut', 'Selesai']) ? 'Tim Terkait Sekolah' : null,
                'catatan_tindak_lanjut'=> in_array($status, ['Selesai']) ? 'Saran telah selesai ditindaklanjuti.' : null,
                'tanggal_tindak_lanjut'=> in_array($status, ['Dalam Proses Tindak Lanjut', 'Selesai']) ? now()->subDays($daysAgo - 1) : null,
                'created_at'          => now()->subDays($daysAgo),
                'updated_at'          => now()->subDays($daysAgo - 1),
            ]);

            // Minimal history: Saran Dikirim
            SaranHistory::create([
                'saran_id'        => $saran->id,
                'status'          => 'Saran Dikirim',
                'catatan'         => 'Saran berhasil dikirimkan oleh ' . ($item['is_anonim'] ? 'Anonim' : $item['nama']) . '.',
                'diperbarui_oleh' => 'Sistem SIPESAN',
                'created_at'      => now()->subDays($daysAgo),
                'updated_at'      => now()->subDays($daysAgo),
            ]);

            if ($status === 'Selesai') {
                SaranHistory::create([
                    'saran_id'        => $saran->id,
                    'status'          => 'Selesai',
                    'catatan'         => 'Saran telah selesai ditindaklanjuti.',
                    'diperbarui_oleh' => 'Wakasek Humas',
                    'created_at'      => now()->subDays($daysAgo - 2),
                    'updated_at'      => now()->subDays($daysAgo - 2),
                ]);
            }
        }

        $this->command->info('✅ DummySaranSeeder: ' . count($sample) . ' saran dummy berhasil ditambahkan.');
    }
}
