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

                <form action="{{ route('kasir.store') }}" method="POST" id="form-kasir">
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

                                    <label for="barang" class="form-label">Pelanggan</label>
                                    <select class="select-merek form-select form-select-md" name="pelanggan_id"
                                        id="pelanggan_id">
                                        <option value="0">Pilih Pelanggan</option>
                                        @foreach ($pelanggans as $id => $nama)
                                        <option value="{{ $id }}">{{ $nama }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="barang" class="form-label">Merek</label>
                                    <select class="select-merek form-select form-select-md" name="merek_id"
                                        id="merek_id" onchange="getStok(this)">
                                        <option>Pilih Merek</option>
                                        @foreach ($mereks as $id => $nama)
                                        <option value="{{ $id }}">{{ $nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">

                                    <label for="total" class="form-label">Total</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">Rp</span>
                                        <input type="text" class="form-control" name="total" id="total" readonly>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="harga" class="form-label">Harga</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                                        <input type="text" id="harga" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col">

                                    <label for="bayar" class="form-label">Bayar</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                                        <input type="text" class="form-control" id="bayar" autocomplete="off"
                                            onkeyup="hanya_angka(this)" onchange="kembali(this)" required>
                                    </div>

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
                                <div class="col-md-6">
                                    <label for="kembali" class="form-label">Kembali</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                                        <input type="text" class="form-control" id="kembalian" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="locator_id" class="form-label">Locator</label>
                                    <select class="form-select" name="locator_id" id="locator_id">
                                        <option>Pilih Locator</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="subtotal" class="form-label">Subtotal</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">Rp</span>
                                        <input type="text" readonly class="form-control" id="subtotal">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" onclick="tambahBarang()"
                                        class="btn btn-sm btn-success mt-3"><i class="ti-shopping-cart-full"></i>
                                        Tambah</button>

                                    <button type="submit" class="btn btn-sm btn-info mt-3 ml-3"><i
                                            class="ti-desktop"></i>
                                        Bayar</button>
                                </div>
                            </div>

                        </div>

                        <div class="card-body">
                            <table class="table table-bordered" id="tabel-barang">
                                <thead>
                                    <tr>
                                        <th>Aksi</th>
                                        <th>No</th>
                                        <th>Barang</th>
                                        <th>Merek</th>
                                        <th>Harga</th>
                                        <th style="width: 10%">Qty</th>
                                        <th style="width: 20%">Subtotal</th>
                                    </tr>
                                </thead>
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
        $('select').select2();
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
        const tabel = document.getElementById("tabel-barang");
        const no = tabel.rows.length;
        const not_in = idBarang +'_'+ idMerek

        if (qty == 0) {
            iziToast.warning({
                title: 'Peringatan',
                message: 'Quantity harus di isi',
                position: 'topRight'
            });
        } else {
            var table = document.getElementsByTagName('table')[0];
            var newRow = table.insertRow(table.rows.length);
            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);
            var cell4 = newRow.insertCell(3);
            var cell5 = newRow.insertCell(4);
            var cell6 = newRow.insertCell(5);
            var cell7 = newRow.insertCell(6);
            
            cell1.innerHTML = '<button type="button" class="btn btn-danger btn-sm" onclick="hapusBaris(this)"><i class="ti-trash"></i></button>';
            cell2.innerHTML = no
            cell3.innerHTML = namaBarang + '<input type="hidden" name="barangs_id[]" value="'+idBarang+'"></input>';
            cell4.innerHTML = namaMerek + '<input type="hidden" name="mereks_id[]" value="'+idMerek+'"></input>';
            cell5.innerHTML = harga + '<input type="hidden" id="harga_tabel_'+no+'" name="harga[]" value="'+harga+'"></input>';
            cell6.innerHTML = '<input type="text" class="form-control" id="qty_tabel_'+no+'" onkeypress="return hanyaAngka(event)" onchange="updateSubtotal('+no+')" name="qty[]" value="'+qty+'"></input><input type="hidden" name="id_barang_masuk_detail[]" value="'+idLocator+'"></input><input type="hidden" name="not_in[]" value="'+not_in+'"></input><input type="hidden" name="nama_barangs[]" value="'+namaBarang+'"></input>';
            cell7.innerHTML = '<input type="text" readonly class="form-control" id="subtotal_tabel_'+no+'" name="subtotal[]" value="'+subTotal+'"></input>';
            getTotal()
            reset()
        }
    }
    
    function reset() {
        const selectBarang  = document.getElementById("barang_id")
        const selectMerek   = document.getElementById("merek_id")
        const selectLocator = document.getElementById("locator_id")

        selectBarang.innerHTML = '<option value="">Pilih Barang</option>' +
                                    '@foreach ($barangs as $id => $nama)' +
                                    '<option value="{{ $id }}">{{ $nama }}</option>' +
                                    '@endforeach'

        selectMerek.innerHTML = '<option value="">Pilih Merek</option>' +
                                    '@foreach ($mereks as $id => $nama)' +
                                    '<option value="{{ $id }}">{{ $nama }}</option>' +
                                    '@endforeach'

        selectLocator.innerHTML = '<option>Pilih Locator</option>'

        $('#harga').val('')
        $('#qty').val('')
        $('#stok').val('')
        $('#subtotal').val('')
    }

    function hapusBaris(data) {
        $(data).closest('tr').remove()
        getTotal()
    }

    function updateSubtotal(no) {
        const qty   = $('#qty_tabel_'+no).val()
        const harga = $('#harga_tabel_'+no).val()
        const hargaRep = parseInt(harga.replace(',', ''))
        // const subTotalRep = rupiah(subTotal)
        
        if (qty < 1) {
            iziToast.warning({
                title: 'Peringatan',
                message: 'Quantity tidak boleh nol',
                position: 'topRight'
            });
            $('#qty_tabel_'+no).val(1)
            const subTotal = rupiah(hargaRep * 1)
            $('#subtotal_tabel_'+no).val(subTotal)
            getTotal()
        } else {
            const subTotal = rupiah(qty * hargaRep)
            $('#subtotal_tabel_'+no).val(subTotal)
            getTotal()
        }

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

    function kembali(data){
        let total = $('#total').val()
        let bayar = data.value
        let totalRep = parseInt(total.replace(',', ''))
        let bayarRep = parseInt(bayar.replace(',', ''))

        if (bayarRep < totalRep) {
            iziToast.warning({
                title: 'Peringatan',
                message: 'Pembayaran kurang',
                position: 'topRight'
            });
            $('#bayar').val('')
            $('#kembalian').val('')
        } else {
            let kembali = bayarRep - totalRep;
            let kembalian = rupiah(kembali)
            $('#kembalian').val(kembalian)
        }
    }

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