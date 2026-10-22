<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saran extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_saran',
        'user_id',
        'nama_pengirim',
        'kontak_pengirim',
        'status_pengirim',
        'is_anonim',
        'category_id',
        'judul',
        'isi',
        'lampiran',
        'status',
        'ditujukan_kepada',
        'catatan_tindak_lanjut',
        'tanggal_tindak_lanjut',
    ];

    protected $casts = [
        'is_anonim' => 'boolean',
        'tanggal_tindak_lanjut' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function histories()
    {
        return $this->hasMany(SaranHistory::class)->latest();
    }

    /**
     * Generate format kode unik saran otomatis: SPN-TAHUN-URUTAN
     */
    public static function generateKodeSaran(): string
    {
        $year = date('Y');
        $prefix = "SPN-{$year}-";
        $latest = self::where('kode_saran', 'like', "{$prefix}%")
            ->orderBy('kode_saran', 'desc')
            ->first();

        if (!$latest) {
            $number = 1;
        } else {
            $lastNumber = (int) substr($latest->kode_saran, strlen($prefix));
            $number = $lastNumber + 1;
        }

        return $prefix . str_pad($number, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Nama tampilan pengirim (jika anonim, tampilkan 'Anonim / Dirahasiakan')
     */
    public function getNamaTampilanAttribute(): string
    {
        return $this->is_anonim ? 'Anonim (Dirahasiakan)' : $this->nama_pengirim;
    }

    /**
     * Badge CSS class berdasarkan status
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'Baru' => 'bg-info text-dark',
            'Diterima' => 'bg-primary text-white',
            'Sedang Diverifikasi' => 'bg-secondary text-white',
            'Dalam Proses Tindak Lanjut' => 'bg-warning text-dark',
            'Selesai' => 'bg-success text-white',
            'Ditolak' => 'bg-danger text-white',
            default => 'bg-light text-dark',
        };
    }
}
