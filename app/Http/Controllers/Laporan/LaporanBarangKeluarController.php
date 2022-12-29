<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Http\Requests\LaporanBarangKeluarCustomerRequest;
use App\Http\Requests\LaporanBarangKeluarRequest;
use App\Models\Barang_keluar_details;
use App\Models\Laporans;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanBarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Laporan Barang Keluar";

        return view('laporan.laporan-barang-keluar', compact('title'));
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
        if (cekAkses(Auth::user()->id, "Laporan Barang Keluar", "lihat") != TRUE) {
            abort(403, 'unauthorized');
        }

        $tgl_mulai  = $request->tgl_mulai;
        $tgl_sampai = $request->tgl_sampai;
        $datas      = Barang_keluar_details::get_by_not_ins($not_in, $tgl_mulai, $tgl_sampai);
        return view('laporan.detail-hasil-laporan-barang-keluar', compact('datas'));
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

    public function hasil(LaporanBarangKeluarRequest $request)
    {
        if (cekAkses(Auth::user()->id, "Laporan Barang Keluar", "lihat") != TRUE) {
            abort(403, 'unauthorized');
        }

        $title      = "Hasil Laporan Barang Keluar";
        $tgl_m = date('Y-m-d', strtotime($request->tgl_mulai));
        $tgl_s = date('Y-m-d', strtotime($request->tgl_sampai));
        $tgl_jam_m = $tgl_m . " 00:00:00";
        $tgl_jam_s = $tgl_s . " 23:59:00";

        $datas      = Laporans::laporan_barang_keluar($tgl_jam_m, $tgl_jam_s);

        return view('laporan.hasil-laporan-barang-keluar', compact('tgl_jam_m', 'tgl_jam_s', 'title', 'datas'));
    }

    public function print($tgl_mulai, $tgl_sampai)
    {
        $datas      = Laporans::laporan_barang_keluar($tgl_mulai, $tgl_sampai);

        $pdf = Pdf::loadView('print.print-laporan-barang-keluar', ['datas' => $datas, 'tgl_mulai' => $tgl_mulai, 'tgl_sampai' => $tgl_sampai]);
        $pdf->setBasePath(public_path());
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream("Print Laporan");
    }

    public function hasil_pelanggan(LaporanBarangKeluarCustomerRequest $request)
    {
        if (cekAkses(Auth::user()->id, "Laporan Barang Keluar", "lihat") != TRUE) {
            abort(403, 'unauthorized');
        }

        $title      = "Hasil Laporan Barang Masuk Supplier";
        $tgl_m = date('Y-m-d', strtotime($request->tgl_mulai_supplier));
        $tgl_s = date('Y-m-d', strtotime($request->tgl_sampai_supplier));
        $tgl_jam_m = $tgl_m . " 00:00:00";
        $tgl_jam_s = $tgl_s . " 23:59:00";

        $datas      = Laporans::laporan_barang_keluar_pelanggan($tgl_jam_m, $tgl_jam_s);

        return view('laporan.hasil-laporan-barang-keluar-pelanggan', compact('tgl_jam_m', 'tgl_jam_s', 'title', 'datas'));
    }

    public function detail_hasil_pelanggan(Request $request, $id_pelanggan)
    {
        if (cekAkses(Auth::user()->id, "Laporan Barang Keluar", "lihat") != TRUE) {
            abort(403, 'unauthorized');
        }

        $created_at = $request->created_at;
        $tgl_mulai  = $request->tgl_mulai;
        $tgl_sampai = $request->tgl_sampai;
        $datas      = Laporans::laporan_barang_keluar_detail_hasil_pelanggan($id_pelanggan, $tgl_mulai, $tgl_sampai);
        return view('laporan.detail-hasil-laporan-barang-masuk-pelanggan', compact('id_pelanggan', 'datas'));
    }

    public function print_pelanggan($tgl_mulai, $tgl_sampai)
    {
        $datas      = Laporans::laporan_barang_keluar_pelanggan($tgl_mulai, $tgl_sampai);

        $pdf = Pdf::loadView('print.print-laporan-barang-keluar-pelanggan', ['datas' => $datas, 'tgl_mulai' => $tgl_mulai, 'tgl_sampai' => $tgl_sampai]);
        $pdf->setBasePath(public_path());
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream("Print Laporan Pelanggan");
    }
}
