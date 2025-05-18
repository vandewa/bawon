<div>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Daftar Hitam</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Penyedia</a></li>
                    <li class="breadcrumb-item active">Daftar Hitam</li>
                </ol>
            </div>
        </div>
    </x-slot>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info card-outline">
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
                                            <th class="px-3 py-2">Nama Perusahaan</th>
                                            <th class="px-3 py-2">NIB</th>
                                            <th class="px-3 py-2">Direktur</th>
                                            <th class="px-3 py-2">Jenis Usaha</th>
                                            <th class="px-3 py-2">Daftar Hitam</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($vendors as $vendor)
                                            <tr style="transition: background-color 0.2s;"
                                                onmouseover="this.style.background='#f0f9ff'"
                                                onmouseout="this.style.background='white'"
                                                wire:key="vendor-{{ $vendor->id }}">
                                                <td class="px-3 py-2 align-middle">
                                                    {{ $loop->index + $vendors->firstItem() }}
                                                </td>
                                                <td class="px-3 py-2 align-middle">{{ $vendor->nama_perusahaan }}</td>
                                                <td class="px-3 py-2 align-middle">{{ $vendor->nib }}</td>
                                                <td class="px-3 py-2 align-middle">{{ $vendor->nama_direktur }}</td>
                                                <td class="px-3 py-2 align-middle">
                                                    {{ $vendor->jenisUsaha->code_nm ?? '' }}
                                                </td>
                                                <td class="px-3 py-2 align-middle">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="daftarHitamSwitch{{ $vendor->id }}"
                                                            wire:click="toggleStatus({{ $vendor->id }})"
                                                            {{ $vendor->daftar_hitam ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="daftarHitamSwitch{{ $vendor->id }}"></label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">
                                                    <i class="fas fa-folder-open"></i> Tidak ada data penyedia.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $vendors->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('js')
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('statusToggled', ({
                id,
                status
            }) => {
                Swal.fire({
                    title: 'Berhasil!',
                    text: `Status daftar hitam diubah menjadi ${status ? 'Aktif' : 'Nonaktif'}.`,
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
            });
        });
    </script>
@endpush
