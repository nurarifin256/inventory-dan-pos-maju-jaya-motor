<div class="modal-content">
    <form id="form-action" action="{{$menu->id ? route('menu.update', $menu->id) : route('menu.store')}}" method="post">
        @csrf
        @if ($menu->id)
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
                        <label for="name" class="form-label">Nama Menu</label>
                        <input type="text" value="{{$menu->name}}" placeholder="Masukan nama" name="name"
                            class="form-control" id="name">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="url" class="form-label">Url</label>
                        <input type="text" value="{{$menu->url}}" placeholder="Masukan url" name="url"
                            class="form-control" id="url">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="icon" class="form-label">Icon</label>
                        <input type="text" value="{{$menu->icon}}" placeholder="Masukan icon" name="icon"
                            class="form-control" id="icon">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="main_mneu" class="form-label">Menu Utama</label>
                        <select class="form-control" name="main_menu" id="">
                            <option value="">-- Default --</option>
                            @foreach($menus as $id => $main_menu)
                            <option value="{{ $id }}">{{ $main_menu }}</option>
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