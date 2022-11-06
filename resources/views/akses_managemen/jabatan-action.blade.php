<div class="modal-content">
    <form id="form-action" action="{{$jabatan->id ? route('jabatan.update', $jabatan->id) : route('jabatan.store')}}"
        method="post">
        @csrf
        @if ($jabatan->id)
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
                        <label for="name" class="form-label">Nama Jabatan</label>
                        <input type="text" value="{{$jabatan->name}}" placeholder="Masukan nama" name="name"
                            class="form-control" id="name">
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