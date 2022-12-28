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
                        <h4>Barang Keluar</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('laporan/barang_keluar/hasil') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Barang</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="datepicker-icon" class="form-label">Tanggal Mulai</label>
                                    <div class="input-group input-append date mb-2" data-date-format="dd-mm-yyyy">
                                        <input class="form-control" type="text" readonly="" autocomplete="off"
                                            name="tgl_mulai" id="tgl_mulai_barang" value="{{ date('01-m-Y') }}"
                                            onchange="validasiTanggal2('barang')">
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="far fa-calendar-alt"></i>
                                        </button>
                                    </div>
                                    @error('tgl_mulai')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="datepicker-icon" class="form-label">Tanggal Sampai</label>
                                    <div class="input-group input-append date mb-2" data-date-format="dd-mm-yyyy">
                                        <input class="form-control" type="text" readonly="" autocomplete="off"
                                            name="tgl_sampai" id="tgl_sampai_barang" value="{{ date('d-m-Y') }}"
                                            onchange="validasiTanggal('barang')">
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="far fa-calendar-alt"></i>
                                        </button>
                                    </div>
                                    @error('tgl_sampai')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
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

                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('laporan/barang_keluar/hasil_pelanggan') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Customer</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="datepicker-icon" class="form-label">Tanggal Mulai</label>
                                    <div class="input-group input-append date mb-2" data-date-format="dd-mm-yyyy">
                                        <input class="form-control" type="text" readonly="" autocomplete="off"
                                            name="tgl_mulai_supplier" id="tgl_mulai_supplier"
                                            value="{{ date('01-m-Y') }}" onchange="validasiTanggal2('supplier')">
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="far fa-calendar-alt"></i>
                                        </button>
                                    </div>
                                    @error('tgl_mulai_supplier')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="datepicker-icon" class="form-label">Tanggal Sampai</label>
                                    <div class="input-group input-append date mb-2" data-date-format="dd-mm-yyyy">
                                        <input class="form-control" type="text" readonly="" autocomplete="off"
                                            name="tgl_sampai_supplier" id="tgl_sampai_supplier"
                                            value="{{ date('d-m-Y') }}" onchange="validasiTanggal('supplier')">
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="far fa-calendar-alt"></i>
                                        </button>
                                    </div>
                                    @error('tgl_sampai_supplier')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
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
        // console.log(e.target.value);
    });

    function validasiTanggal(data) {
        const tgl_mulai  = $('#tgl_mulai_'+data).val()
        const tgl_sampai = $('#tgl_sampai_'+data).val()

        if (tgl_sampai < tgl_mulai) {
            iziToast.warning({
                title: 'Peringatan',
                message: 'Tanggal sampai tidak boleh melewati tanggal mulai',
                position: 'topRight'
            });
            $('#tgl_sampai_'+data).val('')
        }
    }

    function validasiTanggal2(data) {
        const tgl_mulai  = $('#tgl_mulai_'+data).val()
        const tgl_sampai = $('#tgl_sampai_'+data).val()

        if (tgl_mulai > tgl_sampai) {
            iziToast.warning({
                title: 'Peringatan',
                message: 'Tanggal mulai tidak boleh melebihi tanggal sampai',
                position: 'topRight'
            });
            $('#tgl_mulai_'+data).val('')
        }
    }

</script>
@endpush