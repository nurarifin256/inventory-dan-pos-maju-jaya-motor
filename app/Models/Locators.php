<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Locators extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    static function cek_locator($no, $level_id, $rack_id)
    {
        $result = Locators::where([
            'no'       => $no,
            'level_id' => $level_id,
            'rack_id'  => $rack_id,
            'trashed'  => 0
        ])->first();

        return $result;
    }

    static function get_locator_for_stok($not_in)
    {
        $locators = DB::table('barang_masuk_details AS A')
            ->join('locators AS B', 'B.id', '=', 'A.locator_id')
            ->join('levels AS C', 'C.id', '=', 'B.level_id')
            ->join('racks AS D', 'D.id', '=', 'B.rack_id')
            ->join('barang_masuks AS E', 'E.id', '=', 'A.barang_masuk_id')
            ->join('suppliers AS F', 'F.id', '=', 'E.supplier_id')
            ->select('A.id', 'C.level', 'D.no AS no_rack', 'B.no AS no_locator', 'A.qty', 'A.created_at', 'F.nama AS nama_supplier')
            ->where(['A.trashed' => 0, 'A.not_in' => $not_in])
            ->get();

        return $locators;
    }

    static function getLocators()
    {
        $locators = DB::table('locators AS A')
            ->join('levels AS B', 'B.id', '=', 'A.level_id')
            ->join('racks AS C', 'C.id', '=', 'A.rack_id')
            ->select('A.id', 'B.level', 'C.no AS no_rack', 'A.no AS no_locator', 'A.status')
            ->where(['A.trashed' => 0])
            ->get();

        return $locators;
    }

    static function getLocatorSelected()
    {
        $locators = DB::table('locators AS A')
            ->join('levels AS B', 'B.id', '=', 'A.level_id')
            ->join('racks AS C', 'C.id', '=', 'A.rack_id')
            ->select('A.id', 'B.level', 'C.no AS no_rack', 'A.no AS no_locator', 'A.status')
            ->where(['A.trashed' => 0])
            ->get();

        return $locators;
    }
}
