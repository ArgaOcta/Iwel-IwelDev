<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang dapat diisi melalui mass assignment.
     */
    protected $fillable = [
        'name',
        'nim',
        'email',
        'password',
        'role',
        'program_studi',
    ];

    /**
     * Kolom yang harus disembunyikan untuk serialisasi.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atribut yang harus dikonversi ke tipe data tertentu.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relasi: Seorang user bisa memiliki banyak pengaduan (complaints).
     */
    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    /**
     * Relasi: Seorang user bisa menulis banyak komentar.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Relasi: Seorang user bisa menerima banyak notifikasi.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}

?>