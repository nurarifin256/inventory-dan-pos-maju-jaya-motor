<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Barang_masuks extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table   = "barang_masuks";

    public function barang_masuk_details()
    {
        return $this->hasMany(Barang_masuk_details::class);
    }

    static function get_number($tanggal)
    {
        $get_number = DB::table('barang_masuks')
            ->orWhere('no_barang_masuk', 'like', '%' . $tanggal . '%')
            ->orderBy('id', 'desc')
            ->limit(1)
            ->first();

        return $get_number;
    }
}
