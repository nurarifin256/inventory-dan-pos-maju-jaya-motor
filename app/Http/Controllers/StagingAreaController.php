<?php

namespace App\Http\Controllers;

use App\Models\Barang_masuks;
use App\Models\Barang_masuk_details;
use App\Models\Locators;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StagingAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Staging Area";

        return view('staging.staging-area', compact('title'));
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
        $title                = "Detail Staging Area";
        $barang_masuk         = Barang_masuks::getBarangMasuk($id);
        $barang_masuk_details = Barang_masuk_details::getDetails2($id);
        $locators             = Locators::getLocators();
        return view('staging.staging-area-detail', compact('title', 'barang_masuk', 'barang_masuk_details', 'locators'));
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
    public function update(Request $request, Barang_masuks $barang_masuks, $id)
    {
        $id_barang_masuk_detail = $request->id_barang_masuk_detail;
        $locator_id             = $request->locators;

        foreach ($id_barang_masuk_detail as $key => $value) {
            $data = [
                'locator_id' => $locator_id[$key],
                'updated_by' => Auth::user()->name,
            ];
            Barang_masuk_details::where('id', $value)->update($data);
        }

        $barang_masuks             = barang_masuks::find($id);
        $barang_masuks->status     = 1;
        $barang_masuks->updated_by = Auth::user()->name;
        $barang_masuks->save();

        return redirect('transaksi/staging_area')->with([
            'message' => 'Barang berhasil di masukan ke locator',
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
            $btn_delete = '';
            if (cekAkses(Auth::user()->id, "Staging Area", "ubah") == TRUE) {
                $btn_edit   = '<a href="' . url("transaksi/staging_area/$field->id")  . '" data-id=' . $field->id . ' data-jenis="edit" class="btn btn-warning btn-sm action"><i class="ti-pencil"></i> Detail</a>';
            }

            $btn        = $btn_edit . ' ' . $btn_delete;

            $no++;
            $row   = array();
            $row[] = $no;
            $row[] = $field->no_barang_masuk;
            $row[] = $field->nama;
            $row[] = $field->kode_supplier;
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
        $where  = (strlen($seacrh) > 0) ? " AND A.no_barang_masuk LIKE '%$seacrh%' OR A.created_by LIKE '%$seacrh%' OR B.nama LIKE '%$seacrh%' OR B.kode_supplier LIKE '%$seacrh%'" : "";
        $sql = "(SELECT A.no_barang_masuk, A.created_by, B.nama, B.kode_supplier, A.id, A.created_at
                    FROM  barang_masuks A
                    INNER JOIN suppliers B ON B.id=A.supplier_id
                    WHERE A.trashed=0 AND A.status=0
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

    public function cek_locator(Request $request)
    {
        $barang_id              = $request->barang_id;
        $locator_id             = $request->locator_id;

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
