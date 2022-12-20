<?php

namespace App\Http\Controllers;

use App\Models\Locators;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (cekAkses(Auth::user()->id, "Stok", "lihat") != TRUE) {
            abort(403, 'unauthorized');
        }

        $title = "Stok Barang";
        return view('stok.stok', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($not_in)
    {
        if (cekAkses(Auth::user()->id, "Stok", "lihat") != TRUE) {
            abort(403, 'unauthorized');
        }

        $datas = Locators::get_locator_for_stok($not_in);
        return view('stok.stok-detail', compact('datas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    function data_list(Request $req)
    {
        $list      = $this->get_list($req);
        $data      = array();
        $no        = $req['start'];
        foreach ($list as $field) {
            $btn_edit = '';
            $btn_delete = '';
            if (cekAkses(Auth::user()->id, "Stok", "lihat") == TRUE) {
                $btn_edit   = '<button type="button" data-id=' . $field->not_in . ' data-jenis="lihat" class="btn btn-info btn-sm action"><i class="ti-eye"></i> Detail</button>';
            }

            $btn        = $btn_edit . ' ' . $btn_delete;

            $no++;
            $row   = array();
            $row[] = $no;
            $row[] = $field->nama_barang;
            $row[] = $field->nama_merek;
            $row[] = $field->qty_total;
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
        $query->orderBy("A1.nama_barang", "ASC");
        return $query->get();
    }


    function sql_list(Request $request)
    {

        $seacrh    = $request->search;
        $where  = (strlen($seacrh) > 0) ? " AND A.nama LIKE '%$seacrh%' OR C.nama LIKE '%$seacrh%' OR A2.qty_total LIKE '%$seacrh%'" : "";
        $sql = "(SELECT A.nama AS nama_barang, C.nama AS nama_merek, A2.qty_total, A2.id_barang_masuk_detail, A2.not_in
                FROM 
                    (SELECT B.id AS id_barang_masuk_detail, B.barang_id, B.merek_id, B.barang_masuk_id, B.not_in, SUM(B.qty) AS qty_total FROM barang_masuk_details B INNER JOIN barang_masuks D ON D.id=B.barang_masuk_id WHERE B.trashed=0 AND B.status=0 AND D.status=1 GROUP BY B.not_in) AS A2
                INNER JOIN barangs A ON A.id=A2.barang_id 
                INNER JOIN mereks C ON C.id=A2.merek_id 
                WHERE 1=1 $where 
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
