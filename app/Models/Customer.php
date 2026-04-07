<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';

    protected $fillable = ['nama_pelanggan','nomor_telepon','tanggal','alamat'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_pelanggan', 'id_pelanggan');
    }
    
    public function member()
    {
        return $this->hasOne(Member::class);
    }
}