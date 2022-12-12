<?php

namespace App\Http\Controllers;

use App\Models\Locators;
use App\Models\Barang_masuk_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PindahLocatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (cekAkses(Auth::user()->id, "Pindah Locator", "lihat") != TRUE) {
            abort(403, 'unauthorized');
        }

        $title = "Pindah Locator";
        return view('locator.pindah-locator', compact('title'));
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
        if (cekAkses(Auth::user()->id, "Pindah Locator", "ubah") != TRUE) {
            abort(403, 'unauthorized');
        }

        $locators = Locators::getLocatorSelected();
        $locator  = Barang_masuk_details::find($id);

        return view('locator.pindah-locator-action', compact('locators', 'locator'));
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
        if (cekAkses(Auth::user()->id, "Pindah Locator", "ubah") != TRUE) {
            abort(403, 'unauthorized');
        }

        $barang_masuk_detail  = Barang_masuk_details::find($id);
        $barang_masuk_detail->locator_id = $request->locator_id;
        $barang_masuk_detail->save();

        return response()->json([
            'message' => "Data berhasil di ubah"
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
        //
    }

    function data_list(Request $req)
    {
        $list      = $this->get_list($req);
        $data      = array();
        $no        = $req['start'];
        foreach ($list as $field) {
            $btn_edit = '';
            if (cekAkses(Auth::user()->id, "Pindah Locator", "ubah") == TRUE) {
                $btn_edit   = '<button type="button" data-id=' . $field->id_barang_masuk_details . ' data-jenis="edit" class="btn btn-warning btn-sm action"><i class="ti-pencil"></i></button>';
            }

            $locator = $field->no_rack . ' - ' . $field->level . ' - ' . $field->no_locator;

            $no++;
            $row   = array();
            $row[] = $no;
            $row[] = $field->created_at;
            $row[] = $field->nama_barang;
            $row[] = $field->nama_merek;
            $row[] = $field->qty;
            $row[] = $locator;
            $row[] = $btn_edit;
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
        $query->orderBy("A1.nama_merek", "ASC");
        return $query->get();
    }


    function sql_list(Request $request)
    {

        $seacrh    = $request->search;
        $where  = (strlen($seacrh) > 0) ? " AND A.qty LIKE '%$seacrh%' OR B.nama LIKE '%$seacrh%' OR C.nama LIKE '%$seacrh%' OR D.no LIKE '%$seacrh%' OR E.level LIKE '%$seacrh%' OR F.no LIKE '%$seacrh%'" : "";
        $sql = "(SELECT A.created_at, A.qty, A.id AS id_barang_masuk_details, B.nama AS nama_barang, C.nama AS nama_merek, D.id AS id_locator, D.no AS no_locator, E.level, F.no AS no_rack
                FROM  barang_masuk_details  A
                INNER JOIN barangs B ON B.id=A.barang_id 
                INNER JOIN mereks C ON C.id=A.merek_id 
                INNER JOIN locators D ON D.id=A.locator_id 
                INNER JOIN levels E ON E.id=D.level_id 
                INNER JOIN racks F ON F.id=D.rack_id 
                WHERE A.trashed=0 $where 
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

    public function cek_locator(Request $request)
    {
        $barang_id = $request->barang_id;
        $locator_id = $request->locator_id;

        $get_data = Barang_masuk_details::cek_locator($locator_id);
        $message = null;
        $status  = 100;
        foreach ($get_data as $value) {
            if ($value->barang_id != $barang_id) {
                $message = "locator ini sudah terisi oleh barang " . $value->nama_barang;
                $status = 200;
            }
        }

        return response()->json([
            'status'  => $status,
            'message' => $message
        ]);
    }
}
