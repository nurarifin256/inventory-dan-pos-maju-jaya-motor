<div class="modal-content">
    <form id="form-action" action="{{$level->id ? route('level.update', $level->id) : route('level.store')}}"
        method="post">
        @csrf
        @if ($level->id)
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
                        <label for="level" class="form-label">Level / Tingkat</label>
                        <input type="text" value="{{$level->level}}" placeholder="Masukan level / tingkat" name="level"
                            class="form-control" id="level">
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