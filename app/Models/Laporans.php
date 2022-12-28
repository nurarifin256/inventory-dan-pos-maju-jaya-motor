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
        $datas = DB::table('barang_masuk_detail_laporans AS A')
            ->join('barangs AS B', 'B.id', '=', 'A.barang_id')
            ->join('mereks AS C', 'C.id', '=', 'A.merek_id')
            ->join('barang_masuks AS D', 'D.id', '=', 'A.barang_masuk_id')
            ->select('B.nama AS nama_barang', 'C.nama AS nama_merek', 'A.not_in', 'A.qty', DB::raw('SUM(qty) as total_qty'))
            ->where(['D.status' => 1, 'A.trashed' => 0, 'D.trashed' => 0])
            ->whereBetween('D.created_at', [$tgl_mulai, $tgl_sampai])
            ->groupBy('A.not_in')
            ->get();

        return $datas;
    }

    static function laporan_barang_keluar($tgl_mulai, $tgl_sampai)
    {
        $datas = DB::table('barang_keluar_details AS A')
            ->join('barangs AS B', 'B.id', '=', 'A.barang_id')
            ->join('mereks AS C', 'C.id', '=', 'A.merek_id')
            ->join('barang_keluars AS D', 'D.id', '=', 'A.barang_keluar_id')
            ->select('B.nama AS nama_barang', 'C.nama AS nama_merek', 'A.not_in', 'A.qty', DB::raw('SUM(qty) as total_qty'))
            ->where(['A.trashed' => 0, 'D.trashed' => 0])
            ->whereBetween('D.created_at', [$tgl_mulai, $tgl_sampai])
            ->groupBy('A.not_in')
            ->get();

        return $datas;
    }

    static function laporan_barang_masuk_supplier($tgl_mulai, $tgl_sampai)
    {

        $sql = "(SELECT A1.kirim, A1.id, SUM(C.qty) AS total_qty, D.nama AS nama_supplier, D.kode_supplier, A1.created_at, D.id AS supplier_id FROM
                        (SELECT COUNT(B.id) AS kirim, B.id, B.supplier_id, B.created_at FROM barang_masuks B WHERE B.status=1 AND B.trashed=0 GROUP BY B.id) A1
                    INNER JOIN barang_masuk_detail_laporans C ON C.barang_masuk_id=A1.id 
                    INNER JOIN suppliers D ON D.id=A1.supplier_id
                    WHERE C.trashed=0 GROUP BY C.barang_masuk_id
                    ) AS A2";

        $sqls = DB::table(DB::raw($sql));
        $sqls->whereBetween('A2.created_at', [$tgl_mulai, $tgl_sampai]);
        return $sqls;
    }

    static function laporan_barang_keluar_pelanggan($tgl_mulai, $tgl_sampai)
    {

        $sql = "(SELECT A1.kirim, A1.id, SUM(C.qty) AS total_qty, D.nama AS nama_pelanggan, A1.created_at, D.id AS pelanggan_id FROM
                        (SELECT COUNT(B.id) AS kirim, B.id, B.pelanggan_id, B.created_at FROM barang_keluars B WHERE B.trashed=0 GROUP BY B.id) A1
                    INNER JOIN barang_keluar_details C ON C.barang_keluar_id=A1.id 
                    INNER JOIN pelanggans D ON D.id=A1.pelanggan_id
                    WHERE C.trashed=0 GROUP BY C.barang_keluar_id
                    ) AS A2";

        $sqls = DB::table(DB::raw($sql));
        $sqls->whereBetween('A2.created_at', [$tgl_mulai, $tgl_sampai]);
        return $sqls;
    }

    static function laporan_barang_masuk_detail_hasil_supplier($supplier_id, $tgl_mulai, $tgl_sampai)
    {
        $datas = DB::table('barang_masuks AS A')
            ->join('barang_masuk_detail_laporans AS B', 'B.barang_masuk_id', '=', 'A.id')
            ->join('barangs AS C', 'C.id', '=', 'B.barang_id')
            ->join('mereks AS D', 'D.id', '=', 'B.merek_id')
            ->select('A.created_at', 'B.qty', 'C.nama AS nama_barang', 'D.nama AS nama_merek')
            ->where(['A.status' => 1, 'A.trashed' => 0, 'B.trashed' => 0, 'A.supplier_id' => $supplier_id])
            ->whereBetween('A.created_at', [$tgl_mulai, $tgl_sampai])
            ->get();

        return $datas;
    }
}
