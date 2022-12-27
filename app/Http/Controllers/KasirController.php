<?php

namespace App\Http\Controllers;

use App\Models\Barang_masuk_details;
use App\Models\Barang_keluar_details;
use App\Models\Barang_keluars;
use App\Models\Barangs;
use App\Models\Kasirs;
use App\Models\Mereks;
use App\Models\Pelanggans;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (cekAkses(Auth::user()->id, "Kasir", "lihat") != TRUE) {
            abort(403, 'unauthorized');
        }

        $title      = "Kasir";
        $barangs    = Barangs::where('trashed', 0)->pluck('nama', 'id');
        $mereks     = Mereks::where('trashed', 0)->pluck('nama', 'id');
        $pelanggans = Pelanggans::where('trashed', 0)->pluck('nama', 'id');
        return view('kasir.kasir', compact('title', 'barangs', 'mereks', 'pelanggans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Barang_keluars $barang_keluar)
    {
        if (cekAkses(Auth::user()->id, "Kasir", "tambah") != TRUE) {
            abort(403, 'unauthorized');
        }

        $tanggal    = date("d/m/y");
        $get_number = Barang_keluars::get_number($tanggal);

        if ($get_number != null) {
            $nomor  = $get_number->no_barang_keluar;
            $nomor2 = explode("/", $nomor);
            $no     = $nomor2[3] + 1;
        } else {
            $no = 1;
        }

        $barang_keluar->pelanggan_id     = $request->pelanggan_id;
        $barang_keluar->no_barang_keluar = $tanggal . '/' . $no;
        $barang_keluar->total            = str_replace(',', '', $request->total);
        $barang_keluar->created_by       = Auth::user()->name;
        $barang_keluar->updated_by       = Auth::user()->name;
        $barang_keluar->save();
        $last_id = $barang_keluar->id;

        $barangs                = $request->barangs_id;
        $nama_barangs           = $request->nama_barangs;
        $mereks                 = $request->mereks_id;
        $qty                    = $request->qty;
        $not_in                 = $request->not_in;
        $id_barang_masuk_detail = $request->id_barang_masuk_detail;

        foreach ($barangs as $key => $value) {
            $data = [
                [
                    'barang_keluar_id' => $last_id,
                    'barang_id'       => $value,
                    'merek_id'        => $mereks[$key],
                    'qty'             => $qty[$key],
                    'not_in'          => $not_in[$key],
                    'created_at'      => date("y-m-d H:i:s"),
                    'created_by'      => Auth::user()->name,
                    'updated_by'      => Auth::user()->name,
                ]
            ];
            Barang_keluar_details::insert($data);
            $get_qty_old = Barang_masuk_details::where('id', $id_barang_masuk_detail[$key])->first();
            $qty_now     = $get_qty_old->qty - $qty[$key];

            if ($qty_now == 0) {
                DB::table('barang_masuk_details')->where('id', $id_barang_masuk_detail[$key])->update(['qty' => $qty_now, 'status' => 1]);
            } else {
                DB::table('barang_masuk_details')->where('id', $id_barang_masuk_detail[$key])->update(['qty' => $qty_now]);
            }
        }

        // $pdf = Pdf::loadView('print.print-nota', ['barangs' => $nama_barangs]);
        // $pdf->setBasePath(public_path());
        // $pdf->setPaper('A4', 'potrait');
        // return $pdf->stream("Print Nota");

        return redirect('pos/kasir');
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

    public function get_harga(Request $request)
    {
        $barang_id = $request->barang_id;
        $data = Kasirs::get_harga($barang_id);
        $harga = number_format($data->harga);
        return response()->json([
            'harga' => $harga
        ]);
    }

    public function get_stok(Request $request)
    {
        $not_in = $request->barang_id . '_' . $request->merek_id;
        $data = Kasirs::get_stok($not_in);

        return response()->json([
            'data' => $data
        ]);
    }

    public function get_locator(Request $request)
    {
        $not_in = $request->not_in;
        $datas   = Kasirs::get_locator($not_in);
        return response()->json([
            'data' => $datas
        ]);
    }

    public function get_total(Request $request)
    {
        $subtotal = $request->subtotal;
        $subtotal_rep = str_replace('.', '', $subtotal);
        $jumlah_total = 0;
        $jumlah_total = ($jumlah_total > 0) ? ($jumlah_total) : 0;
        foreach ($subtotal_rep as $key => $value) {
            $total_set = str_replace('.', '', $subtotal[$key]);
            $jumlah_total += $total_set;
        }
        $hasil = number_format($jumlah_total);

        return response()->json([
            'hasil' => $hasil,
        ]);
    }
}
