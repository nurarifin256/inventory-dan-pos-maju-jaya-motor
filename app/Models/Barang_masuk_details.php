<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang_masuk_details extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table   = "barang_masuk_details";

    public function barang_masuks()
    {
        return $this->belongsTo(Barang_masuks::class);
    }
}
