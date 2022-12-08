<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table   = "suppliers";
    protected $guarded = ['id'];

    public function barang_masuk()
    {
        return $this->belongsTo(Barang_masuks::class);
    }
}
