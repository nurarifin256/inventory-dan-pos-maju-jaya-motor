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
                        <h4>Barang Keluar Berdasarkan Pelanggan</h4>
                    </div>

                    <div class="card-body">
                        <div class="row mb-3 justify-content-between">
                            <div class="col-md-4">
                                <label>Dari {{ $tgl_mulai }} Sampai {{ $tgl_sampai }}</label>
                            </div>
                            <div class="col-md-4 offset-md-4">
                                <a target="_blank"
                                    href="{{ url('laporan/barang_keluar/'.$tgl_mulai.'/'.$tgl_sampai.'/print_pelanggan') }}"
                                    class="btn btn-sm btn-primary"><i class="ti-printer"></i> Print
                                </a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="table-laporan-barang-masuk" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pelanggan</th>
                                        <th>Jumlah Kedatangan</th>
                                        <th>Jumlah Pembelian</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas->get() as $no => $data)
                                    <tr>
                                        <td>{{ ++$no }}</td>
                                        <td>{{ $data->nama_pelanggan }}</td>
                                        <td>{{ $data->kirim }} X</td>
                                        <td>{{ $data->total_qty }} pcs</td>
                                        <td>
                                            <input type="hidden" id="supplier_id_{{ $no }}"
                                                value="{{ $data->pelanggan_id }}">
                                            <button type="button" class="btn btn-sm btn-info"
                                                onclick="detail_laporan({{ $no }})" id="detail_laporan"><i
                                                    class="ti-eye"></i></button>
                                        </td>
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
    <div class="modal fade" id="modalAction" tabindex="-1" aria-labelledby="largeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"></div>
    </div>
</div>
@endsection

@push('js')
<script src="{{asset('vendor/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('vendor/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('vendor/izitoast/dist/js/iziToast.min.js')}}"></script>
<script>
    const modal = new bootstrap.Modal($("#modalAction"));
    function detail_laporan(no)
    {
        const supplier_id = $('#supplier_id_'+no).val()
        const tgl_mulai = "{{ $tgl_mulai }}"
        const tgl_sampai = "{{ $tgl_sampai }}"

        $.ajax({
            method: "get",
            url: `{{url('laporan/barang_masuk/')}}/${supplier_id}/detail_hasil_supplier`,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            data: {tgl_mulai, tgl_sampai},
            success: function(res){
                $("#modalAction").find(".modal-dialog").html(res);
                modal.show();
            }
        });
    }
</script>
@endpush