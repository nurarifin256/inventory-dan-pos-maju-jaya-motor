@extends('layouts.homepage')

@push('css')
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
                        <h4>Edit Data Akses {{$jabatan->name}}</h4>
                    </div>
                    <div class="card-body">
                        <input type="hidden" value="{{$jabatan->id}}" id="jabatan_id">
                        @foreach ($menus as $menu)
                        <h6 class="text-label">{{$menu->name}}</h6>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="read" data-menu="{{$menu->name}}"
                                data-aksi="lihat">
                            <label class="form-check-label" for="read">Lihat</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="create" data-menu="{{$menu->name}}"
                                data-aksi="tambah" value="">
                            <label class="form-check-label" for="create">Tambah</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="ubah" data-menu="{{$menu->name}}"
                                data-aksi="ubah" value="">
                            <label class="form-check-label" for="ubah">Ubah</label>
                        </div>
                        <div class="form-check form-check-inline mb-3">
                            <input class="form-check-input" type="checkbox" id="hapus" data-menu="{{$menu->name}}"
                                data-aksi="hapus" value="">
                            <label class="form-check-label" for="hapus">Hapus</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{asset('vendor/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('vendor/izitoast/dist/js/iziToast.min.js')}}"></script>
<script>
    $(".form-check-input").on('click', function(){
        let data = $(this).data();
        const menu = data.menu
        const aksi = data.aksi
        const jabatan_id = $("#jabatan_id").val()

        $.ajax({
            method: "post",
            url: "{{url('akses/jabatan/edit_akses')}}",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {menu, aksi, jabatan_id},
            success: function(res){
                iziToast.success({
                    title: 'OK',
                    message: res.message,
                    position: 'topRight'
                });
                // console.log(res);
            }
        })
    })
</script>
@endpush