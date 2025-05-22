<div>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Klasifikasi Bidang Usaha</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Master</a></li>
                    <li class="breadcrumb-item active">Klasifikasi Bidang Usaha</li>
                </ol>
            </div>
        </div>
    </x-slot>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Left column for form -->
                <div class="col-md-12">
                    <div class="card card-info card-outline">
                        <form class="form-horizontal mt-2" wire:submit="save">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- Kode Tag -->
                                        <div class="form-group row">
                                            <label for="kode_kbli" class="col-sm-3 col-form-label">Kode KBLI</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" wire:model="form.kode_kbli"
                                                    placeholder="Kode KBLI">
                                                @error('form.kode_kbli')
                                                    <span class="form-text text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- Nama Tag -->
                                        <div class="form-group row">
                                            <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" wire:model="form.nama"
                                                    placeholder="Nama">
                                                @error('form.nama')
                                                    <span class="form-text text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Card footer with buttons -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                                <button type="button" class="btn btn-default float-right"
                                    wire:click="resetForm">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-12">
                    <!-- Right column for data table -->
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <div class="card-title">Data Klasifikasi Bidang Usaha</div>
                        </div>
                        <div class="card-body">
                            <!-- Search Input -->
                            <div class="row mb-2">
                                <div class="col-md-2">
                                    <input type="text" class="form-control" placeholder="🔍 Cari"
                                        wire:model.live="search">
                                </div>
                            </div>

                            <!-- Data Table -->
                            <div class="table-responsive">
                                <table class="table table-hover table-borderless shadow rounded overflow-hidden">
                                    <thead style="background-color: #404040; color: white;">
                                        <tr>
                                            <th class="px-3 py-2">No</th>
                                            <th class="px-3 py-2">Kode KBLI</th>
                                            <th class="px-3 py-2">Nama</th>
                                            <th class="px-3 py-2 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($tags as $tag)
                                            <tr style="transition: background-color 0.2s;"
                                                onmouseover="this.style.background='#f0f9ff'"
                                                onmouseout="this.style.background='white'"
                                                wire:key='{{ $tag->id }}'>
                                                <td class="px-3 py-2 align-middle">
                                                    {{ $loop->index + $tags->firstItem() }}
                                                </td>
                                                <td class="px-3 py-2 align-middle">
                                                    {{ $tag->kode_kbli ?? '-' }}
                                                </td>
                                                <td class="px-3 py-2 align-middle">
                                                    {{ $tag->nama ?? '-' }}
                                                </td>
                                                <td class="px-3 py-2 text-center align-middle text-nowrap">
                                                    <button type="button" wire:click="getEdit({{ $tag->id }})"
                                                        class="btn btn-sm btn-warning mb-1">
                                                        <i class="fas fa-pencil-alt"></i> Edit
                                                    </button>
                                                    <button type="button" wire:click="delete({{ $tag->id }})"
                                                        class="btn btn-sm btn-danger mb-1">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">
                                                    <i class="fas fa-folder-open"></i> Tidak ada data KBLI.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $tags->links() }} <!-- Pagination Links -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
