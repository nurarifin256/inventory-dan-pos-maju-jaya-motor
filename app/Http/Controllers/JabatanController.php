<?php

namespace App\Http\Controllers;

use App\Http\Requests\JabatanRequest;
use App\Models\Ijins;
use App\Models\jabatans;
use App\Models\Menus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function Termwind\render;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Jabatan';
        return view('akses_managemen.jabatan', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jabatan = new jabatans();
        $modal_title = "Tambah Jabatan";
        $tombol = "Simpan";
        return view('akses_managemen.jabatan-action', compact('jabatan', 'modal_title', 'tombol'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JabatanRequest $request, jabatans $jabatan)
    {
        $jabatan->name       = $request->name;
        $jabatan->updated_by = Auth::user()->name;
        $jabatan->created_by = Auth::user()->name;
        $jabatan->save();

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
        $ijin = Ijins::all();
        dd($ijin);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(jabatans $jabatan)
    {

        $modal_title = "Ubah Jabatan";
        $tombol = "Ubah";
        return view('akses_managemen.jabatan-action', compact('jabatan', 'modal_title', 'tombol'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JabatanRequest $request, jabatans $jabatan)
    {
        $jabatan->name       = $request->name;
        $jabatan->updated_by = Auth::user()->name;
        $jabatan->save();

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
    public function destroy(jabatans $jabatan)
    {
        $jabatan->trashed    = 1;
        $jabatan->updated_by = Auth::user()->name;
        $jabatan->save();

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
            $btn_edit   = '<button type="button" data-id=' . $field->id . ' data-jenis="edit" class="btn btn-warning btn-sm action"><i class="ti-pencil"></i></button>';
            $btn_delete = '<button type="button" data-id=' . $field->id . ' data-jenis="delete" class="btn btn-danger btn-sm action"><i class="ti-trash"></i></button>';

            $btn_akses = '<a href="/akses/jabatan/' . $field->id . '/data_akses" class="btn btn-primary btn-sm">Lihat Akses</a>';
            $btn        = $btn_edit . ' ' . $btn_delete;

            $no++;
            $row   = array();
            $row[] = $no;
            $row[] = $field->name;
            $row[] = $btn_akses;
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
        $where  = (strlen($seacrh) > 0) ? " AND A.name LIKE '%$seacrh%' OR A.created_by LIKE '%$seacrh%' OR A.updated_by LIKE '%$seacrh%'" : "";
        $sql = "(SELECT *
                    FROM  jabatans AS A
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

    public function data_akses($id)
    {
        $title = "Edit Akses";
        $jabatan = jabatans::find($id);
        $menus = Menus::where('trashed', 0)->get();
        return view('akses_managemen.data-akses', compact('title', 'menus', 'jabatan'));
    }

    public function edit_akses(Request $request, Ijins $ijin)
    {
        $menu = $request->menu;
        $aksi = $request->aksi;
        $name = $menu . " " . $aksi;

        $cari = Ijins::where('name', $name)->first();

        if ($cari == null) {
            $ijin->name       = $name;
            $ijin->save();
        } else {
            DB::table('ijins')->where('name', $name)->delete();
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Akses berhasil di ubah'
        ]);
    }
}
