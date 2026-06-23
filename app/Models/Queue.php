<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;

    protected $fillable = [
        'queue_date', 'queue_number', 'no_resep', 'nama_pasien', 'status', 'admin_id'
    ];

    // Relasi: 1 Antrian dilayani oleh 1 Admin
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}