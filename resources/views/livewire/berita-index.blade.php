<div>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Berita</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Master</a></li>
                    <li class="breadcrumb-item active">Berita</li>
                </ol>
            </div>
        </div>
    </x-slot>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <div class="card-title">Data Berita</div>
                            <div class="card-tools">
                                <a href="{{ route('master.berita-create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Tambah Berita
                                </a>
                            </div>
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
                                            <th class="px-3 py-2">Tanggal</th>
                                            <th class="px-3 py-2">Judul</th>
                                            <th class="px-3 py-2">File</th>
                                            <th class="px-3 py-2">Dibuat Oleh</th>
                                            <th class="px-3 py-2">Published</th>
                                            <th class="px-3 py-2 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data as $list)
                                            <tr style="transition: background-color 0.2s;"
                                                onmouseover="this.style.background='#f0f9ff'"
                                                onmouseout="this.style.background='white'"
                                                wire:key='berita-{{ $list->id }}'>
                                                <td class="px-3 py-2 align-middle">
                                                    {{ $loop->index + $data->firstItem() }}
                                                </td>
                                                <td class="px-3 py-2 align-middle">
                                                    {{ \Carbon\Carbon::parse($list->created_at)->translatedFormat('d F Y') }}
                                                </td>
                                                <td class="px-3 py-2 align-middle">
                                                    {{ $list->judul ?? '-' }}
                                                </td>
                                                <td class="px-3 py-2 align-middle">
                                                    @if ($list->file_berita)
                                                        <a href="{{ Storage::url($list->file_berita) }}" target="_blank"
                                                            class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    @else
                                                        <span class="text-muted">Tidak ada file</span>
                                                    @endif
                                                </td>
                                                <td class="px-3 py-2 align-middle">
                                                    {{ $list->creator->name ?? '-' }}
                                                </td>
                                                <td class="px-3 py-2 align-middle">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="statusToggle{{ $list->id }}"
                                                            wire:model.live="data.{{ $loop->index }}.status_berita_st"
                                                            wire:change="toggleStatus({{ $list->id }})"
                                                            {{ $list->status_berita_st === 'STATUS_BERITA_ST_01' ? 'checked' : '' }}>
                                                        <label class="custom-control-label"
                                                            for="statusToggle{{ $list->id }}"></label>
                                                    </div>
                                                </td>
                                                <td class="px-3 py-2 text-center align-middle text-nowrap">
                                                    <a href="{{ route('master.berita-edit', $list->id) }}"
                                                        class="btn btn-sm btn-warning mb-1">
                                                        <i class="fas fa-pencil-alt"></i> Edit
                                                    </a>
                                                    <button type="button" wire:click="delete({{ $list->id }})"
                                                        class="btn btn-sm btn-danger mb-1">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-4">
                                                    <i class="fas fa-folder-open"></i> Tidak ada data berita.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $data->links() }}
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
                    text: `Status berita diubah menjadi ${status === 'STATUS_BERITA_ST_01' ? 'Published' : 'Draft'}.`,
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
            });
        });
    </script>
@endpush
