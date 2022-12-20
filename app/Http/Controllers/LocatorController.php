<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocatorRequest;
use App\Models\Barang_masuk_details;
use App\Models\Levels;
use App\Models\Locators;
use App\Models\Racks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LocatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (cekAkses(Auth::user()->id, "Locator", "lihat") != TRUE) {
            abort(403, 'unauthorized');
        }
        $title = "Locator";
        return view('locator.locator', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (cekAkses(Auth::user()->id, "Locator", "tambah") != TRUE) {
            abort(403, 'unauthorized');
        }

        $modal_title = "Tambah Data";
        $tombol      = "Tambah";
        $racks       = Racks::where('trashed', 0)->pluck('no', 'id');
        $levels      = Levels::where('trashed', 0)->pluck('level', 'id');
        $locator     = new Locators();

        return view('locator.locator-action', compact('modal_title', 'tombol', 'racks', 'levels', 'locator'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocatorRequest $request, Locators $locator)
    {
        if (cekAkses(Auth::user()->id, "Locator", "tambah") != TRUE) {
            abort(403, 'unauthorized');
        }

        $no       = $request->no;
        $level_id = $request->level_id;
        $rack_id  = $request->rack_id;

        $cek_locator = Locators::cek_locator($no, $level_id, $rack_id);

        if ($cek_locator == null) {
            $locator->no         = $no;
            $locator->level_id   = $level_id;
            $locator->rack_id    = $rack_id;
            $locator->created_by = Auth::user()->name;
            $locator->updated_by = Auth::user()->name;
            $locator->save();

            return response()->json([
                'status'  => 'success',
                'title'   => 'OK',
                'message' => 'Data berhasil di tambah'
            ]);
        } else {
            return response()->json([
                'status'  => 'error',
                'title'   => 'Error',
                'message' => 'Locator sudah terdaftar'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (cekAkses(Auth::user()->id, "Locator", "lihat") != TRUE) {
            abort(403, 'unauthorized');
        }
        $datas = Barang_masuk_details::isi_locator($id);
        return view('locator.locator-fill', compact('datas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Locators $locator)
    {
        if (cekAkses(Auth::user()->id, "Locator", "ubah") != TRUE) {
            abort(403, 'unauthorized');
        }

        $modal_title = "Ubah Data";
        $tombol      = "Ubah";
        $racks       = Racks::where('trashed', 0)->pluck('no', 'id');
        $levels      = Levels::where('trashed', 0)->pluck('level', 'id');

        return view('locator.locator-action', compact('modal_title', 'tombol', 'racks', 'levels', 'locator'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LocatorRequest $request, Locators $locator)
    {
        if (cekAkses(Auth::user()->id, "Locator", "ubah") != TRUE) {
            abort(403, 'unauthorized');
        }

        $no       = $request->no;
        $level_id = $request->level_id;
        $rack_id  = $request->rack_id;

        $cek_locator = Locators::cek_locator($no, $level_id, $rack_id);

        if ($cek_locator == null) {
            $locator->no         = $no;
            $locator->level_id   = $level_id;
            $locator->rack_id    = $rack_id;
            $locator->created_by = Auth::user()->name;
            $locator->updated_by = Auth::user()->name;
            $locator->save();

            return response()->json([
                'status'  => 'success',
                'title'   => 'OK',
                'message' => 'Data berhasil di tambah'
            ]);
        } else {
            return response()->json([
                'status'  => 'error',
                'title'   => 'Error',
                'message' => 'Locator sudah terdaftar'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Locators $locator)
    {
        if (cekAkses(Auth::user()->id, "Locator", "hapus") != TRUE) {
            abort(403, 'unauthorized');
        }

        $locator->trashed    = 1;
        $locator->updated_by = Auth::user()->name;
        $locator->save();

        return response()->json([
            'status'  => 'success',
            'title'   => 'OK',
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
            if (cekAkses(Auth::user()->id, "Locator", "ubah") == TRUE) {
                $btn_edit   = '<button type="button" data-id=' . $field->id_locators . ' data-jenis="edit" class="btn btn-warning btn-sm action"><i class="ti-pencil"></i></button>';
            }
            if (cekAkses(Auth::user()->id, "Locator", "hapus") == TRUE) {
                $btn_delete = '<button type="button" data-id=' . $field->id_locators . ' data-jenis="delete" class="btn btn-danger btn-sm action"><i class="ti-trash"></i></button>';
            }

            if (cek_isi($field->id_locators) != "") {
                $status = '<button type="button" data-id=' . $field->id_locators . ' data-jenis="lihat" class="btn btn-primary btn-sm action"><i class="ti-eye"></i> Lihat</button>';;
            } else {
                $status = "Kosong";
            }

            $btn        = $btn_edit . ' ' . $btn_delete;

            $no++;
            $row   = array();
            $row[] = $no;
            $row[] = $field->no_rack;
            $row[] = $field->level;
            $row[] = $field->no_locator;
            $row[] = $status;
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
        $query->orderBy("A1.id_locators", "DESC");
        return $query->get();
    }


    function sql_list(Request $request)
    {
        $seacrh = $request->search;
        $where  = (strlen($seacrh) > 0) ? " AND A.status LIKE '%$seacrh%' OR A.created_by LIKE '%$seacrh%' OR A.no LIKE '%$seacrh%' OR C.no LIKE '%$seacrh%' OR B.level LIKE '%$seacrh%'" : "";
        $sql    = "(SELECT C.id AS id_rack, C.no AS no_rack, B.id AS id_level, B.level, A.id AS id_locators, A.no AS no_locator, A.status, A.created_by, A.created_at
                    FROM  locators AS A
                    INNER JOIN levels AS B ON B.id=A.level_id
                    INNER JOIN racks AS C ON C.id=A.rack_id 
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
