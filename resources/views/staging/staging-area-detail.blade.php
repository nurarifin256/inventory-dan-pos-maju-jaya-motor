@extends('layouts.homepage')

@push('css')
<link href="{{asset('vendor/datatables.net-dt/css/jquery.dataTables.min.css')}}" rel="stylesheet" />
<link href="{{asset('vendor/datatables.net-responsive-dt/css/responsive.dataTables.min.css')}}" rel="stylesheet" />
<link href="{{asset('vendor/izitoast/dist/css/iziToast.min.css')}}" rel="stylesheet">
<link href="{{asset('vendor/select2/dist/css/select2.min.css')}}" rel="stylesheet">
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
                        <h4>Input ke locator</h4>
                    </div>
                    <form action="{{ route('barang_masuk.update', $barang_masuk->id) }}" method="POST"
                        id="form_barang_masuk">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="mb-2 row">
                                <label for="supplier_id" class="col-sm-2 col-form-label">No Barang Masuk</label>
                                <label for="supplier_id" class="col-sm-4 col-form-label">{{
                                    $barang_masuk->no_barang_masuk }}</label>
                            </div>
                            <div class="mb-2 row">
                                <label for="supplier_id" class="col-sm-2 col-form-label">Supplier</label>
                                <label for="supplier_id" class="col-sm-4 col-form-label">{{
                                    $barang_masuk->nama }} - {{ $barang_masuk->kode_supplier }}</label>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tabel_barang_masuk">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Barang</th>
                                            <th>Quantity</th>
                                            <th>Locator</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabel_barang">
                                        @foreach ($barang_masuk_details as $no => $barang_masuk_detail)
                                        <tr>
                                            <td>
                                                {{ ++$no }}
                                                <input type="hidden" value="{{ $barang_masuk_detail->id }}"
                                                    name="id_barang_masuk_detail[]"
                                                    id="id_barang_masuk_detail_{{ $no }}">
                                                <input type="hidden" value="{{ $barang_masuk_detail->barang_id }}"
                                                    name="barang_id[]" id="id_barang_{{ $no }}">
                                                <input type="hidden" id="id_merek_{{ $no }}"
                                                    value="{{ $barang_masuk_detail->merek_id }}" name="merek_id[]">
                                            </td>
                                            <td>
                                                <label for="">{{ $barang_masuk_detail->nama_barang }} - {{
                                                    $barang_masuk_detail->nama_merek }}</label>
                                            </td>

                                            <td>
                                                <input type="number" class="form-control" name="qty[]"
                                                    value="{{ $barang_masuk_detail->qty }}" readonly>
                                            </td>

                                            <td>
                                                <select class="form-select select_dropdown" name="locators[]"
                                                    onchange="cekLocator({{ $no }})" id="id_locator_{{ $no }}">
                                                    <option value="">Pilih Locator</option>
                                                    @foreach ($locators as $locator)
                                                    <option {{ $locator->id ==
                                                        $barang_masuk_detail->locator_id ? "selected"
                                                        : null}} value="{{ $locator->id }}">{{ $locator->no_rack }} - {{
                                                        $locator->level }} - {{$locator->no_locator }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
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
<script src="{{asset('vendor/select2/dist/js/select2.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('.select_dropdown').select2();
    })

    function cekLocator(no) {
        const barang_id              = $("#id_barang_"+no).val()
        const merek_id               = $("#id_merek_"+no).val()
        const locator_id             = $("#id_locator_"+no).val()
        const barang_masuk_detail_id = $("#id_barang_masuk_detail_"+no).val()
        const kolom = document.getElementById("id_locator_"+no)

        $.ajax({
            method: "post",
            url: "{{url('transaksi/staging_area/cek_locator')}}",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            data: {
                barang_id, merek_id, locator_id, barang_masuk_detail_id
            },
            success: function (res) {
                if (res.status == 200) {
                    iziToast.warning({
                        title: 'Peringatan',
                        message: res.message,
                        position: 'topRight'
                    });

                    kolom.innerHTML = '<option value="">Pilih Locator</option>' +
                                       '@foreach ($locators as $locator)' +
                                        '<option {{ $locator->id == $barang_masuk_detail->locator_id ? "selected": null}} value="{{ $locator->id }}">{{ $locator->no_rack }} - {{ $locator->level }} - {{$locator->no_locator }}</option>' +
                                       '@endforeach'
                }
            },
        });
    }

</script>
@endpush