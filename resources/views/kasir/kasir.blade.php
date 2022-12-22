@extends('layouts.homepage')


@push('css')
<link href="{{asset('vendor/datatables.net-dt/css/jquery.dataTables.min.css')}}" rel="stylesheet" />
<link href="{{asset('vendor/datatables.net-responsive-dt/css/responsive.dataTables.min.css')}}" rel="stylesheet" />
<link href="{{asset('vendor/izitoast/dist/css/iziToast.min.css')}}" rel="stylesheet">
<link href="{{ asset('vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="main-content">
    <div class="title">
        Point of Sales
    </div>
    <div class="content-wrapper">
        <div class="row same-height">
            <div class="col-md-12">

                <form action="" method="POST" id="form-kasir">
                    @csrf

                    <div class="card">
                        <div class="card-header">
                            <h4>Kasir</h4>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col">
                                    <label for="barang_id" class="form-label">Barang</label>
                                    <select class="select-harga form-select form-select-md mb-3" name="barang_id"
                                        id="barang_id" onchange="getHarga(this)">
                                        <option>Pilih Barang</option>
                                        @foreach ($barangs as $id => $nama)
                                        <option value="{{ $id }}">{{ $nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="total" class="form-label">Total</label>
                                    <input type="text" class="form-control" name="total" id="total" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="barang" class="form-label">Merek</label>
                                    <select class="select-merek form-select form-select-md mb-3" name="merek_id"
                                        id="merek_id" onchange="getStok(this)">
                                        <option>Pilih Merek</option>
                                        @foreach ($mereks as $id => $nama)
                                        <option value="{{ $id }}">{{ $nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="bayar" class="form-label">Bayar</label>
                                    <input type="text" class="form-control" autocomplete="off"
                                        onkeyup="hanya_angka(this)">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="text" id="harga" class="form-control" readonly>
                                </div>
                                <div class="col">
                                    <label for="kembali" class="form-label">Kembali</label>
                                    <input type="text" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label for="qty" class="form-label">Quantity</label>
                                    <input type="number" class="form-control" id="qty" onchange="validasiQty(this)"
                                        onkeypress="return hanyaAngka(event)">
                                </div>
                                <div class="col-md-2">
                                    <label for="" class="form-label">Stok</label>
                                    <input type="number" readonly value="0" id="stok" class="form-control">
                                </div>
                                <div class="col-md-6"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="locator_id" class="form-label">Locator</label>
                                    <select class="form-select" name="locator_id" id="locator_id">
                                        <option></option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="subtotal" class="form-label">Subtotal</label>
                                    <input type="text" class="form-control" id="subtotal" readonly>
                                </div>
                            </div>

                            <button type="button" onclick="tambahBarang()" class="btn btn-sm btn-info mt-3"><i
                                    class="ti-shopping-cart-full"></i>
                                Tambah</button>

                        </div>

                        <div class="card-body">
                            <table class="table table-bordered" id="tabel-barang">
                                <thead>
                                    <tr>
                                        <th>Barang</th>
                                        <th>Merek</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>

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
<script type="text/javascript">
    $(document).ready(function () {
        $('select').select2({
            placeholder: 'Pilih Locator'
        });
    });

    function tambahBarang() {
        const namaBarang = $('select[name=barang_id] option:selected').text()
        const namaMerek  = $('select[name=merek_id] option:selected').text()
        const idBarang   = $('#barang_id').val()
        const idMerek    = $('#merek_id').val()
        const harga      = $('#harga').val()
        const qty        = $('#qty').val()
        const subTotal   = $('#subtotal').val()
        const idLocator  = $('#locator_id').val()

        var table = document.getElementsByTagName('table')[0];
        var newRow = table.insertRow(table.rows.length);
        var cell1 = newRow.insertCell(0);
        var cell2 = newRow.insertCell(1);
        var cell3 = newRow.insertCell(2);
        var cell4 = newRow.insertCell(3);
        var cell5 = newRow.insertCell(4);
        
        cell1.innerHTML = namaBarang + '<input type="hidden" name="barangs_id[]" value="'+idBarang+'"></input>';
        cell2.innerHTML = namaMerek + '<input type="hidden" name="mereks_id[]" value="'+idMerek+'"></input>';
        cell3.innerHTML = harga + '<input type="hidden" name="harga[]" value="'+harga+'"></input>';
        cell4.innerHTML = qty + '<input type="hidden" name="qty[]" value="'+qty+'"></input><input type="hidden" name="id_barang_masuk_detail[]" value="'+idLocator+'"></input>';
        cell5.innerHTML = subTotal + '<input type="hidden" id="subtotal-tabel" name="subtotal[]" value="'+subTotal+'"></input>';

        getTotal()
    }

    function getTotal()
    {
        $.ajax({
            method: "post",
            url: `{{url('pos/kasir/get_total')}}`,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            data: $('#form-kasir').serialize(),
            success: function(res){
                $('#total').val(res.hasil)
            }
        });
    }

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

    function getHarga(data)
    {
        const barang_id = data.value;

        $.ajax({
            method: "post",
            url: `{{url('pos/kasir/get_harga')}}`,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            data: {barang_id},
            success: function(res){
                $('#harga').val(res.harga)
            }
        });
    }

    function getStok(data)
    {
        const barang_id = $('#barang_id').val();
        const merek_id  = data.value;
        const not_in = barang_id +'_'+ merek_id

        $.ajax({
            method: "post",
            url: `{{url('pos/kasir/get_stok')}}`,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            data: {barang_id, merek_id},
            success: function(res){
                stok = res.data[0].total_qty
                $('#stok').val(stok)
                getLocator(not_in)
            }
        });
    }

    function getLocator(not_in)
    {
        const selectLocator = document.getElementById("locator_id")
        $.ajax({
            method: "post",
            url: "{{ url('pos/kasir/get_locator') }}",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            data: {not_in},
            success: function(res){
                const jumlahData = res.data.length
                let options = "";
                for (let i = 0; i < jumlahData; i++) {
                    options += "<option value='"+res.data[i].id+"'>"+res.data[i].no_rack+" - "+res.data[i].level+" - "+res.data[i].no_locator+" Stok "+res.data[i].qty+"</option>"
                }
                selectLocator.innerHTML = options 
            }
        })
    }

    function validasiQty(data){
        let qty      = data.value;
        let stok     = $('#stok').val()
        let harga    = $('#harga').val()
        let qtyInt  = parseInt(qty)
        let stokInt = parseInt(stok)

        let hargaRep = harga.replace(',', '')
        let hargaInt = parseInt(hargaRep)
        let subTotal = hargaInt * qtyInt

        if (qtyInt > stokInt) {
            iziToast.warning({
                title: 'Peringatan',
                message: 'Quantity tidak boleh melebihi stok',
                position: 'topRight'
            });
            $('#qty').val('')
            $('#subtotal').val('')
        } else {
            let subTotall = rupiah(subTotal)
            $('#subtotal').val(subTotall)
        }
    }

    const rupiah = (number) => {
        return new Intl.NumberFormat("id-ID", {
        style: "decimal",
        currency: "IDR"
        }).format(number);
    }

    function hanyaAngka(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))

        return false;
        return true;
    }
</script>
@endpush