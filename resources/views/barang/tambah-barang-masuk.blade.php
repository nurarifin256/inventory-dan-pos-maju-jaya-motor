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
                        <h4>Tambah Barang Masuk</h4>
                    </div>
                    <form action="{{ route('barang_masuk.store') }}" method="POST" id="form_barang_masuk">
                        @csrf
                        <div class="card-body">
                            <div class="mb-2 row">
                                <label for="supplier_id" class="col-sm-2 col-form-label">Supplier</label>
                                <div class="col-sm-4">
                                    <select class="form-select @error('supplier_id') is-invalid @enderror"
                                        name="supplier_id">
                                        <option value="">Pilih Supplier</option>
                                        @foreach ($suppliers as $id => $nama)
                                        <option value="{{ $id }}">{{ $nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @error('supplier_id')
                            <div class="row mb-2">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-4">
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                            </div>
                            @enderror
                            <div class="mb-3">
                                <button type="button" onclick="tambahBaris('tabel_barang_masuk')"
                                    class="btn btn-primary">Tambah Kolom</button>
                                <button type="button" onclick="hapusBaris('tabel_barang_masuk')"
                                    class="btn btn-warning">Hapus
                                    Kolom</button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tabel_barang_masuk">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Barang</th>
                                            <th>Merek</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabel_barang">
                                        <tr>
                                            <td>
                                                <input class="form-check-input" type="checkbox" name="chk[]"
                                                    id="flexCheckDefault">
                                            </td>
                                            <td>
                                                <select class="form-select" name="barang_id[]" required>
                                                    <option value="">Pilih Barang</option>
                                                    @foreach ($barangs as $id => $nama)
                                                    <option value="{{ $id }}">{{ $nama }}</option>
                                                    @endforeach
                                                </select>
                                            </td>

                                            <td>
                                                <select class="form-select" name="merek_id[]" onchange="getDuplicate()"
                                                    required>
                                                    <option value="">Pilih Merek</option>
                                                    @foreach ($mereks as $id => $nama)
                                                    <option value="{{ $id }}">{{ $nama }}</option>
                                                    @endforeach
                                                </select>
                                            </td>

                                            <td>
                                                <input type="number" class="form-control" name="qty[]"
                                                    autocomplete="off" placeholder="Masukan quantity" required>
                                            </td>
                                        </tr>
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
<script>
    function tambahBaris(tabel_barang){
        var tabel = document.getElementById("tabel_barang_masuk");
        var bacabaris = tabel.rows.length;
        var bacakolom = tabel.rows[0].cells.length;
        var tambahbaris = tabel.insertRow(bacabaris);

        for(var i=0;i<bacakolom;i++){
        var cellbaru = tambahbaris.insertCell(i);
        var isicell = tabel.rows[1].cells[i].innerHTML;
        cellbaru.innerHTML=isicell;
        }
        return false;
    }

    function hapusBaris(tabel_barang_masuk){
        var table = document.getElementById("tabel_barang_masuk");
        for (var rowi= table.rows.length; rowi--;) {
            var row= table.rows[rowi];
            var inputs= row.getElementsByTagName('input');
            for (var inputi= inputs.length; inputi--;) {
                var input= inputs[inputi];

                if (input.type==='checkbox' && input.checked) {
                    row.parentNode.removeChild(row);
                    break;
                }
            }
        }
    }

    function getDuplicate() {
        $.ajax({
            method: "post",
            url: "{{url('transaksi/barang_masuk/get_duplicate')}}",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            data: $("#form_barang_masuk").serialize(),
            success: function (res) {
                if (res.status == "ada") {
                    iziToast.warning({
                        title: 'Peringatan',
                        message: 'Item sudah di input',
                        position: 'topRight'
                    });
                }
            },
        });
    }

</script>
@endpush