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
                    <div class="card-header">
                        <h4>Pindah Locator</h4>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-between">
                            <div class="col-md-3">
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
                            <table id="table-pindah-locator" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Nama Barang</th>
                                        <th>Nama Merek</th>
                                        <th>Qty</th>
                                        <th>Locator</th>
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
    table = $('#table-pindah-locator').DataTable({
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
            "url" : "{{url('transaksi/pindah_locator/data_list')}}",
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

    function store() {
        $("#form-action").on("submit", function (e) {
            e.preventDefault();
            const _form = this;
            const formData = new FormData(_form);

            const url = this.getAttribute('action')

            $.ajax({
                method: "post",
                url,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    table.ajax.reload();
                    modal.hide();
                    iziToast.success({
                        title: 'OK',
                        message: res.message,
                        position: 'topRight'
                    });
                }
            });
        });
    }

    $("#table-pindah-locator").on('click', '.action', function(){
        let data  = $(this).data();
        let id    = data.id;

        $.ajax({
            method: "get",
            url: `{{url('transaksi/pindah_locator')}}/${id}/edit`,
            success: function(res){
                $("#modalAction").find(".modal-dialog").html(res);
                modal.show();
                store()
            }
        })
    })

    function cekLocator()
    {
        const barang_id  = $("#barang_id").val()
        const locator_id = $("#locator_id").val()
        const modall     = $('#modalAction');


        $.ajax({
            method: "post",
            url: "{{url('transaksi/pindah_locator/cek_locator')}}",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            data: {
                barang_id, locator_id,
            },
            success: function (res) {
                if (res.status == 200) {
                    iziToast.warning({
                        title: 'Peringatan',
                        message: res.message,
                        position: 'topRight'
                    });
                    modall.modal('toggle');
                }
            },
        });
    }
    
</script>
@endpush