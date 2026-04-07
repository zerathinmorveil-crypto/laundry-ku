<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id','jenis_member','tanggal_bergabung','tanggal_expired','poin','status'];

    protected $casts = ['tanggal_bergabung' => 'date', 'tanggal_expired' => 'date'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status_member', 'aktif');
    }
}
