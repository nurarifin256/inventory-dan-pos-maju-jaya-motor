@extends('layouts.homepage')


@push('css')
<link href="{{asset('vendor/datatables.net-dt/css/jquery.dataTables.min.css')}}" rel="stylesheet" />
<link href="{{asset('vendor/izitoast/dist/css/iziToast.min.css')}}" rel="stylesheet">
@endpush

@section('content')
<div class="main-content">
    <div class="title">
        Laporan
    </div>
    <div class="content-wrapper">
        <div class="row same-height">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Barang Masuk</h4>
                    </div>

                    <div class="card-body">
                        <div class="row mb-3 justify-content-between">
                            <div class="col-md-4">
                                <label>Dari {{ $tgl_mulai }} Sampai {{ $tgl_sampai }}</label>
                            </div>
                            <div class="col-md-4 offset-md-4">
                                <button type="button" name="print" value="print" id="btn-print"
                                    class="btn btn-sm btn-primary"><i class="ti-printer"></i> Print</button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="table-laporan-barang-masuk" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Supplier</th>
                                        <th>Nama Barang</th>
                                        <th>Nama Merek</th>
                                        <th>Qty</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $no => $data)
                                    <tr>
                                        <td>{{ ++$no }}</td>
                                        <td>{{ $data->nama_supplier }}</td>
                                        <td>{{ $data->nama_barang }}</td>
                                        <td>{{ $data->nama_merek }}</td>
                                        <td>{{ $data->total_qty }}</td>
                                        <td>detail</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('js')
<script src="{{asset('vendor/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('vendor/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('vendor/izitoast/dist/js/iziToast.min.js')}}"></script>
@endpush