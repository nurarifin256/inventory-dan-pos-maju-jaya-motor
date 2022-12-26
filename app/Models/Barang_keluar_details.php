<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang_keluar_details extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table   = "barang_keluar_details";
}
