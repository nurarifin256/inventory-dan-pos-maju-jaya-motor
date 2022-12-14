<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
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

    public function hasil(Request $request)
    {
        $title      = "Hasil Laporan Barang Masuk";
        $tgl_mulai  = $request->tgl_mulai;
        $tgl_sampai = $request->tgl_sampai;

        $datas = Laporans::laporan_barang_masuk($tgl_mulai, $tgl_sampai);
        // dd($tgl_mulai);
        dd($datas);
        return view('laporan.hasil-laporan-barang-masuk', compact('tgl_mulai', 'tgl_sampai', 'title', 'datas'));
    }
}
