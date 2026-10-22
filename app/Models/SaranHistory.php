<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaranHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'saran_id',
        'status',
        'catatan',
        'diperbarui_oleh',
    ];

    public function saran()
    {
        return $this->belongsTo(Saran::class);
    }
}
