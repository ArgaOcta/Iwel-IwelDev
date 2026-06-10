<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'complaint_id',
        'file_path',
        'file_type',
        'file_size',
    ];

    /**
     * Relasi: Lampiran file ini menempel pada satu tiket pengaduan.
     */
    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }
}

?>