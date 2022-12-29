<div class="modal-content">
    <form id="form-action" action="" method="post">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title" id="largeModalLabel">Detail</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal Keluar</th>
                            <th>No Barang Keluar</th>
                            <th>Nama Pelanggan</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                        <tr>
                            <td>{{ $data->created_at }}</td>
                            <td>{{ $data->no_barang_keluar }}</td>
                            <td>{{ $data->nama }}</td>
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