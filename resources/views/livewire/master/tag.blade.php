<div>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Kualifikasi Bidang Usaha</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Master</a></li>
                    <li class="breadcrumb-item active">Kualifikasi Bidang Usaha</li>
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
                                <button type="submit" class="btn btn-success">Simpan</button>
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
                            <div class="card-title">Data Kualifikasi Bidang Usaha</div>
                        </div>
                        <div class="card-body">
                            <!-- Search Input -->
                            <div class="row">
                                <div class="col-md-2">
                                    <input type="text" class="form-control" placeholder="Cari"
                                        wire:model.live="search">
                                </div>
                            </div>

                            <!-- Data Table -->
                            <table class="table table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode KBLI</th>
                                        <th>Nama</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tags as $tag)
                                        <tr wire:key="{{ $tag->id }}">
                                            <td>{{ $loop->iteration + $tags->firstItem() - 1 }}</td>
                                            <td>{{ $tag->kode_kbli }}</td>
                                            <td>{{ $tag->nama }}</td>
                                            <td>
                                                <!-- Edit Button -->
                                                <button type="button" wire:click="edit({{ $tag->id }})"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fas fa-pencil-alt"></i> Edit
                                                </button>
                                                <!-- Delete Button -->
                                                <button type="button" wire:click="delete({{ $tag->id }})"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $tags->links() }} <!-- Pagination Links -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
