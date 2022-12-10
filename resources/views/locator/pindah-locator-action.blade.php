<div class="modal-content">
    <form id="form-action" action="{{ 'pindah_locator.update', $locator->id }}" method="post">
        @csrf
        @method('put')
        <div class="modal-header">
            <h5 class="modal-title" id="largeModalLabel">Pindah Locator</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="kode_supplier" class="form-label">Locator</label>
                        <select class="form-select" name="locator_id">
                            @foreach ($locators as $loc)
                            <option {{ $loc->id == $locator->locator_id ? "selected" : null}} value="{{ $loc->id }}">
                                {{ $loc->no_rack }} - {{$loc->level }} - {{$loc->no_locator }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Ubah</button>
        </div>
    </form>
</div>