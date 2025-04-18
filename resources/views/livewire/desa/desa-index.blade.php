<div>
    <x-slot name="header">
        <div class="mb-1 row">
            <div class="col-sm-6">
                <h3 class="m-0">Desa</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Master</a></li>
                    <li class="breadcrumb-item active">Desa</li>
                </ol>
            </div>
        </div>
    </x-slot>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-body">
                        <div class="tab-pane fade active show">
                            <div class="tab-pane active show fade" id="custom-tabs-one-rm" role="tabpanel"
                                aria-labelledby="custom-tabs-one-rm-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <button class="btn btn-info" wire:click="create">
                                                <i class="mr-2 fas fa-plus-square"></i>Tambah Data
                                            </button>
                                        </div>
                                        <div class="card card-info card-outline card-tabs">
                                            <div class="tab-content" id="custom-tabs-six-tabContent">
                                                <div class="tab-pane fade show active" id="custom-tabs-six-riwayat-rm"
                                                    role="tabpanel" aria-labelledby="custom-tabs-six-riwayat-rm-tab">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="mb-2 col-md-2">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Search" wire:model.live='cari'>
                                                            </div>
                                                        </div>

                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nama</th>
                                                                        <th>Kode</th>
                                                                        <th>Kecamatan</th>
                                                                        <th>Alamat</th>
                                                                        <th>Aksi</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($posts as $item)
                                                                        <tr>
                                                                            <td>{{ $item->name }}</td>
                                                                            <td>{{ $item->kode_desa }}</td>
                                                                            <td>{{ $item->kecamatan_id }}</td>
                                                                            <td>{{ $item->alamat }}</td>
                                                                            <td>
                                                                                <button type="button"
                                                                                    class="btn btn-sm btn-warning"
                                                                                    wire:click="edit({{ $item->id }})">Edit
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-sm btn-danger"
                                                                                    wire:click="delete({{ $item->id }})">Hapus
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        {{ $posts->links() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>

    {{-- Modal Native Livewire --}}
    @if ($showModal)
        <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog" role="document">
                <form wire:submit.prevent="save" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $isEdit ? 'Edit' : 'Tambah' }} Desa</h5>
                        <button type="button" class="close" wire:click="resetForm"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Desa</label>
                            <input type="text" class="form-control" wire:model.live="name">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Kode Desa</label>
                            <input type="text" class="form-control" wire:model.live="kode_desa">
                            @error('kode_desa')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Kecamatan ID</label>
                            <input type="text" class="form-control" wire:model.live="kecamatan_id">
                            @error('kecamatan_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <input type="text" class="form-control" wire:model.live="alamat">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="resetForm" class="btn btn-secondary">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
