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
}
