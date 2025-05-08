<div>
    <x-slot name="header">
        <div class="mb-1 row">
            <div class="col-sm-6 d-flex align-items-center">
                <h3 class="m-0">
                    <i class="fas fa-industry mr-2"></i> Data Vendor / Penyedia
                </h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">
                        <i class="fas fa-building"></i> Vendor
                    </li>
                </ol>
            </div>
        </div>
    </x-slot>

    <section class="content">
        <div class="container-fluid">

            @if (session()->has('message'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('message') }}
                </div>
            @endif

            <div class="card card-info card-outline">
                <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                    <div class="mb-2 mb-md-0" style="width: 250px;">
                        <input type="text" class="form-control" placeholder="🔍 Cari nama/NIB..."
                            wire:model.live="search">
                    </div>
                    <div>
                        <a href="{{ route('penyedia.vendor-create') }}" class="btn btn-info">
                            <i class="fas fa-plus-circle"></i> Tambah Vendor
                        </a>
                    </div>
                </div>

                <div class="p-3 card-body table-responsive">
                    <table class="table table-hover table-borderless shadow rounded overflow-hidden">
                        <thead style="background-color: #404040; color: white;">
                            <tr>
                                <th class="px-3 py-2">Nama Perusahaan</th>
                                <th class="px-3 py-2">NIB</th>
                                <th class="px-3 py-2">Direktur</th>
                                <th class="px-3 py-2">Jenis Usaha</th>
                                <th class="px-3 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($vendors as $vendor)
                                <tr style="transition: background-color 0.2s;"
                                    onmouseover="this.style.background='#f0f9ff'"
                                    onmouseout="this.style.background='white'">
                                    <td class="px-3 py-2 align-middle">{{ $vendor->nama_perusahaan }}</td>
                                    <td class="px-3 py-2 align-middle">{{ $vendor->nib }}</td>
                                    <td class="px-3 py-2 align-middle">{{ $vendor->nama_direktur }}</td>
                                    <td class="px-3 py-2 align-middle">{{ $vendor->jenis_usaha }}</td>
                                    <td class="px-3 py-2 text-center align-middle text-nowrap">
                                        <a href="{{ route('penyedia.vendor-profile', $vendor->id) }}') }}"
                                            class="btn btn-sm btn-info mb-1">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        <a href="{{ route('penyedia.vendor-edit', $vendor->id) }}"
                                            class="btn btn-sm btn-warning mb-1">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button wire:click="delete({{ $vendor->id }})"
                                            class="btn btn-sm btn-danger mb-1">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-folder-open"></i> Tidak ada data Vendor.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="p-3">
                        {{ $vendors->links() }}
                    </div>
                </div>
            </div>

            {{-- Modal --}}
            @if ($showModal)
                <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
                    <div class="modal-dialog modal-xl">
                        <form wire:submit.prevent="save" class="modal-content shadow rounded"
                            style="max-height: 90vh; overflow-y: auto;">
                            <div class="modal-header bg-info text-white">
                                <h4 class="modal-title">
                                    <i class="fas fa-building mr-2"></i>
                                    {{ $isEdit ? 'Edit Vendor' : 'Tambah Vendor' }}
                                </h4>
                                <button type="button" class="text-white btn-close" wire:click="resetForm">
                                    <span>&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div class="row">
                                    {{-- Form Kolom 1 --}}
                                    <div class="col-md-6">
                                        {{-- Inputan --}}
                                        {{-- ... lanjut semua input form kamu tetap, styling sudah bagus --}}
                                    </div>

                                    {{-- Form Kolom 2 --}}
                                    <div class="col-md-6">
                                        {{-- Inputan --}}
                                        {{-- ... lanjut semua input form kamu tetap, styling sudah bagus --}}
                                    </div>
                                </div>

                                <hr>
                                <h5 class="font-weight-bold text-dark">Upload Dokumen</h5>

                                <div class="row">
                                    {{-- Dokumen Upload --}}
                                    {{-- ... lanjut semua field dokumen tetap, styling sudah bagus --}}
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" wire:click="resetForm" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

        </div>
    </section>
</div>
