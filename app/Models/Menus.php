<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Menus extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $name = "menuses";

    static function getMenus()
    {
        $menus = DB::table('menuses')
            ->where('trashed', 0)
            ->whereNull('main_menu')
            ->pluck('name', 'id');

        return $menus;
    }

    static function getIdIjinIdJabatan($id)
    {
        $users = DB::table('users')
            ->join('jabatans', 'users.jabatan_id', '=', 'jabatans.id')
            ->join('ijin_jabatans', 'jabatans.id', '=', 'ijin_jabatans.jabatan_id')
            ->join('ijins', 'ijin_jabatans.ijin_id', '=', 'ijins.id')
            ->select('jabatans.id AS id_jabatan', 'ijins.id AS id_ijin')
            ->where('users.id', $id)
            ->get();
        return $users;
    }

    public function subMenus()
    {
        return $this->hasMany(Menus::class, 'main_menu');
    }
}
