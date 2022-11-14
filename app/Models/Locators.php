<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
