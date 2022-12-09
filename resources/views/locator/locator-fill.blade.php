<div class="modal-content">
    <form id="form-action" action="" method="post">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title" id="largeModalLabel">Isi Locator</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal Masuk</th>
                            <th>Supplier</th>
                            <th>Barang</th>
                            <th>Merek</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                        <tr>
                            <td>{{ $data->created_at }}</td>
                            <td>{{ $data->nama_supplier }}</td>
                            <td>{{ $data->nama_barang }}</td>
                            <td>{{ $data->nama_merek }}</td>
                            <td>{{ $data->qty }}</td>
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