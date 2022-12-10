<?php

namespace App\Http\Controllers;

use App\Models\Barang_masuk_details;
use App\Models\Barang_masuks;
use App\Models\Barangs;
use App\Models\Mereks;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (cekAkses(Auth::user()->id, "Barang Masuk", "lihat") != TRUE) {
            abort(403, 'unauthorized');
        }

        $title = "Barang Masuk";
        return view('barang.barang-masuk', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (cekAkses(Auth::user()->id, "Barang Masuk", "tambah") != TRUE) {
            abort(403, 'unauthorized');
        }

        $title     = "Tambah Barang Masuk";
        $suppliers = Supplier::where('trashed', 0)->pluck('nama', 'id');
        $barangs   = Barangs::where('trashed', 0)->pluck('nama', 'id');
        $mereks    = Mereks::where('trashed', 0)->pluck('nama', 'id');
        return view('barang.tambah-barang-masuk', compact('title', 'suppliers', 'barangs', 'mereks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Barang_masuks $barang_masuks, Barang_masuk_details $barang_masuk_detail)
    {
        if (cekAkses(Auth::user()->id, "Barang Masuk", "tambah") != TRUE) {
            abort(403, 'unauthorized');
        }

        $tanggal    = date("d/m/y");
        $get_number = Barang_masuks::get_number($tanggal);

        if ($get_number != null) {
            $nomor  = $get_number->no_barang_masuk;
            $nomor2 = explode("/", $nomor);
            $no     = $nomor2[3] + 1;
        } else {
            $no = 1;
        }

        $validated = $request->validate([
            'supplier_id' => 'required',
        ]);

        $barang_masuks->supplier_id     = $request->supplier_id;
        $barang_masuks->no_barang_masuk = $tanggal . '/' . $no;
        $barang_masuks->created_by      = Auth::user()->name;
        $barang_masuks->updated_by      = Auth::user()->name;
        $barang_masuks->save();
        $last_id = $barang_masuks->id;

        $barangs = $request->barang_id;
        $merek   = $request->merek_id;
        $qty     = $request->qty;

        foreach ($barangs as $key => $value) {
            $data = [
                [
                    'barang_masuk_id' => $last_id,
                    'barang_id'       => $value,
                    'merek_id'        => $merek[$key],
                    'qty'             => $qty[$key],
                    'not_in'          => $value . '_' . $merek[$key],
                    'created_at'      => date("y-m-d H:i:s"),
                    'created_by'      => Auth::user()->name,
                    'updated_by'      => Auth::user()->name,
                ]
            ];

            Barang_masuk_details::insert($data);
        }
        return redirect('transaksi/barang_masuk')->with([
            'message' => 'Data berhasil di tambah',
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
    public function edit($id)
    {
        if (cekAkses(Auth::user()->id, "Barang Masuk", "ubah") != TRUE) {
            abort(403, 'unauthorized');
        }

        $title               = "Edit Barang Masuk";
        $suppliers           = Supplier::where('trashed', 0)->pluck('nama', 'id');
        $barangs             = Barangs::where('trashed', 0)->pluck('nama', 'id');
        $mereks              = Mereks::where('trashed', 0)->pluck('nama', 'id');
        $barang_masuk        = Barang_masuks::find($id);
        $barang_masuk_details = Barang_masuk_details::where(['trashed' => 0, 'barang_masuk_id' => $id])->get();
        return view('barang.edit-barang-masuk', compact('title', 'suppliers', 'barangs', 'mereks', 'barang_masuk', 'barang_masuk_details'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Barang_masuks $barang_masuks, Barang_masuk_details $Barang_masuk_details, $id)
    {
        if (cekAkses(Auth::user()->id, "Barang Masuk", "ubah") != TRUE) {
            abort(403, 'unauthorized');
        }

        $barang_masuks              = Barang_masuks::find($id);
        $barang_masuks->supplier_id = $request->supplier_id;
        $barang_masuks->updated_by  = Auth::user()->name;
        $barang_masuks->save();

        $id_barang_masuk_detail = $request->id_barang_masuk_detail;
        $barangs                = $request->barang_id;
        $merek                  = $request->merek_id;
        $qty                    = $request->qty;

        // $cek_datas = DB::table("barang_masuk_details")
        //     ->where('barang_masuk_id', '=', $id)
        //     ->get();

        // foreach ($cek_datas as $values) {
        $where_not_in2 = [];
        foreach ($barangs as $key => $value) {
            $data =
                [
                    'barang_masuk_id' => $id,
                    'barang_id'       => $value,
                    'merek_id'        => $merek[$key],
                    'qty'             => $qty[$key],
                    'not_in'          => $value . '_' . $merek[$key],
                    'updated_by'      => Auth::user()->name,
                ];
            Barang_masuk_details::where('id', $id_barang_masuk_detail[$key])->update($data);
            $where_not_in2[] = $value . '_' . $merek[$key];
            // if ($id_barang_masuk_detail[$key] != null) {
            //     $ada = "ada";
            // } else {
            //     $ada = "tidak ada";
            // }
            // dd($ada);

            // $id_barang_masuk_detail = $id_barang_masuk_detail[$key];

            // $where_not_in = $value[$key] . '_' . $merek[$key];

            // if ($values->id == $id_barang_masuk_detail) {
            //     $cek = "ada";
            // } else {
            //     $cek = "tidak ada";
            // }
            // if (($values->not_in == $where_not_in) and ()) {
            //     $cek = "ada";
            // } else {
            //     $cek = "tidak ada";
            //     // Barang_masuk_details::insert($data)
            // }
            // dd($values->not_in, $where_not_in, $values->id, $id_barang_masuk_detail, $cek);
        }
        // }

        $datas = DB::table("barang_masuk_details AS A")
            ->select(DB::raw("A.*, CONCAT(A.barang_id,'_',A.merek_id) AS WHERE_NOT_IN"))
            ->whereRaw("A.barang_masuk_id=$id")
            ->whereNotIn("A.not_in", $where_not_in2)
            ->get();

        foreach ($datas as $data) {
            DB::table('barang_masuk_details')->where('id', $data->id)->update(['trashed' => 1]);
        }

        return redirect('transaksi/barang_masuk')->with([
            'message' => 'Data berhasil di ubah',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barang_masuks $barang_masuks, $id)
    {
        if (cekAkses(Auth::user()->id, "Barang Masuk", "hapus") != TRUE) {
            abort(403, 'unauthorized');
        }

        $barang_masuks             = Barang_masuks::find($id);
        $barang_masuks->trashed    = 1;
        $barang_masuks->updated_by = Auth::user()->name;
        $barang_masuks->save();

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
            if ($field->status == 0) {
                if (cekAkses(Auth::user()->id, "Barang Masuk", "ubah") == TRUE) {
                    $btn_edit   = '<a href="' . url("transaksi/barang_masuk/$field->id_barang_masuk/edit")  . '" data-id=' . $field->id_barang_masuk . ' data-jenis="edit" class="btn btn-warning btn-sm action"><i class="ti-pencil"></i></a>';
                }
            }
            if (cekAkses(Auth::user()->id, "Barang Masuk", "hapus") == TRUE) {
                $btn_delete = '<button type="button" data-id=' . $field->id_barang_masuk . ' data-jenis="delete" class="btn btn-danger btn-sm action"><i class="ti-trash"></i></button>';
            }

            $btn        = $btn_edit . ' ' . $btn_delete;

            $no++;
            $row   = array();
            $row[] = $no;
            $row[] = $field->no_barang_masuk;
            $row[] = $field->nama_supplier;
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
        $query->orderBy("A1.id_barang_masuk", "DESC");
        return $query->get();
    }


    function sql_list(Request $request)
    {
        $seacrh    = $request->search;
        $where  = (strlen($seacrh) > 0) ? " AND B.nama LIKE '%$seacrh%' OR A.created_by LIKE '%$seacrh%' OR A.no_barang_masuk LIKE '%$seacrh%'" : "";
        $sql = "(SELECT A.id AS id_barang_masuk, A.no_barang_masuk, B.nama AS nama_supplier, A.created_by, A.created_at, A.status
                    FROM  barang_masuks AS A 
                    INNER JOIN suppliers AS B ON B.id=A.supplier_id
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

    public function get_duplicate(Request $request)
    {
        $barang_id = $request->barang_id;
        // $merek_id  = $request->merek_id;


        foreach ($barang_id as $key => $value) {
            if (!empty($barang_id[$key])) {
                $cek[] = $barang_id[$key];
            }
        }

        $cek_data = array_diff_assoc($cek, array_unique($cek));

        if ($cek_data) {
            $hasil = "ada";
        } else {
            $hasil = "tidak ada";
        }

        return response()->json([
            'status'  => $hasil,
        ]);
    }
}
