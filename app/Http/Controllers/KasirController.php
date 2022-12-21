<?php

namespace App\Http\Controllers;

use App\Models\Barangs;
use App\Models\Kasirs;
use App\Models\Mereks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Echo_;

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

        $title = "Kasir";
        $barangs = Barangs::where('trashed', 0)->pluck('nama', 'id');
        $mereks = Mereks::where('trashed', 0)->pluck('nama', 'id');
        return view('kasir.kasir', compact('title', 'barangs', 'mereks'));
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
}
