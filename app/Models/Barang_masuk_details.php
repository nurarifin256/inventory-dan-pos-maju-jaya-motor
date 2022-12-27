<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Barang_masuk_details extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table   = "barang_masuk_details";

    public function barang_masuks()
    {
        return $this->belongsTo(Barang_masuks::class);
    }

    static function getDetails($id)
    {
        $barang_masuk_details = DB::table('barang_masuk_detail_laporans AS A')
            ->join('barangs AS B', 'B.id', '=', 'A.barang_id')
            ->join('mereks AS C', 'C.id', '=', 'A.merek_id')
            ->select('A.id', 'B.nama AS nama_barang', 'C.nama AS nama_merek', 'A.qty', 'A.barang_id', 'A.merek_id', 'A.locator_id')
            ->where('A.barang_masuk_id', '=', $id)
            ->get();

        return $barang_masuk_details;
    }

    static function getDetails2($id)
    {
        $barang_masuk_details = DB::table('barang_masuk_details AS A')
            ->join('barangs AS B', 'B.id', '=', 'A.barang_id')
            ->join('mereks AS C', 'C.id', '=', 'A.merek_id')
            ->select('A.id', 'B.nama AS nama_barang', 'C.nama AS nama_merek', 'A.qty', 'A.barang_id', 'A.merek_id', 'A.locator_id')
            ->where('A.barang_masuk_id', '=', $id)
            ->get();

        return $barang_masuk_details;
    }

    static function get_details_for_print($id)
    {
        $barang_masuk_details = DB::table('barang_masuk_details AS A')
            ->join('barangs AS B', 'B.id', '=', 'A.barang_id')
            ->join('mereks AS C', 'C.id', '=', 'A.merek_id')
            ->join('locators AS D', 'D.id', '=', 'A.locator_id')
            ->join('levels AS E', 'E.id', '=', 'D.level_id')
            ->join('racks AS F', 'F.id', '=', 'D.rack_id')
            ->select('A.id', 'B.nama AS nama_barang', 'C.nama AS nama_merek', 'A.qty', 'A.barang_id', 'A.merek_id', 'E.level', 'F.no AS no_rack', 'D.no AS no_locator', 'A.locator_id')
            ->where(['A.barang_masuk_id' => $id, 'A.status' => 0, 'A.trashed' => 0])
            ->get();

        return $barang_masuk_details;
    }

    static function get_detail_for_print($id)
    {
        $barang_masuk_details = DB::table('barang_masuk_details AS A')
            ->join('barangs AS B', 'B.id', '=', 'A.barang_id')
            ->join('mereks AS C', 'C.id', '=', 'A.merek_id')
            ->join('locators AS D', 'D.id', '=', 'A.locator_id')
            ->join('levels AS E', 'E.id', '=', 'D.level_id')
            ->join('racks AS F', 'F.id', '=', 'D.rack_id')
            ->select('A.id', 'B.nama AS nama_barang', 'C.nama AS nama_merek', 'A.qty', 'A.barang_id', 'A.merek_id', 'E.level', 'F.no AS no_rack', 'D.no AS no_locator', 'A.locator_id')
            ->where('A.id', '=', $id)
            ->first();

        return $barang_masuk_details;
    }

    static function isi_locator($id)
    {
        $barang_masuk_details = DB::table('barang_masuk_details AS A')
            ->join('barangs AS B', 'B.id', '=', 'A.barang_id')
            ->join('mereks AS C', 'C.id', '=', 'A.merek_id')
            ->join('barang_masuks AS D', 'D.id', '=', 'A.barang_masuk_id')
            ->join('suppliers AS E', 'E.id', '=', 'D.supplier_id')
            ->select('A.id', 'B.nama AS nama_barang', 'C.nama AS nama_merek', 'A.qty', 'A.created_at', 'E.nama AS nama_supplier')
            ->where(['A.locator_id' => $id, 'A.trashed' => 0, 'A.status' => 0, 'D.status' => 1])
            ->get();

        return $barang_masuk_details;
    }

    static function cek_locator($locator_id)
    {
        $get_data = DB::table('barang_masuk_details AS A')
            ->join('barangs AS B', 'B.id', '=', 'A.barang_id')
            ->select('A.id', 'B.nama AS nama_barang', 'A.barang_id')
            ->where(['A.locator_id' => $locator_id, 'A.status' => 0])
            ->get();

        return $get_data;
    }

    static function get_by_not_ins($not_in, $tgl_mulai, $tgl_sampai)
    {
        $datas = DB::table('barang_masuk_details AS A')
            ->join('barang_masuks AS B', 'B.id', '=', 'A.barang_masuk_id')
            ->join('suppliers AS C', 'C.id', '=', 'B.supplier_id')
            ->select('A.id', 'A.qty', 'B.created_at', 'C.nama')
            ->where(['A.not_in' => $not_in, 'B.trashed' => 0, 'B.status' => 1])
            ->whereBetween('B.created_at', [$tgl_mulai, $tgl_sampai])
            ->get();

        return $datas;
    }

    static function get_detail_for_edit($id_barang_masuk)
    {

        $sql = "(SELECT B.id AS id_barang_masuk_detail, C.id AS id_barang_masuk_detail_laporan, B.barang_id, B.merek_id, B.qty, A.trashed as trashed_header, B.trashed AS trashed_detail, B.barang_masuk_id FROM barang_masuks A INNER JOIN barang_masuk_details B ON B.barang_masuk_id=A.id INNER JOIN barang_masuk_detail_laporans C ON C.barang_masuk_id=A.id AND C.barang_id=B.barang_id AND C.merek_id=B.merek_id) AS A1";

        $sqls = DB::table(DB::raw($sql));
        $sqls->where(['A1.trashed_header' => 0, 'A1.barang_masuk_id' => $id_barang_masuk, 'A1.trashed_detail' => 0]);
        return $sqls;
    }
}
