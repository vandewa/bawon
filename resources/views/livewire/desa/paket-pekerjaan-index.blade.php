<div>
    <x-slot name="header">
        <div class="mb-1 row">
            <div class="col-sm-6 d-flex align-items-center">
                <h3 class="m-0">
                    <i class="fa fa-tasks mr-2"></i> Paket Pekerjaan
                </h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#"><i class="fa fa-folder-open"></i> Master</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <i class="fa fa-list"></i> Paket Pekerjaan
                    </li>
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
                                                <i class="fa fa-plus-square mr-1"></i> Tambah Data
                                            </button>
                                        </div>

                                        <div class="card card-info card-outline card-tabs">
                                            <div class="tab-content">
                                                <div class="tab-pane fade show active">
                                                    <div class="card-body">

                                                        <div class="mb-3 row">
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control"
                                                                    placeholder="🔍 Cari kegiatan..."
                                                                    wire:model.live="cari">
                                                            </div>
                                                        </div>

                                                        <div class="table-responsive">
                                                            <table
                                                                class="table table-hover table-borderless shadow rounded overflow-hidden">
                                                                <thead style="background-color: #404040; color: white;">
                                                                    <tr>
                                                                        <th class="px-3 py-2">Desa</th>
                                                                        <th class="px-3 py-2">Tahun</th>
                                                                        <th class="px-3 py-2">Kegiatan</th>
                                                                        <th class="px-3 py-2">Sumber Dana</th>
                                                                        <th class="px-3 py-2 text-end">Pagu</th>
                                                                        <th class="px-3 py-2 text-center">Aksi</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @forelse ($posts as $item)
                                                                        <tr style="transition: background-color 0.2s;"
                                                                            onmouseover="this.style.background='#f0f9ff'"
                                                                            onmouseout="this.style.background='white'">
                                                                            <td class="px-3 py-2 align-middle">
                                                                                {{ $item->desa->name ?? '-' }}</td>
                                                                            <td class="px-3 py-2 align-middle">
                                                                                {{ $item->tahun }}</td>
                                                                            <td class="px-3 py-2 align-middle">
                                                                                {{ $item->nama_kegiatan }}</td>
                                                                            <td class="px-3 py-2 align-middle">
                                                                                {{ $item->sumberdana }}</td>
                                                                            <td class="px-3 py-2 text-end align-middle">
                                                                                Rp{{ number_format($item->pagu_pak, 0, ',', '.') }}
                                                                            </td>
                                                                            <td class="text-nowrap">
                                                                                <button
                                                                                    class="btn btn-sm btn-warning mb-1"
                                                                                    wire:click="edit({{ $item->id }})">
                                                                                    <i class="fa fa-edit"></i> Edit
                                                                                </button>
                                                                                <button
                                                                                    class="btn btn-sm btn-danger mb-1"
                                                                                    wire:click="delete({{ $item->id }})">
                                                                                    <i class="fa fa-trash"></i> Hapus
                                                                                </button>
                                                                                <a href="{{ route('desa.paket-kegiatan', $item->id) }}"
                                                                                    class="btn btn-sm btn-primary mb-1">
                                                                                    <i class="fa fa-briefcase"></i> Buat
                                                                                    Paket
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                    @empty
                                                                        <tr>
                                                                            <td colspan="6"
                                                                                class="text-center text-muted py-4">
                                                                                <i class="fa fa-folder-open"></i> Tidak
                                                                                ada data.
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
                                        </div> <!-- /.card card-tabs -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- /.card-body -->
                </div>
            </div> <!-- /.row -->

        </div>
    </section>

    {{-- Modal Native Livewire --}}
    @if ($showModal)
        <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog" role="document">
                <form wire:submit.prevent="save" class="modal-content shadow-lg">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="fa fa-clipboard-list mr-1"></i> {{ $isEdit ? 'Edit' : 'Tambah' }} Paket Pekerjaan
                        </h5>
                        <button type="button" class="close text-white" wire:click="resetForm">
                            <span>&times;</span>
                        </button>
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
                        <button type="button" wire:click="resetForm" class="btn btn-secondary">
                            <i class="fa fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif


</div>
