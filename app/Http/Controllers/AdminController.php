<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Saran;
use App\Models\SaranHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Dashboard Utama Wakasek Humas (Desain Panel 5)
     */
    public function dashboard()
    {
        $totalSaran = Saran::count();
        $saranBaru = Saran::where('status', 'Baru')->count();
        $saranDiproses = Saran::whereIn('status', ['Diterima', 'Sedang Diverifikasi', 'Dalam Proses Tindak Lanjut'])->count();
        $saranSelesai = Saran::where('status', 'Selesai')->count();
        $saranDitolak = Saran::where('status', 'Ditolak')->count();

        // Statistik Saran per Kategori
        $categoriesStats = Category::withCount('sarans')->get();

        // Daftar Saran Terbaru dengan Paginasi
        $recentSarans = Saran::with('category')->latest()->paginate(5, ['*'], 'saran_page')->withQueryString();

        return view('admin.dashboard', compact(
            'totalSaran',
            'saranBaru',
            'saranDiproses',
            'saranSelesai',
            'saranDitolak',
            'categoriesStats',
            'recentSarans'
        ));
    }

    /**
     * Daftar Seluruh Saran Masuk dengan Filter
     */
    public function saran(Request $request)
    {
        $query = Saran::with('category')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_saran', 'like', "%{$search}%")
                  ->orWhere('nama_pengirim', 'like', "%{$search}%")
                  ->orWhere('judul', 'like', "%{$search}%");
            });
        }

        $sarans = $query->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('admin.saran_index', compact('sarans', 'categories'));
    }

    /**
     * Halaman Detail & Verifikasi Tindak Lanjut Saran (Desain Panel 6)
     */
    public function showSaran(Saran $saran)
    {
        $saran->load(['category', 'histories']);
        return view('admin.saran_show', compact('saran'));
    }

    /**
     * Proses Pembaruan Status & Tindak Lanjut oleh Wakasek Humas
     */
    public function updateSaran(Request $request, Saran $saran)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:Baru,Diterima,Sedang Diverifikasi,Dalam Proses Tindak Lanjut,Selesai,Ditolak'],
            'ditujukan_kepada' => ['nullable', 'string', 'max:150'],
            'catatan_tindak_lanjut' => ['nullable', 'string'],
        ]);

        $statusLama = $saran->status;
        $statusBaru = $validated['status'];

        $saran->update([
            'status' => $statusBaru,
            'ditujukan_kepada' => $validated['ditujukan_kepada'] ?? $saran->ditujukan_kepada,
            'catatan_tindak_lanjut' => $validated['catatan_tindak_lanjut'] ?? $saran->catatan_tindak_lanjut,
            'tanggal_tindak_lanjut' => now(),
        ]);

        // Simpan ke riwayat/timeline
        SaranHistory::create([
            'saran_id' => $saran->id,
            'status' => $statusBaru,
            'catatan' => $validated['catatan_tindak_lanjut'] ?: "Status diperbarui menjadi: {$statusBaru}",
            'diperbarui_oleh' => Auth::user()->name ?? 'Wakasek Humas',
        ]);

        return back()->with('success', "Tindak lanjut untuk saran [{$saran->kode_saran}] berhasil disimpan!");
    }

    /**
     * Kelola Kategori Saran
     */
    public function categories()
    {
        $categories = Category::withCount('sarans')->latest()->paginate(10);
        return view('admin.categories', compact('categories'));
    }

    /**
     * Tambah Kategori Saran
     */
    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100', 'unique:categories,nama'],
            'deskripsi' => ['nullable', 'string', 'max:255'],
        ]);

        Category::create($validated);

        return back()->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    /**
     * Hapus Kategori Saran
     */
    public function destroyCategory(Category $category)
    {
        if ($category->sarans()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh saran.');
        }

        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }

    /**
     * Halaman Rekap & Laporan Saran Eksternal
     */
    public function laporan(Request $request)
    {
        $query = Saran::with('category')->latest();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $allSarans = (clone $query)->get();
        $sarans = $query->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('admin.laporan', compact('sarans', 'allSarans', 'categories'));
    }

    /**
     * Lihat Profil Admin
     */
    public function profile()
    {
        return view('admin.profile', ['user' => Auth::user()]);
    }

    /**
     * Update Profil Admin
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name'  => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];

        if ($request->filled('password')) {
            $rules['password']              = ['min:8', 'confirmed'];
            $rules['password_confirmation'] = ['required'];
        }

        $request->validate($rules);

        $data = [
            'name' => $request->name,
        ];

        // Proses upload foto jika ada
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo && \Storage::disk('public')->exists($user->photo)) {
                \Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = $request->file('photo')->store('profile_photos', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Hapus foto profil dan gunakan avatar default.
     */
    public function removeProfilePhoto()
    {
        $user = Auth::user();

        if ($user->photo) {
            \Storage::disk('public')->delete($user->photo);
            $user->update(['photo' => null]);
        }

        return back()->with('success', 'Foto profil dihapus. Avatar default sekarang digunakan.');
    }
}
