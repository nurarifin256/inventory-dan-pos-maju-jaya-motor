@extends('layouts.homepage')


@push('css')
<link href="{{asset('vendor/datatables.net-dt/css/jquery.dataTables.min.css')}}" rel="stylesheet" />
<link href="{{asset('vendor/izitoast/dist/css/iziToast.min.css')}}" rel="stylesheet">
<link href="{{asset('vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
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
                        <form action="{{ url('laporan/barang_masuk/hasil') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="datepicker-icon" class="form-label">Tanggal Mulai</label>
                                    <div class="input-group input-append date" data-date-format="dd-mm-yyyy">
                                        <input class="form-control" type="text" readonly="" autocomplete="off"
                                            name="tgl_mulai">
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="far fa-calendar-alt"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="datepicker-icon" class="form-label">Tanggal Sampai</label>
                                    <div class="input-group input-append date" data-date-format="dd-mm-yyyy">
                                        <input class="form-control" type="text" readonly="" autocomplete="off"
                                            name="tgl_sampai">
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="far fa-calendar-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="d-grid justify-content-md-end">
                                    <button type="submit" class="btn btn-primary btn-md">Lihat</button>
                                </div>
                            </div>
                        </form>
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
<script src="{{asset('vendor/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('vendor/izitoast/dist/js/iziToast.min.js')}}"></script>
<script src="{{ asset('vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $('.date').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'dd-mm-yyyy'
    }).on('changeDate', function (e) {
        console.log(e.target.value);
    });

</script>
@endpush