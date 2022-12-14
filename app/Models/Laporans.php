<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Laporans extends Model
{
    use HasFactory;

    static function laporan_barang_masuk($tgl_mulai, $tgl_sampai)
    {
        $datas = DB::table('barang_masuk_details AS A')
            ->join('barangs AS B', 'B.id', '=', 'A.barang_id')
            ->join('mereks AS C', 'C.id', '=', 'A.merek_id')
            ->join('barang_masuks AS D', 'D.id', '=', 'A.barang_masuk_id')
            ->select('B.nama AS nama_barang', 'C.nama AS nama_merek', 'A.qty')
            ->where('D.status', '=', 1)
            ->whereBetween('A.created_at', ['2022-12-08', '2022-12-09'])
            ->get();

        return $datas;
    }
}
