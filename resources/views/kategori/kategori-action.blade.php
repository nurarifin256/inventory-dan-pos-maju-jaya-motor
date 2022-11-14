<div class="modal-content">
    <form id="form-action"
        action="{{$kategori->id ? route('kategori.update', $kategori->id) : route('kategori.store')}}" method="post">
        @csrf
        @if ($kategori->id)
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
                        <input type="text" value="{{$kategori->nama}}" placeholder="Masukan nama kategori" name="nama"
                            class="form-control" id="nama">
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