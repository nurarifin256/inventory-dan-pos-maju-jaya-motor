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
            ->join('suppliers AS E', 'E.id', '=', 'D.supplier_id')
            ->select('B.nama AS nama_barang', 'C.nama AS nama_merek', 'A.not_in', 'E.nama AS nama_supplier', 'A.qty', DB::raw('SUM(qty) as total_qty'))
            ->where('D.status', '=', 1)
            ->whereBetween('D.created_at', [$tgl_mulai, $tgl_sampai])
            ->groupBy('A.not_in')
            ->get();

        return $datas;
    }

    static function laporan_barang_masuk_supplier($tgl_mulai, $tgl_sampai)
    {
        $datas = DB::table('barang_masuks AS A')
            ->join('suppliers AS B', 'B.id', '=', 'A.supplier_id')
            ->join('barang_masuk_details AS C', 'C.barang_masuk_id', '=', 'A.id')
            ->select('B.nama AS nama_supplier', 'B.kode_supplier', 'A.supplier_id', DB::raw('count(A.supplier_id) as kirim, sum(C.qty) as total_qty'))
            ->where(['A.status' => 1, 'A.trashed' => 0, 'C.trashed' => 0])
            ->whereBetween('A.created_at', [$tgl_mulai, $tgl_sampai])
            ->groupBy('A.supplier_id')
            ->get();

        return $datas;
    }

    static function laporan_barang_masuk_detail_hasil_supplier($supplier_id, $tgl_mulai, $tgl_sampai)
    {
        $datas = DB::table('barang_masuks AS A')
            ->join('barang_masuk_details AS B', 'B.barang_masuk_id', '=', 'A.id')
            ->join('barangs AS C', 'C.id', '=', 'B.barang_id')
            ->join('mereks AS D', 'D.id', '=', 'B.merek_id')
            ->select('A.created_at', 'B.qty', 'C.nama AS nama_barang', 'D.nama AS nama_merek')
            ->where(['A.status' => 1, 'A.trashed' => 0, 'B.trashed' => 0, 'A.supplier_id' => $supplier_id])
            ->whereBetween('A.created_at', [$tgl_mulai, $tgl_sampai])
            ->get();

        return $datas;
    }
}
