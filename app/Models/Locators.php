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
