<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'department',
    ];

    /**
     * Relasi: Satu kategori dapat digunakan oleh banyak pengaduan.
     */
    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
}

?>