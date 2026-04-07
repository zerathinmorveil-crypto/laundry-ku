<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serpice extends Model
{
    use HasFactory;
    protected $table = 'serpices';

    protected $fillable = ['nama_layanan','harga_per_kg','estimasi_waktu','keterangan'];

    protected $casts = ['harga_per_kg' => 'decimal:2','estimasi_waktu' => 'integer'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_layanan', 'id_layanan');
    }
}
