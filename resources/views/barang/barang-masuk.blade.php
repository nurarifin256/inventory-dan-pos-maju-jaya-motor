@extends('layouts.homepage')

@push('css')
<link href="{{asset('vendor/datatables.net-dt/css/jquery.dataTables.min.css')}}" rel="stylesheet" />
<link href="{{asset('vendor/datatables.net-responsive-dt/css/responsive.dataTables.min.css')}}" rel="stylesheet" />
<link href="{{asset('vendor/izitoast/dist/css/iziToast.min.css')}}" rel="stylesheet">
@endpush

@section('content')
<div class="main-content">
    <div class="title">
        Transaksi
    </div>
    <div class="content-wrapper">
        <div class="row same-height">
            <div class="col-md-12">
                <div class="card">

                    @if (session()->has('message'))
                    <div class="flash-data" data-flashdata="{{session()->get('message')}}">
                    </div>
                    @endif

                    <div class="card-header">
                        <h4>Barang Masuk</h4>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-between">
                            <div class="col-md-3">
                                @if (cekAkses(Auth::user()->id, "Barang Masuk", "tambah") == TRUE)
                                <a href="{{url('transaksi/barang_masuk/create')}}" type="button"
                                    class="btn btn-primary mb-3">
                                    Tambah Data
                                </a>
                                @endif
                            </div>
                            <div class="offset-md-4 col-md-3">
                                <input type="text" class="form-control" name="search" id="search" autofocus
                                    autocomplete="off">
                            </div>
                            <div class="col-md-2">
                                <button type="button" name="find" value="find" id="btn-cari"
                                    class="btn btn-sm btn-success"><i class="ti-search"></i></button>
                                <button type="button" name="reset" value="reset" id="btn-reset"
                                    class="btn btn-sm btn-primary"><i class="ti-reload"></i></button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="table-barang" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor Barang Masuk</th>
                                        <th>Supplier</th>
                                        <th>Tanggal Di Buat</th>
                                        <th>Di Buat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAction" tabindex="-1" aria-labelledby="largeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md"></div>
    </div>
</div>

@endsection

@push('js')
<script src="{{asset('vendor/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('vendor/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('vendor/izitoast/dist/js/iziToast.min.js')}}"></script>
<script>
    const modal = new bootstrap.Modal($("#modalAction"));
    var table;
    table = $('#table-barang').DataTable({
        'processing': true,
        'serverSide': true,
        'responsive': true,
        'ordering': false,
        'orderable': false,
        'lengthChange': true,
        'sDom': 'lrtip',
        language      : {
            processing    : '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>',
            "infoFiltered": ""
        },
        "order"       : [],
        "ajax"        : {
            "url" : "{{url('transaksi/barang_masuk/data_list')}}",
            "type": "POST",
            "headers": {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            "data": function(data) {
                data.search  = $('#search').val()
            }
        },
    });
    $('#btn-cari').click(function(){
        table.ajax.reload(); 
    });
    $('#btn-reset').click(function() {
        $('#search').val("");
        table.ajax.reload();
    });

    $("#table-barang").on('click', '.action', function(){
        let data  = $(this).data();
        let id    = data.id;
        let jenis = data.jenis;

        if (jenis == 'delete') {
            Swal.fire({
                title: 'Anda Yakin?',
                text: "Mau menghapus data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "delete",
                        url: `{{url('transaksi/barang_masuk')}}/${id}`,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        success: function (res) {
                            table.ajax.reload();
                            iziToast.success({
                                title: 'OK',
                                message: res.message,
                                position: 'topRight'
                            });
                        },
                    });
                }
            })
            return;
        }
    })

    const flashData = $('.flash-data').data('flashdata');

    if (flashData) {
        iziToast.success({
            title: 'OK',
            message: flashData,
            position: 'topRight'
        });
    }

</script>
@endpush