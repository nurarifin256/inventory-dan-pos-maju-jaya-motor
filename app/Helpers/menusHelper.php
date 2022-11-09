<?php

use App\Models\Menus;

if (!function_exists('getMenusSidebar')) {
    function getMenusSidebar()
    {
        return Menus::with('subMenus')->where('trashed', 0)->whereNull('main_menu')->get();
    }
}
