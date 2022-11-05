@extends('layouts.homepage')


@push('css')
<link href="{{asset('vendor/datatables.net-dt/css/jquery.dataTables.min.css')}}" rel="stylesheet" />
<link href="{{asset('vendor/datatables.net-responsive-dt/css/responsive.dataTables.min.css')}}" rel="stylesheet" />
<link href="{{asset('vendor/izitoast/dist/css/iziToast.min.css')}}" rel="stylesheet">
@endpush

@section('content')
<div class="main-content">
    <div class="title">
        Akses Managemen
    </div>
    <div class="content-wrapper">
        <div class="row same-height">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Jabatan</h4>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-primary mb-3 btn-add">
                            Tambah Data
                        </button>
                        <div class="table-responsive">
                            {{$dataTable->table()}}
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
{{$dataTable->scripts()}}
<script>
    const modal = new bootstrap.Modal($("#modalAction"));

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
                    window.LaravelDataTables["jabatandatatables-table"].ajax.reload();
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

    $("#jabatandatatables-table").on('click', '.action', function(){
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
                        url: `{{url('akses/jabatan')}}/${id}`,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        success: function (res) {
                            window.LaravelDataTables["jabatandatatables-table"].ajax.reload();
                            iziToast.success({
                                title: 'OK',
                                message: res.message,
                                position: 'topRight'
                            });
                            // store()
                        },
                    });
                }
            })
            return;
        }


        $.ajax({
            method: "get",
            url: `{{url('akses/jabatan')}}/${id}/edit`,
            success: function(res){
                $("#modalAction").find(".modal-dialog").html(res);
                modal.show();
                store()
            }
        })
    })
</script>
@endpush