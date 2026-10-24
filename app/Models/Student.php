<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenjang',
        'nama',
        'nisn',
        'email',
        'alamat',
        'jenis_kelamin',
        'dokumen',
        'kartu_keluarga',
        'akte_lahir',
        'ktp',
        'ijazah',
        'qr_code',
        'status',
        'status_kelulusan',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}