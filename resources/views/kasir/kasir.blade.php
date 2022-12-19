@extends('layouts.homepage')


@push('css')
<link href="{{asset('vendor/datatables.net-dt/css/jquery.dataTables.min.css')}}" rel="stylesheet" />
<link href="{{asset('vendor/datatables.net-responsive-dt/css/responsive.dataTables.min.css')}}" rel="stylesheet" />
<link href="{{asset('vendor/izitoast/dist/css/iziToast.min.css')}}" rel="stylesheet">
<link href="{{ asset('/vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="main-content">
    <div class="title">
        Point of Sales
    </div>
    <div class="content-wrapper">
        <div class="row same-height">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Kasir</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <label for="barang" class="form-label">Barang</label>
                                <select class="form-select form-select-md mb-3 select-dropdown" name="barang_id">
                                    <option value="" selected>Pilih Barang</option>
                                    @foreach ($barangs as $id => $nama)
                                    <option value="{{ $id }}">{{ $nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label for="inputEmail4" class="form-label">Email</label>
                                <input type="text" class="form-control" placeholder="Last name" aria-label="Last name">
                            </div>
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
<script src="{{asset('vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('vendor/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('vendor/izitoast/dist/js/iziToast.min.js')}}"></script>
<script src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('.select-dropdown').select2();
    });
</script>
@endpush