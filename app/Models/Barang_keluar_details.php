<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Barang_keluar_details extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table   = "barang_keluar_details";

    static function get_by_not_ins($not_in, $tgl_mulai, $tgl_sampai)
    {
        $datas = DB::table('barang_keluar_details AS A')
            ->join('barang_keluars AS B', 'B.id', '=', 'A.barang_keluar_id')
            ->join('pelanggans AS C', 'C.id', '=', 'B.pelanggan_id')
            ->select('A.id', 'A.qty', 'B.created_at', 'C.nama', 'B.no_barang_keluar')
            ->where(['A.not_in' => $not_in, 'B.trashed' => 0])
            ->whereBetween('B.created_at', [$tgl_mulai, $tgl_sampai])
            ->get();

        return $datas;
    }
}
