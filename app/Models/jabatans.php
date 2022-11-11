<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class jabatans extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    static function getAll()
    {
        $jabatan = DB::table('jabatans')->pluck('name', 'id')->where('trashed', 0);
        return $jabatan;
    }

    static function getAll2()
    {
        $jabatan = DB::table('jabatans')->where('trashed', 0);
        return $jabatan;
    }
}
