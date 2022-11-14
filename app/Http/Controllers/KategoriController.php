<?php

namespace App\Http\Controllers;

use App\Http\Requests\KategoriRequest;
use App\Models\Kategoris;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (cekAkses(Auth::user()->id, "Kategori Barang", "lihat") != TRUE) {
            abort(403, 'unauthorized');
        }

        $title = "Kategori Barang";
        return view('kategori.kategori', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (cekAkses(Auth::user()->id, "Kategori Barang", "tambah") != TRUE) {
            abort(403, 'unauthorized');
        }

        $modal_title = "Tambah Data";
        $tombol      = "Tambah";
        $kategori    = new Kategoris();

        return view('kategori.kategori-action', compact('modal_title', 'tombol', 'kategori'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KategoriRequest $request, Kategoris $kategori)
    {
        if (cekAkses(Auth::user()->id, "Kategori Barang", "tambah") != TRUE) {
            abort(403, 'unauthorized');
        }

        $kategori->nama = $request->nama;
        $kategori->created_by = Auth::user()->name;
        $kategori->updated_by = Auth::user()->name;
        $kategori->save();

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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Kategoris $kategori)
    {
        if (cekAkses(Auth::user()->id, "Kategori Barang", "ubah") != TRUE) {
            abort(403, 'unauthorized');
        }

        $modal_title = "Ubah Data";
        $tombol      = "Ubah";

        return view('kategori.kategori-action', compact('modal_title', 'tombol', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KategoriRequest $request, Kategoris $kategori)
    {
        if (cekAkses(Auth::user()->id, "Kategori Barang", "ubah") != TRUE) {
            abort(403, 'unauthorized');
        }

        $kategori->nama = $request->nama;
        $kategori->updated_by = Auth::user()->name;
        $kategori->save();

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
    public function destroy(Kategoris $kategori)
    {
        if (cekAkses(Auth::user()->id, "Kategori Barang", "hapus") != TRUE) {
            abort(403, 'unauthorized');
        }

        $kategori->trashed    = 1;
        $kategori->updated_by = Auth::user()->name;
        $kategori->save();

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
            $btn_edit = '';
            $btn_delete = '';
            if (cekAkses(Auth::user()->id, "Kategori Barang", "ubah") == TRUE) {
                $btn_edit   = '<button type="button" data-id=' . $field->id . ' data-jenis="edit" class="btn btn-warning btn-sm action"><i class="ti-pencil"></i></button>';
            }
            if (cekAkses(Auth::user()->id, "Kategori Barang", "hapus") == TRUE) {
                $btn_delete = '<button type="button" data-id=' . $field->id . ' data-jenis="delete" class="btn btn-danger btn-sm action"><i class="ti-trash"></i></button>';
            }

            $btn        = $btn_edit . ' ' . $btn_delete;

            $no++;
            $row   = array();
            $row[] = $no;
            $row[] = $field->nama;
            $row[] = $field->created_at;
            $row[] = $field->created_by;
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
        $where  = (strlen($seacrh) > 0) ? " AND A.nama LIKE '%$seacrh%' OR A.created_by LIKE '%$seacrh%'" : "";
        $sql = "(SELECT *
                    FROM  kategoris AS A
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
