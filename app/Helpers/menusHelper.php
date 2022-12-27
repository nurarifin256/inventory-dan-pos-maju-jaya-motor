<?php

use App\Models\Barang_masuk_details;
use App\Models\IjinJabatans;
use App\Models\Locators;
use App\Models\Menus;
use Illuminate\Support\Facades\DB;

if (!function_exists('getMenusSidebar')) {
    function getMenusSidebar()
    {
        return Menus::with('subMenus')->where('trashed', 0)->whereNull('main_menu')->get();
    }

    function cekAkses($id, $menu, $aksi)
    {
        $cekAkses = DB::table('users')
            ->join('jabatans', 'users.jabatan_id', '=', 'jabatans.id')
            ->join('ijin_jabatans', 'jabatans.id', '=', 'ijin_jabatans.jabatan_id')
            ->join('ijins', 'ijin_jabatans.ijin_id', '=', 'ijins.id')
            ->select('ijins.id')
            ->where([
                'users.id' => $id,
                // 'users.id' => $id,
                'ijins.name' => $menu,
                'ijins.aksi' => $aksi,
            ])
            ->first();
        if ($cekAkses != null) {
            return true;
        }
    }

    function checked($ijin_id, $jabatan_id)
    {
        $checked = IjinJabatans::where([
            'ijin_id' => $ijin_id,
            'jabatan_id' => $jabatan_id,
        ])->first();

        if ($checked != null) {
            return "checked='checked'";
        }
    }

    function cek_locators($status)
    {
        $cek_locators = Locators::where('status', $status)->first();
        if ($cek_locators != null) {
            return true;
        }
    }

    function cek_isi($id)
    {
        $cek_locators = Barang_masuk_details::where(['locator_id' => $id, 'status' => 0])->first();
        return $cek_locators;
    }

    function create_checked($id_jabatan, $name_menu, $aksi)
    {
        $result = DB::table('jabatans')
            ->join('ijin_jabatans', 'jabatans.id', '=', 'ijin_jabatans.jabatan_id')
            ->join('ijins', 'ijin_jabatans.ijin_id', '=', 'ijins.id')
            ->select('ijins.id')
            ->where([
                'jabatans.id' => $id_jabatan,
                'ijins.name' => $name_menu,
                'ijins.aksi' => $aksi,
            ])
            ->first();
        if ($result != null) {
            return true;
        }
    }
}
