<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    // Sesuai alur proses utama, tabel log ini hanya mencatat riwayat masuk (insert-only)
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'complaint_id',
        'action',
        'old_status',
        'new_status',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Relasi: Siapa aktor yang melakukan perubahan status/aksi ini.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Tiket pengaduan mana yang statusnya berubah.
     */
    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }
}

?>