<div class="modal-content">
    <form id="form-action" action="" method="post">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title" id="largeModalLabel">Detail Barang Masuk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <label for="" class="mb-3">Supplier : {{ $barang_masuk->nama }}</label>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Barang - Merek</th>
                            <th>Qty</th>
                            <th>Locator</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang_masuk_details as $barang_masuk_detail)
                        <tr>
                            <td>{{ $barang_masuk_detail->nama_barang }} - {{ $barang_masuk_detail->nama_merek }}</td>
                            <td>{{ $barang_masuk_detail->qty }}</td>
                            <td>{{ $barang_masuk_detail->no_rack }} - {{ $barang_masuk_detail->level }} - {{
                                $barang_masuk_detail->no_locator }}</td>
                            <td><a target="_blank"
                                    href="{{ url('transaksi/barang_masuk/'.$barang_masuk_detail->id.'/print') }}"
                                    class="btn btn-sm btn-primary"><i class="ti-printer"></i></a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
    </form>
</div>