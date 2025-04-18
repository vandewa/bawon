<div>
    <x-slot name="header">
        <div class="mb-1 row">
            <div class="col-sm-6">
                <h3 class="m-0">Paket Pekerjaan</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Master</a></li>
                    <li class="breadcrumb-item active">Paket Pekerjaan</li>
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
                            <div class="tab-pane active show fade" id="custom-tabs-one-rm" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <button class="btn btn-info" wire:click="create">
                                                <i class="mr-2 fas fa-plus-square"></i>Tambah Data
                                            </button>
                                        </div>
                                        <div class="card card-info card-outline card-tabs">
                                            <div class="tab-content">
                                                <div class="tab-pane fade show active">
                                                    <div class="card-body">
                                                        <div class="mb-3 row">
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Cari kegiatan..."
                                                                    wire:model.live="cari">
                                                            </div>
                                                        </div>

                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Desa</th>
                                                                        <th>Tahun</th>
                                                                        <th>Kegiatan</th>
                                                                        <th>Sumber Dana</th>
                                                                        <th>Pagu</th>
                                                                        <th>Aksi</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($posts as $item)
                                                                        <tr>
                                                                            <td>{{ $item->desa->name ?? '-' }}</td>
                                                                            <td>{{ $item->tahun }}</td>
                                                                            <td>{{ $item->nama_kegiatan }}</td>
                                                                            <td>{{ $item->sumberdana }}</td>
                                                                            <td class="text-right">
                                                                                {{ number_format($item->pagu_pak, 0, ',', '.') }}
                                                                            </td>
                                                                            </td>
                                                                            <td>
                                                                                <button class="btn btn-sm btn-warning"
                                                                                    wire:click="edit({{ $item->id }})">Edit</button>
                                                                                <button class="btn btn-sm btn-danger"
                                                                                    wire:click="delete({{ $item->id }})">Hapus</button>
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
                        <h5 class="modal-title">{{ $isEdit ? 'Edit' : 'Tambah' }} Paket Pekerjaan</h5>
                        <button type="button" class="close" wire:click="resetForm"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Desa</label>
                            <select wire:model.live="desa_id" class="form-control">
                                <option value="">-- Pilih Desa --</option>
                                @foreach ($desas as $desa)
                                    <option value="{{ $desa->id }}">{{ $desa->name }}</option>
                                @endforeach
                            </select>
                            @error('desa_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Tahun</label>
                            <input type="number" class="form-control" wire:model.live="tahun">
                            @error('tahun')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nama Kegiatan</label>
                            <input type="text" class="form-control" wire:model.live="nama_kegiatan">
                            @error('nama_kegiatan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Sumber Dana</label>
                            <input type="text" class="form-control" wire:model.live="sumberdana">
                            @error('sumberdana')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
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

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush
</div>
