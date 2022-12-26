<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang_masuk_detail_laporans extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table   = "barang_masuk_detail_laporans";
}
