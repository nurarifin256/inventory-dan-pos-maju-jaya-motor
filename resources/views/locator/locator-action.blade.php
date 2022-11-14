<div class="modal-content">
    <form id="form-action" action="{{$locator->id ? route('locator.update', $locator->id) : route('locator.store')}}"
        method="post">
        @csrf
        @if ($locator->id)
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
                        <label for="no" class="form-label">Nomor</label>
                        <input type="number" value="{{$locator->no}}" placeholder="Masukan nomor locator" name="no"
                            class="form-control" id="no">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="" class="text-label">Level</label>
                        <select class="form-select" name="level_id">
                            <option value="">Pilih level</option>
                            @foreach ($levels as $id => $l)
                            <option {{$locator->level_id == $id ? "selected" : null}} value="{{$id}}">{{$l}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="" class="text-label">Rak</label>
                        <select class="form-select" name="rack_id">
                            <option value="">Pilih Rak</option>
                            @foreach ($racks as $id => $r)
                            <option {{$locator->rack_id == $id ? "selected" : null}} value="{{$id}}">{{$r}}</option>
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