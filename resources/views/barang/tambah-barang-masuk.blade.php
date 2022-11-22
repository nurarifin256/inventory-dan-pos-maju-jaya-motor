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
                    <form action="{{ route('barang_masuk.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="mb-3 row">
                                <label for="supplier_id" class="col-sm-2 col-form-label">Supplier</label>
                                <div class="col-sm-6">
                                    <select class="form-select" name="supplier_id">
                                        <option value="">Pilih Supplier</option>
                                        @foreach ($suppliers as $id => $nama)
                                        <option value="{{ $id }}">{{ $nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button type="button" onclick="tambahBaris()" class="btn btn-primary">Tambah</button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td>Aksi</td>
                                            <td>Barang</td>
                                            <td>Merek</td>
                                            <td>Quantity</td>
                                        </tr>
                                    </thead>
                                    <tbody id="baris">
                                        <tr>
                                            <td>
                                            </td>
                                            <td>
                                                <select class="form-select" name="barang_id[]">
                                                    <option value="">Pilih Barang</option>
                                                    @foreach ($barangs as $id => $nama)
                                                    <option value="{{ $id }}">{{ $nama }}</option>
                                                    @endforeach
                                                </select>
                                            </td>

                                            <td>
                                                <select class="form-select" name="merek_id[]">
                                                    <option value="">Pilih Merek</option>
                                                    @foreach ($mereks as $id => $nama)
                                                    <option value="{{ $id }}">{{ $nama }}</option>
                                                    @endforeach
                                                </select>
                                            </td>

                                            <td>
                                                <input type="number" class="form-control" name="qty[]"
                                                    autocomplete="off" placeholder="Masukan quantity">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <template id="templateBaris">
                                    <tr>
                                        <td>
                                            <button type="button" id="btn-hapus" onclick="hapusBaris()"
                                                class="btn btn-danger">Hapus</button>
                                        </td>
                                        <td>
                                            <select class="form-select" name="barang_id[]">
                                                <option value="">Pilih Barang</option>
                                                @foreach ($barangs as $id => $nama)
                                                <option value="{{ $id }}">{{ $nama }}</option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td>
                                            <select class="form-select" name="merek_id[]">
                                                <option value="">Pilih Merek</option>
                                                @foreach ($mereks as $id => $nama)
                                                <option value="{{ $id }}">{{ $nama }}</option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td>
                                            <input type="number" class="form-control" name="qty[]" autocomplete="off"
                                                placeholder="Masukan quantity">
                                        </td>
                                    </tr>
                                </template>
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
    function hapusBaris()
    {
        $('#baris tr:last').remove();
    }

    function tambahBaris() {
        var template = document.querySelector('#templateBaris');
        tbl = document.querySelector('#baris');
        td_slNo = template.content.querySelectorAll("td")[0];
        var clone = document.importNode(template.content, true);
        tbl.appendChild(clone);
    }
</script>
@endpush