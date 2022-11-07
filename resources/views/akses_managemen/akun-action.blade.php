<div class="modal-content">
    <form id="form-action" action="{{$user->id ? route('akun.update', $user->id) : route('akun.store')}}" method="post">
        @csrf
        @if ($user->id)
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
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" value="{{$user->name}}" placeholder="Masukan nama" name="name"
                            class="form-control" id="name">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" value="{{$user->email}}" placeholder="Masukan email" name="email"
                            class="form-control" id="email">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="" class="text-label">Jabatan</label>
                        <select class="form-select select_jabatan" name="jabatan_id">
                            <option value="">Pilih Jabatan</option>
                            @foreach ($jabatan as $id => $j)
                            <option {{$user->jabatan_id == $id ? "selected" : null}} value="{{$id}}">{{$j}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @if (!$user->id)
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" placeholder="Masukan password" name="password" class="form-control"
                            id="password">
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">{{$tombol}}</button>
        </div>
    </form>
</div>