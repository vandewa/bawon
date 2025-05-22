<div>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Regulasi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Master</a></li>
                    <li class="breadcrumb-item active">Regulasi</li>
                </ol>
            </div>
        </div>
    </x-slot>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Form Section -->
                <div class="col-md-12">
                    <div class="card card-info card-outline">
                        <form class="form-horizontal mt-2" wire:submit="save">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="nama" class="col-sm-2 col-form-label">Nama Regulasi</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="nama"
                                                    wire:model="form.nama" placeholder="Nama Regulasi">
                                                @error('form.nama')
                                                    <span class="form-text text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="file" class="col-sm-2 col-form-label">Dokumen (PDF)</label>
                                            <div class="col-sm-10">
                                                <input type="file" class="form-control" id="file"
                                                    wire:model="file" accept="application/pdf">
                                                @error('file')
                                                    <span class="form-text text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div wire:loading wire:target="file" class="mt-1 text-info">
                                            <i class="fas fa-spinner fa-spin"></i> Mengunggah file...
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Card footer with buttons -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                                @if ($edit)
                                    <button type="button" class="btn btn-default float-right" wire:click="batal">
                                        <i class="fas fa-times"></i> Batal
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Data Table Section -->
                <div class="col-md-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <div class="card-title">Data Regulasi</div>
                        </div>
                        <div class="card-body">
                            <!-- Search Input -->
                            <div class="row mb-2">
                                <div class="col-md-2">
                                    <input type="text" class="form-control" placeholder="🔍 Cari"
                                        wire:model.live.debounce.500ms="search">
                                </div>
                            </div>

                            <!-- Data Table -->
                            <div class="table-responsive">
                                <table class="table table-hover table-borderless shadow rounded overflow-hidden">
                                    <thead style="background-color: #404040; color: white;">
                                        <tr>
                                            <th class="px-3 py-2">No</th>
                                            <th class="px-3 py-2">Nama Regulasi</th>
                                            <th class="px-3 py-2">Dokumen</th>
                                            <th class="px-3 py-2 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data as $list)
                                            <tr style="transition: background-color 0.2s;"
                                                onmouseover="this.style.background='#f0f9ff'"
                                                onmouseout="this.style.background='white'"
                                                wire:key='regulasi-{{ $list->id }}'>
                                                <td class="px-3 py-2 align-middle">
                                                    {{ $loop->index + $data->firstItem() }}
                                                </td>
                                                <td class="px-3 py-2 align-middle">
                                                    {{ $list->nama ?? '-' }}
                                                </td>
                                                <td class="px-3 py-2 align-middle">
                                                    @if ($list->file_path)
                                                        <a href="{{ Storage::url($list->file_path) }}" target="_blank"
                                                            class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    @else
                                                        <span class="text-muted">Tidak ada dokumen</span>
                                                    @endif
                                                </td>
                                                <td class="px-3 py-2 text-center align-middle text-nowrap">
                                                    <button type="button" wire:click="getEdit({{ $list->id }})"
                                                        class="btn btn-sm btn-warning mb-1">
                                                        <i class="fas fa-pencil-alt"></i> Edit
                                                    </button>
                                                    <button type="button" wire:click="delete({{ $list->id }})"
                                                        class="btn btn-sm btn-danger mb-1">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">
                                                    <i class="fas fa-folder-open"></i> Tidak ada data regulasi.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $data->links() }} <!-- Pagination Links -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
