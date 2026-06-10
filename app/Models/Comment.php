<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'complaint_id',
        'user_id',
        'body',
        'is_admin_reply',
    ];

    protected $casts = [
        'is_admin_reply' => 'boolean',
    ];

    /**
     * Relasi: Komentar ini merujuk pada satu tiket pengaduan tertentu.
     */
    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    /**
     * Relasi: Komentar ini ditulis oleh seorang user (mahasiswa/admin).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

?>