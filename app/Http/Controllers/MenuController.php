<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuRequest;
use App\Models\jabatans;
use App\Models\Menus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Menu";
        return view('menu.menu', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modal_title = "Tambah Menu";
        $tombol = "Simpan";
        $menu = new Menus();
        $menus = Menus::getMenus();
        return view('menu.menu-action', compact('menu', 'menus', 'modal_title', 'tombol'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request, Menus $menu)
    {
        $menu->name       = $request->name;
        $menu->url        = $request->url;
        $menu->icon       = $request->icon;
        $menu->main_menu  = $request->main_menu;
        $menu->updated_by = Auth::user()->name;
        $menu->created_by = Auth::user()->name;
        $menu->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data berhasil di tambah'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        // $data = Menus::getMenus();
        $data = Menus::all();
        dd($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Menus $menu)
    {
        $modal_title = "Ubah Menu";
        $tombol      = "Ubah";
        $menus = Menus::getMenus();
        return view('menu.menu-action', compact('menu', 'menus', 'modal_title', 'tombol'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menus $menu)
    {
        $menu->name       = $request->name;
        $menu->url        = $request->url;
        $menu->icon       = $request->icon;
        $menu->main_menu  = $request->main_menu;
        $menu->updated_by = Auth::user()->name;
        $menu->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data berhasil di ubah'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menus $menu)
    {
        $menu->trashed    = 1;
        $menu->updated_by = Auth::user()->name;
        $menu->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data berhasil di hapus'
        ]);
    }

    function data_list(Request $req)
    {
        $list      = $this->get_list($req);
        $data      = array();
        $no        = $req['start'];
        foreach ($list as $field) {
            $btn_edit = '<button type="button" data-id=' . $field->id . ' data-jenis="edit" class="btn btn-warning btn-sm action"><i class="ti-pencil"></i></button>';
            $btn_delete = '<button type="button" data-id=' . $field->id . ' data-jenis="delete" class="btn btn-danger btn-sm action"><i class="ti-trash"></i></button>';
            $btn = $btn_edit . ' ' . $btn_delete;

            $no++;
            $row   = array();
            $row[] = $no;
            $row[] = $field->name;
            $row[] = $field->url;
            $row[] = $field->icon;
            $row[] = $field->main_menu == null ? "" : $field->name;
            $row[] = $btn;
            $data[] = $row;
        }

        $output = array(
            "draw"            => $req['draw'],
            "recordsTotal"    => 0,
            "recordsFiltered" => $this->count_filtered($req, 'filter'),
            "data"            => $data,
        );
        return response()->json($output);
    }

    function get_list(Request $req)
    {
        $query = $this->sql_list($req);

        if ($req['length'] != -1)
            $query->offset($req['start'])
                ->limit($req['length']);
        $query->orderBy("A1.id", "DESC");
        return $query->get();
    }


    function sql_list(Request $request)
    {
        $seacrh    = $request->search;
        $where  = (strlen($seacrh) > 0) ? " AND A.name LIKE '%$seacrh%' OR A.url LIKE '%$seacrh%' OR A.icon LIKE '%$seacrh%' OR A.main_menu LIKE '%$seacrh%'" : "";
        $sql = "(SELECT A.id, A.name, A.url, A.icon, A.main_menu
                    FROM  menuses AS A
                    WHERE A.trashed=0
                    $where 
                ) AS A1";

        $sqls = DB::table(DB::raw($sql));
        return $sqls;
    }

    function count_filtered($req, $filter = '')
    {
        $query = $this->sql_list($req, $filter);
        $query = $query->get();
        return $query->count();
    }
}
