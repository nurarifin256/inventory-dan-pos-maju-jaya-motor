<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Stocks extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table   = "stocks";

    static function get_not_in()
    {
        $datas = DB::table('stocks')->get();

        return $datas;
    }
}
