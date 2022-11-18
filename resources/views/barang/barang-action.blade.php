<div class="modal-content">
    <form id="form-action" action="{{$barang->id ? route('barang.update', $barang->id) : route('barang.store')}}"
        method="post">
        @csrf
        @if ($barang->id)
        @method('put')
        @endif
        <div class="modal-header">
            <h5 class="modal-title" id="largeModalLabel">{{$modal_title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" value="{{$barang->nama}}" placeholder="Masukan nama barang" name="nama"
                            class="form-control" id="nama">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="text" value="{{ number_format($barang->harga) }}"
                            placeholder="Masukan harga barang" name="harga" class="form-control" id="rupiah"
                            onkeyup="hanya_angka(this)">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="" class="text-label">Kategori</label>
                        <select class="form-select" name="categori_id">
                            <option value="">Pilih kategori</option>
                            @foreach ($kategori as $id => $k)
                            <option {{$barang->categori_id == $id ? "selected" : null}} value="{{$id}}">{{$k}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">{{$tombol}}</button>
        </div>
    </form>
</div>