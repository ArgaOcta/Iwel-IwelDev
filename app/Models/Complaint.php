<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'ticket_no',
        'title',
        'description',
        'status',
        'priority',
        'is_anonymous',
        'rating',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
    ];

    /**
     * Relasi: Pengaduan ini diajukan oleh seorang user (mahasiswa).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Pengaduan ini termasuk dalam suatu kategori.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi: Pengaduan ini bisa memiliki banyak komentar/tanggapan.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Relasi: Pengaduan ini bisa memiliki beberapa file lampiran bukti.
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    /**
     * Relasi: Pengaduan ini mencatat riwayat perubahan melalui audit logs.
     */
    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }
    public function responses()
    {
        return $this->hasMany(ComplaintResponse::class);
    }
    
}

?>