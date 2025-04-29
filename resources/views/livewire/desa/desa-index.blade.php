<div>
    <x-slot name="header">
        <div class="mb-1 row">
            <div class="col-sm-6 d-flex align-items-center">
                <h3 class="m-0">
                    <i class="fas fa-map-marked-alt mr-2"></i> Desa
                </h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#"><i class="fas fa-folder-open"></i> Master</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <i class="fas fa-map"></i> Desa
                    </li>
                </ol>
            </div>
        </div>
    </x-slot>



    <section class="content">
        <div class="container-fluid">

            @if (session()->has('message'))
                <div class="alert alert-success">
                    <i class="fa fa-check-circle"></i> {{ session('message') }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="card-body">
                        <div class="tab-pane fade active show">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="mb-3">
                                        <a href="{{ route('desa.desa-create') }}" class="btn btn-info"
                                            wire:click="create">
                                            <i class="mr-2 fas fa-plus-square"></i>Tambah Data
                                        </a>
                                    </div>


                                    <div class="card card-info card-outline card-tabs">
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active">
                                                <div class="card-body">

                                                    <div class="mb-3 row">
                                                        <div class="col-md-3">
                                                            <input type="text" class="form-control"
                                                                placeholder="🔍 Cari Desa..."
                                                                wire:model.debounce.500ms="cari">
                                                        </div>
                                                    </div>

                                                    <div class="table-responsive">
                                                        <table
                                                            class="table table-hover table-borderless shadow rounded overflow-hidden">
                                                            <thead style="background-color: #404040; color: white;">
                                                                <tr>
                                                                    <th class="px-3 py-2">Nama</th>
                                                                    <th class="px-3 py-2">Kode</th>
                                                                    <th class="px-3 py-2">Kecamatan</th>
                                                                    <th class="px-3 py-2">Alamat</th>
                                                                    <th class="px-3 py-2 text-center">Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse ($posts as $item)
                                                                    <tr style="transition: background-color 0.2s;"
                                                                        onmouseover="this.style.background='#f0f9ff'"
                                                                        onmouseout="this.style.background='white'">
                                                                        <td class="px-3 py-2 align-middle">
                                                                            {{ $item->name }}</td>
                                                                        <td class="px-3 py-2 align-middle">
                                                                            {{ $item->kode_desa }}</td>
                                                                        <td class="px-3 py-2 align-middle">
                                                                            {{ $item->kecamatan_id }}</td>
                                                                        <td class="px-3 py-2 align-middle">
                                                                            {{ $item->alamat }}</td>
                                                                        <td
                                                                            class="px-3 py-2 text-center align-middle text-nowrap">
                                                                            <a href="{{ route('desa.desa-edit', $item->id) }}"
                                                                                class="btn btn-sm btn-warning mb-1">
                                                                                <i class="fa fa-edit"></i> Edit
                                                                            </a>
                                                                            <button
                                                                                wire:click="delete({{ $item->id }})"
                                                                                type="button"
                                                                                class="btn btn-sm btn-danger mb-1">
                                                                                <i class="fa fa-trash"></i> Hapus
                                                                            </button>
                                                                        </td>


                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="5"
                                                                            class="text-center text-muted py-4">
                                                                            <i class="fas fa-folder-open"></i> Tidak ada
                                                                            data.
                                                                        </td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="mt-3">
                                                        {{ $posts->links() }}
                                                    </div>

                                                </div> <!-- /.card-body -->
                                            </div> <!-- /.tab-pane -->
                                        </div> <!-- /.tab-content -->
                                    </div> <!-- /.card -->
                                </div>
                            </div>
                        </div>
                    </div> <!-- /.card-body -->
                </div>
            </div>

        </div>
    </section>

    {{-- Modal Tambah/Edit Desa --}}
    @if ($showModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5); z-index:1050;">
            <div class="modal-dialog" role="document">
                <form wire:submit.prevent="save" class="modal-content shadow rounded">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-map-marker-alt mr-2"></i> {{ $isEdit ? 'Edit' : 'Tambah' }} Desa
                        </h5>
                        <button type="button" class="text-white btn-close" wire:click="resetForm">
                            <span>&times;</span>
                        </button>
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
                        <button type="button" wire:click="resetForm" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
