<?php

namespace App\Http\Controllers;

use App\Http\Requests\AkunRequest;
use App\Models\jabatans;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (cekAkses(Auth::user()->id, "Akun", "lihat") != TRUE) {
            abort(403, 'unauthorized');
        }
        $title = 'Akun';
        return view('akses_managemen.akun', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (cekAkses(Auth::user()->id, "Akun", "tambah") != TRUE) {
            abort(403, 'unauthorized');
        }

        $modal_title = "Tambah Jabatan";
        $tombol      = "Simpan";
        $jabatan     = jabatans::where('trashed', 0)->pluck('name', 'id');
        $user        = new User();
        return view('akses_managemen.akun-action', compact('user', 'jabatan', 'modal_title', 'tombol'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AkunRequest $request, User $user)
    {
        if (cekAkses(Auth::user()->id, "Akun", "tambah") != TRUE) {
            abort(403, 'unauthorized');
        }

        $user->name       = $request->name;
        $user->email      = $request->email;
        $user->jabatan_id = $request->jabatan_id;
        $user->password   = Hash::make($request->password);
        $user->updated_by = Auth::user()->name;
        $user->created_by = Auth::user()->name;
        $user->save();

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
    public function show(User $user)
    {
        $user = User::all();
        // dd($user);
        foreach ($user as $u) {
            echo $u->name;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if (cekAkses(Auth::user()->id, "Akun", "ubah") != TRUE) {
            abort(403, 'unauthorized');
        }

        $modal_title = "Ubah Akun";
        $tombol      = "Ubah";
        $user        = User::find($id);
        $jabatan     = jabatans::getAll();
        return view('akses_managemen.akun-action', compact('user', 'jabatan', 'modal_title', 'tombol'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, $id)
    {
        if (cekAkses(Auth::user()->id, "Akun", "ubah") != TRUE) {
            abort(403, 'unauthorized');
        }

        $user             = User::find($id);
        $user->name       = $request->name;
        $user->email      = $request->email;
        $user->jabatan_id = $request->jabatan_id;
        $user->updated_by = Auth::user()->name;
        $user->save();

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
    public function destroy(User $user, $id)
    {
        if (cekAkses(Auth::user()->id, "Akun", "hapus") != TRUE) {
            abort(403, 'unauthorized');
        }

        $user             = User::find($id);
        $user->trashed    = 1;
        $user->updated_by = Auth::user()->name;
        $user->save();

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
            $btn_edit   = '';
            $btn_delete = '';

            if (cekAkses(Auth::user()->id, "Akun", "ubah") == TRUE) {
                $btn_edit = '<button type="button" data-id=' . $field->id_user . ' data-jenis="edit" class="btn btn-warning btn-sm action"><i class="ti-pencil"></i></button>';
            }
            if (cekAkses(Auth::user()->id, "Akun", "hapus") == TRUE) {
                $btn_delete = '<button type="button" data-id=' . $field->id_user . ' data-jenis="delete" class="btn btn-danger btn-sm action"><i class="ti-trash"></i></button>';
            }
            $btn = $btn_edit . ' ' . $btn_delete;

            $no++;
            $row = array();
            $row[]    = $no;
            $row[]    = $field->nama_user;
            $row[]    = $field->email;
            $row[]    = $field->nama_jabatan;
            $row[]    = $field->status_user == 0 ? "Aktif" : "Non Aktif";
            $row[]    = $field->created_at;
            $row[]    = $field->created_by;
            $row[]    = $btn;
            $data[]    = $row;
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
        $query->orderBy("A1.id_user", "DESC");
        return $query->get();
    }


    function sql_list(Request $request)
    {
        $seacrh    = $request->search;
        $where  = (strlen($seacrh) > 0) ? " AND A.name LIKE '%$seacrh%' OR A.created_by LIKE '%$seacrh%' OR A.updated_by LIKE '%$seacrh%' OR B.name LIKE '%$seacrh%' OR B.email LIKE '%$seacrh%'" : "";
        $sql = "(SELECT B.id AS id_user, B.name AS nama_user, B.email, A.id AS id_jabatan, A.name AS nama_jabatan, B.created_at, B.created_by, B.status AS status_user
                    FROM  jabatans AS A
                    INNER JOIN users AS B ON B.jabatan_id=A.id
                    WHERE B.trashed=0
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
