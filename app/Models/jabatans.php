<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class jabatans extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    static function getAll()
    {
        $jabatan = DB::table('jabatans')
            ->select('name', 'id');
        return $jabatan;
    }
}
