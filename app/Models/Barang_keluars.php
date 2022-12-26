<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Barang_keluars extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table   = "barang_keluars";

    static function get_number($tanggal)
    {
        $get_number = DB::table('barang_keluars')
            ->where('no_barang_keluar', 'like', '%' . $tanggal . '%')
            ->orderBy('id', 'desc')
            ->limit(1)
            ->first();

        return $get_number;
    }
}
