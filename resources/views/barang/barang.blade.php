@extends('layouts.homepage')

@push('css')
<link href="{{asset('vendor/datatables.net-dt/css/jquery.dataTables.min.css')}}" rel="stylesheet" />
<link href="{{asset('vendor/datatables.net-responsive-dt/css/responsive.dataTables.min.css')}}" rel="stylesheet" />
<link href="{{asset('vendor/izitoast/dist/css/iziToast.min.css')}}" rel="stylesheet">
@endpush

@section('content')
<div class="main-content">
    <div class="title">
        Inventory
    </div>
    <div class="content-wrapper">
        <div class="row same-height">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Barang</h4>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-between">
                            <div class="col-md-3">
                                @if (cekAkses(Auth::user()->id, "Barang", "tambah") == TRUE)
                                <button type="button" class="btn btn-primary mb-3 btn-add">
                                    Tambah Data
                                </button>
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
                                        <th>Nama Barang</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
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
            "url" : "{{url('inventory/barang/data_list')}}",
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
                },
                error: function (res) {
                    let errors = res.responseJSON?.errors;
                    $(_form).find(".text-danger.text-small").remove();
                    if (errors) {
                        for (const [key, value] of Object.entries(errors)) {
                            $(`[name='${key}']`)
                                .parent()
                                .append(`<span class="text-danger text-small">${value}</span>`);
                        }
                    }
                },
            });
        });
    }

    $('.btn-add').on('click', function(){
        $.ajax({
            method: "get",
            url: `{{url('inventory/barang/create')}}`,
            success: function(res){
                $("#modalAction").find(".modal-dialog").html(res);
                modal.show();
                store();
            }
        })
    })

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
                        url: `{{url('inventory/barang')}}/${id}`,
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

        $.ajax({
            method: "get",
            url: `{{url('inventory/supplier')}}/${id}/edit`,
            success: function(res){
                $("#modalAction").find(".modal-dialog").html(res);
                modal.show();
                store()
            }
        })
    })

    function hanya_angka(data,urut='')
	{
		var isi   = data.value;
		var isi2  = $(this);
		let hasil = format_number(isi);
		$(data).val(hasil);
    }
    
    function format_number(number, prefix, thousand_separator, decimal_separator)
    {
        var thousand_separator = thousand_separator || ',',
            decimal_separator  = decimal_separator || '.',
            regex              = new RegExp('[^' + decimal_separator + '\\d]', 'g'),
            number_string      = number.replace(regex, '').toString(),
            split              = number_string.split(decimal_separator),
            rest               = split[0].length % 3,
            result             = split[0].substr(0, rest),
            thousands          = split[0].substr(rest).match(/\d{3}/g);

        if (thousands) {
            separator  = rest ? thousand_separator : '';
            result    += separator + thousands.join(thousand_separator);
        }
        result = split[1] != undefined ? result + decimal_separator + split[1] : result;
        return prefix == undefined ? result : (result ?  result  + prefix: '');
    };
</script>
@endpush