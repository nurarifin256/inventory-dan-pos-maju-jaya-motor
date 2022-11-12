<div class="modal-content">
    <form id="form-action" action="{{$rack->id ? route('rak.update', $rack->id) : route('rak.store')}}" method="post">
        @csrf
        @if ($rack->id)
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
                        <label for="name" class="form-label">No / Nama Rak</label>
                        <input type="text" value="{{$rack->no}}" placeholder="Masukan nomor/rak" name="no"
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