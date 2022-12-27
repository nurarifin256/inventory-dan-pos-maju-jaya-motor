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

    static function get_locator($not_in)
    {
        $datas = DB::table('barang_masuk_details AS A')
            ->join('locators AS B', 'B.id', '=', 'A.locator_id')
            ->join('levels AS C', 'C.id', '=', 'B.level_id')
            ->join('racks AS D', 'D.id', '=', 'B.rack_id')
            ->select('A.id', 'C.level', 'D.no AS no_rack', 'B.no AS no_locator', 'A.qty')
            ->where([
                'A.not_in'  => $not_in,
                'A.trashed' => 0,
                'A.status' => 0,
            ])
            ->get();

        return $datas;
    }

    static function get_data_for_print($id)
    {
        $datas = DB::table('barang_keluars AS A')
            ->join('barang_keluar_details AS B', 'B.barang_keluar_id', '=', 'A.id')
            ->join('barangs AS C', 'C.id', '=', 'B.barang_id')
            ->join('mereks AS D', 'D.id', '=', 'B.merek_id')
            ->select('A.total', 'B.qty', 'C.nama AS nama_barang', 'D.nama AS nama_merek', 'C.harga', 'A.no_barang_keluar')
            ->where([
                'A.id'  => $id,
                'A.trashed' => 0,
            ]);

        return $datas;
    }
}
