<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Saran;
use App\Models\SaranHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Halaman Beranda Pihak Eksternal (Desain Panel 1)
     */
    public function home()
    {
        $categories = Category::withCount([
            'sarans',
            'sarans as terlaksana_count' => function ($query) {
                $query->where('status', 'Selesai');
            },
            'sarans as diproses_count' => function ($query) {
                $query->whereIn('status', ['Diterima', 'Sedang Diverifikasi', 'Dalam Proses Tindak Lanjut']);
            },
            'sarans as belum_terlaksana_count' => function ($query) {
                $query->where('status', 'Baru');
            },
            'sarans as tidak_terlaksana_count' => function ($query) {
                $query->where('status', 'Ditolak');
            },
        ])->get();

        $totalSaran = Saran::count();
        $saranBaru = Saran::where('status', 'Baru')->count();
        $saranDiproses = Saran::whereIn('status', ['Diterima', 'Sedang Diverifikasi', 'Dalam Proses Tindak Lanjut'])->count();
        $saranSelesai = Saran::where('status', 'Selesai')->count();
        $saranDitolak = Saran::where('status', 'Ditolak')->count();
        $persentaseTerlaksana = $totalSaran > 0 ? round(($saranSelesai / $totalSaran) * 100) : 0;

        return view('user.home', compact(
            'categories',
            'totalSaran',
            'saranBaru',
            'saranDiproses',
            'saranSelesai',
            'saranDitolak',
            'persentaseTerlaksana'
        ));
    }

    /**
     * Halaman Formulir Penyampaian Saran Eksternal (Desain Panel 2)
     */
    public function createSaran()
    {
        $categories = Category::all();
        $user = Auth::user();

        return view('user.saran_create', compact('categories', 'user'));
    }

    /**
     * Proses Pengiriman Saran Baru
     */
    public function storeSaran(Request $request)
    {
        $validated = $request->validate([
            'nama_pengirim' => ['nullable', 'string', 'max:150'],
            'status_pengirim' => ['nullable', 'string', 'max:100'],
            'category_id' => ['required', 'exists:categories,id'],
            'judul' => ['required', 'string', 'max:200'],
            'isi' => ['required', 'string'],
            'lampiran' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'], // Max 5MB
        ], [
            'category_id.required' => 'Kategori saran wajib dipilih.',
            'judul.required' => 'Judul saran wajib diisi.',
            'isi.required' => 'Isi saran wajib diisi.',
            'lampiran.mimes' => 'Format file lampiran harus JPG, PNG, atau PDF.',
            'lampiran.max' => 'Ukuran lampiran maksimal 5MB.',
        ]);

        $kodeSaran = Saran::generateKodeSaran();
        $lampiranPath = null;

        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $file->move(public_path('uploads/lampiran'), $filename);
            $lampiranPath = 'uploads/lampiran/' . $filename;
        }

        $namaInput = trim($validated['nama_pengirim'] ?? '');
        $statusInput = trim($validated['status_pengirim'] ?? '');

        $isAnonim = empty($namaInput);
        $namaPengirim = !empty($namaInput) ? $namaInput : 'Anonim';
        $statusPengirim = !empty($statusInput) ? $statusInput : 'Masyarakat';
        $kontakPengirim = '-';

        $saran = Saran::create([
            'kode_saran' => $kodeSaran,
            'user_id' => Auth::id(),
            'nama_pengirim' => $namaPengirim,
            'kontak_pengirim' => $kontakPengirim,
            'status_pengirim' => $statusPengirim,
            'is_anonim' => $isAnonim,
            'category_id' => $validated['category_id'],
            'judul' => $validated['judul'],
            'isi' => $validated['isi'],
            'lampiran' => $lampiranPath,
            'status' => 'Baru',
        ]);

        // Catat riwayat status pertama
        SaranHistory::create([
            'saran_id' => $saran->id,
            'status' => 'Saran Dikirim',
            'catatan' => 'Saran berhasil dikirimkan oleh ' . ($isAnonim ? 'Anonim' : $namaPengirim),
            'diperbarui_oleh' => 'Sistem SIPESAN',
        ]);

        session(['latest_saran_kode' => $saran->kode_saran]);

        return redirect()->route('user.saran.sukses', $saran->kode_saran);
    }

    /**
     * Halaman Kode Saran Setelah Submit (Desain Panel 3)
     */
    public function suksesSaran($kode)
    {
        $saran = Saran::where('kode_saran', $kode)->firstOrFail();
        return view('user.saran_sukses', compact('saran'));
    }

    /**
     * Halaman Cek Status Saran (Desain Panel 4)
     */
    public function cekStatus(Request $request)
    {
        $kode = trim($request->get('kode', ''));
        $saran = null;
        $searched = false;

        if (!empty($kode)) {
            $searched = true;
            $saran = Saran::with(['category', 'histories'])
                ->where('kode_saran', $kode)
                ->first();
        }

        // Data saran masuk untuk ditampilkan di halaman cek status
        $allSarans = Saran::with('category')
            ->latest()
            ->paginate(10);

        return view('user.saran_status', compact('saran', 'kode', 'searched', 'allSarans'));
    }

    /**
     * Dashboard Khusus Akun Pihak Eksternal yang Login
     */
    public function dashboard()
    {
        $user = Auth::user();
        $sarans = Saran::with('category')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        $totalKirim = Saran::where('user_id', $user->id)->count();
        $totalSelesai = Saran::where('user_id', $user->id)->where('status', 'Selesai')->count();
        $totalProses = Saran::where('user_id', $user->id)->whereIn('status', ['Dalam Proses Tindak Lanjut', 'Sedang Diverifikasi', 'Diterima'])->count();
        $totalBaru = Saran::where('user_id', $user->id)->where('status', 'Baru')->count();
        $totalDitolak = Saran::where('user_id', $user->id)->where('status', 'Ditolak')->count();

        return view('user.dashboard', compact('user', 'sarans', 'totalKirim', 'totalSelesai', 'totalProses', 'totalBaru', 'totalDitolak'));
    }
}
