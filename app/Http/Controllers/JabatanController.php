<?php

namespace App\Http\Controllers;

use App\DataTables\JabatanDataTables;
use App\Http\Requests\JabatanRequest;
use App\Models\jabatans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Termwind\render;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(JabatanDataTables $dataTable)
    {
        $title = 'Jabatan';
        return $dataTable->render('akses_managemen.jabatan', compact('title'));
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
    public function edit(jabatans $jabatan)
    {
        $modal_title = "Ubah Jabatan";
        $tombol = "Simpan";
        return view('akses_managemen.jabatan-action', compact('jabatan', 'modal_title', 'tombol'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JabatanRequest $request, jabatans $jabatan)
    {
        $jabatan->name       = $request->name;
        $jabatan->updated_by = Auth::user()->name;
        $jabatan->save();

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
    public function destroy(jabatans $jabatan)
    {
        $jabatan->trashed    = 1;
        $jabatan->updated_by = Auth::user()->name;
        $jabatan->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data berhasil di hapus'
        ]);
    }
}
