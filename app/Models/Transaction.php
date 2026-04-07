<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['nomor_nota','customer_id','serpice_id','tanggal_masuk','tanggal_selesai','tanggal_ambil','berat_kg','total_harga','status','status_bayar','jumlah_bayar','catatan'];

    protected $casts = ['tanggal_masuk' => 'datetime','tanggal_selesai' => 'datetime','tanggal_ambil' => 'datetime',];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function serpice()
    {
        return $this->belongsTo(Serpice::class);
    }

    public static function generateNomorNota()
    {
        $lastTransaction = self::orderBy('id', 'desc')->first();
        $lastNumber = $lastTransaction ? intval(substr($lastTransaction->nomor_nota, 4)) : 0;
        $newNumber = $lastNumber + 1;

        return 'TRX-' . date('Ymd') . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
