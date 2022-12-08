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
        $barang_masuk_details = DB::table('barang_masuk_details AS A')
            ->join('barangs AS B', 'B.id', '=', 'A.barang_id')
            ->join('mereks AS C', 'C.id', '=', 'A.merek_id')
            ->select('A.id', 'B.nama AS nama_barang', 'C.nama AS nama_merek', 'A.qty', 'A.barang_id', 'A.merek_id', 'A.locator_id')
            ->where('A.barang_masuk_id', '=', $id)
            ->get();

        return $barang_masuk_details;
    }
}
