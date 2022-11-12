<?php

namespace App\Http\Controllers;

use App\Http\Requests\LevelRequest;
use App\Models\Levels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (cekAkses(Auth::user()->id, "Level", "lihat") != TRUE) {
            abort(403, 'unauthorized');
        }

        $title = "Level";
        return view('level.level', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (cekAkses(Auth::user()->id, "Level", "tambah") != TRUE) {
            abort(403, 'unauthorized');
        }

        $modal_title = "Tambah Data";
        $tombol      = "Tambah";
        $level       = new Levels();

        return view('level.level-action', compact('modal_title', 'tombol', 'level'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LevelRequest $request, Levels $level)
    {
        if (cekAkses(Auth::user()->id, "Level", "tambah") != TRUE) {
            abort(403, 'unauthorized');
        }

        $level->level         = $request->level;
        $level->updated_by = Auth::user()->name;
        $level->created_by = Auth::user()->name;
        $level->save();

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
        $levels = Levels::all();
        dd($levels);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (cekAkses(Auth::user()->id, "Level", "ubah") != TRUE) {
            abort(403, 'unauthorized');
        }

        $modal_title = "Ubah Data";
        $tombol      = "Ubah";
        $level       = Levels::find($id);
        return view('level.level-action', compact('modal_title', 'tombol', 'level'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LevelRequest $request, $id)
    {
        if (cekAkses(Auth::user()->id, "Level", "ubah") != TRUE) {
            abort(403, 'unauthorized');
        }

        $level             = Levels::find($id);
        $level->level      = $request->level;
        $level->updated_by = Auth::user()->name;
        $level->save();

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
    public function destroy($id)
    {
        if (cekAkses(Auth::user()->id, "Level", "hapus") != TRUE) {
            abort(403, 'unauthorized');
        }

        $level             = Levels::find($id);
        $level->trashed    = 1;
        $level->updated_by = Auth::user()->name;
        $level->save();

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
            if (cekAkses(Auth::user()->id, "Level", "ubah") == TRUE) {
                $btn_edit   = '<button type="button" data-id=' . $field->id . ' data-jenis="edit" class="btn btn-warning btn-sm action"><i class="ti-pencil"></i></button>';
            }
            if (cekAkses(Auth::user()->id, "Level", "hapus") == TRUE) {
                $btn_delete = '<button type="button" data-id=' . $field->id . ' data-jenis="delete" class="btn btn-danger btn-sm action"><i class="ti-trash"></i></button>';
            }

            $btn        = $btn_edit . ' ' . $btn_delete;

            $no++;
            $row   = array();
            $row[] = $no;
            $row[] = $field->level;
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
        $where  = (strlen($seacrh) > 0) ? " AND A.level LIKE '%$seacrh%' OR A.created_by LIKE '%$seacrh%' OR A.updated_by LIKE '%$seacrh%'" : "";
        $sql = "(SELECT *
                    FROM  levels AS A
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
