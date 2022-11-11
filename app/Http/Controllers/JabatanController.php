<?php

namespace App\Http\Controllers;

use App\Http\Requests\JabatanRequest;
use App\Models\IjinJabatans;
use App\Models\Ijins;
use App\Models\jabatans;
use App\Models\Menus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

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
        if (cekAkses(Auth::user()->id, "Jabatan", "lihat") != TRUE) {
            abort(403, 'unauthorized');
        }
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
        if (cekAkses(Auth::user()->id, "Jabatan", "tambah") != TRUE) {
            abort(403, 'unauthorized');
        }

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
        if (cekAkses(Auth::user()->id, "Jabatan", "tambah") != TRUE) {
            abort(403, 'unauthorized');
        }

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
    public function show(jabatans $jabatans)
    {
        $ijin = $jabatans->getAll2()->get();
        dd($ijin[0]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(jabatans $jabatan)
    {
        if (cekAkses(Auth::user()->id, "Jabatan", "ubah") != TRUE) {
            abort(403, 'unauthorized');
        }

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
        if (cekAkses(Auth::user()->id, "Jabatan", "ubah") != TRUE) {
            abort(403, 'unauthorized');
        }

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
        if (cekAkses(Auth::user()->id, "Jabatan", "hapus") != TRUE) {
            abort(403, 'unauthorized');
        }

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
            if (cekAkses(Auth::user()->id, "Jabatan", "ubah") == TRUE) {
                $btn_edit   = '<button type="button" data-id=' . $field->id . ' data-jenis="edit" class="btn btn-warning btn-sm action"><i class="ti-pencil"></i></button>';
            } else {
                $btn_edit = '';
            }
            if (cekAkses(Auth::user()->id, "Jabatan", "hapus") == TRUE) {
                $btn_delete = '<button type="button" data-id=' . $field->id . ' data-jenis="delete" class="btn btn-danger btn-sm action"><i class="ti-trash"></i></button>';
            } else {
                $btn_delete = '';
            }

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

        $id_user = Auth::user()->id;
        $idJabatan = Menus::getIdIjinIdJabatan($id_user);
        $jabatan = jabatans::find($id);
        $menus = Menus::where('trashed', 0)->get();
        return view('akses_managemen.data-akses', compact('title', 'menus', 'jabatan', 'idJabatan'));
    }

    public function edit_akses(Request $request, Ijins $ijin, IjinJabatans $ijinJabatan)
    {
        $menu       = $request->menu;
        $aksi       = $request->aksi;
        $jabatan_id = $request->jabatan_id;

        $cek = DB::table('ijin_jabatans AS A')
            ->join('ijins AS B', 'B.id', '=', 'A.ijin_id')
            ->select('B.id')
            ->where([
                'B.name' => $menu,
                'B.aksi' => $aksi,
                'A.jabatan_id' => $jabatan_id
            ])
            ->first();

        if ($cek == null) {
            $ijin->name       = $menu;
            $ijin->aksi       = $aksi;
            $ijin->save();
            $last_id = $ijin->id;

            $ijinJabatan->ijin_id    = $last_id;
            $ijinJabatan->jabatan_id = $jabatan_id;
            $ijinJabatan->save();
        } else {
            DB::table('ijin_jabatans')->where([
                'ijin_id' => $cek->id,
                'jabatan_id' => $jabatan_id,
            ])->delete();
            DB::table('ijins')->where([
                'id' => $cek->id,
            ])->delete();
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Akses berhasil di ubah'
        ]);
    }
}
