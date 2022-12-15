<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Http\Requests\LaporanBarangMasukRequest;
use App\Models\Barang_masuk_details;
use App\Models\Laporans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanBarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (cekAkses(Auth::user()->id, "Laporan Barang Masuk", "lihat") != TRUE) {
            abort(403, 'unauthorized');
        }

        $title = "Laporan Barang Masuk";
        return view('laporan.laporan-barang-masuk', compact('title'));
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
    public function show(Request $request, $not_in)
    {
        $tgl_mulai  = $request->tgl_mulai;
        $tgl_sampai = $request->tgl_sampai;
        $datas      = Barang_masuk_details::get_by_not_ins($not_in, $tgl_mulai, $tgl_sampai);
        return view('laporan.detail-hasil-laporan-barang-masuk', compact('datas'));
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

    public function hasil(LaporanBarangMasukRequest $request)
    {
        $title      = "Hasil Laporan Barang Masuk";
        $tgl_mulai  = date('Y-m-d', strtotime($request->tgl_mulai));
        $tgl_sampai = date('Y-m-d', strtotime($request->tgl_sampai));
        $datas      = Laporans::laporan_barang_masuk($tgl_mulai, $tgl_sampai);

        return view('laporan.hasil-laporan-barang-masuk', compact('tgl_mulai', 'tgl_sampai', 'title', 'datas'));
    }
}
