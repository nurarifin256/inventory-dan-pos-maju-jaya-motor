<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kasirs extends Model
{
    use HasFactory;

    static function get_harga($barang_id)
    {
        $datas = DB::table('barangs AS A')
            ->select('A.harga')
            ->where('A.id', '=', $barang_id)
            ->first();

        return $datas;
    }

    static function get_stok($not_in)
    {
        $datas = DB::table('barang_masuk_details AS A')
            ->join('barang_masuks AS B', 'B.id', '=', 'A.barang_masuk_id')
            ->select(DB::raw('SUM(qty) as total_qty'))
            ->where([
                'B.status'  => 1,
                'A.not_in'  => $not_in,
                'A.trashed' => 0,
                'A.status' => 0,
            ])
            ->get();

        return $datas;
    }
}
