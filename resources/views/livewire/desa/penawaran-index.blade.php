<div>
    <x-slot name="header">
        <div class="mb-1 row">
            <div class="col-sm-6 d-flex align-items-center">
                <h3 class="m-0">
                    <i class="fa fa-folder-open mr-2"></i> Paket Kegiatan
                </h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#"><i class="fa fa-file-signature"></i> Penawaran</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <i class="fa fa-list"></i> Index
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
                                    <div class="card card-info card-outline card-tabs">
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active">
                                                <div class="card-body">
                                                    <div class="mb-3 row">
                                                        <div class="col-md-3">
                                                            <input type="text" class="form-control"
                                                                placeholder="🔍 Cari kegiatan..."
                                                                wire:model.debounce.500ms="search">
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
                                                                    <th class="px-3 py-2">Paket</th>
                                                                    <th class="px-3 py-2 text-end">Anggaran</th>
                                                                    <th class="px-3 py-2">Dokumen</th>
                                                                    <th class="px-3 py-2 text-center">Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse ($paketKegiatans as $paket)
                                                                    <tr style="transition: background-color 0.2s;"
                                                                        onmouseover="this.style.background='#f0f9ff'"
                                                                        onmouseout="this.style.background='white'">
                                                                        <td class="px-3 py-2 align-middle">
                                                                            {{ $paket->paketPekerjaan->desa->name ?? '-' }}
                                                                        </td>
                                                                        <td class="px-3 py-2 align-middle">
                                                                            {{ $paket->paketPekerjaan->tahun ?? '-' }}
                                                                        </td>
                                                                        <td class="px-3 py-2 align-middle">
                                                                            {{ $paket->paketPekerjaan->nama_kegiatan ?? '-' }}
                                                                        </td>
                                                                        <td class="px-3 py-2 align-middle">
                                                                            {{ $paket->paket_kegiatan }}</td>
                                                                        <td class="px-3 py-2 text-end align-middle">
                                                                            Rp{{ number_format($paket->jumlah_anggaran, 0, ',', '.') }}
                                                                        </td>
                                                                        <td class="px-3 py-2 align-middle">
                                                                            @if ($paket->surat_perjanjian)
                                                                                <a href="{{ Storage::url($paket->surat_perjanjian) }}"
                                                                                    target="_blank"
                                                                                    class="inline-flex items-center gap-1 text-sm bg-green-100 text-green-800 border border-green-300 px-2 py-1 rounded hover:bg-green-200 transition">
                                                                                    <i class="fa fa-file-contract"></i>
                                                                                    Surat Perjanjian
                                                                                </a>
                                                                            @else
                                                                                <span
                                                                                    class="inline-flex items-center gap-1 text-sm bg-yellow-100 text-yellow-800 border border-yellow-300 px-2 py-1 rounded">
                                                                                    <i
                                                                                        class="fa fa-exclamation-circle"></i>
                                                                                    Belum Upload
                                                                                </span>
                                                                            @endif
                                                                        </td>
                                                                        <td class="px-3 py-2 text-center align-middle">
                                                                            <div
                                                                                class="flex flex-wrap justify-center gap-2">
                                                                                <a href="{{ route('desa.penawaran.paket', $paket->id) }}"
                                                                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-sm bg-blue-100 text-blue-800 border border-blue-300 rounded hover:bg-blue-200 transition">
                                                                                    <i class="fa fa-edit"></i> Kelola
                                                                                    Penawaran
                                                                                </a>

                                                                                @if ($paket->negosiasi && $paket->paket_type !== 'PAKET_TYPE_02')
                                                                                    <a href="{{ route('desa.penawaran.pelaksanaan.negosiasi', $paket->id) }}"
                                                                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-sm bg-cyan-100 text-cyan-800 border border-cyan-300 rounded hover:bg-cyan-200 transition">
                                                                                        <i class="fa fa-handshake"></i>
                                                                                        Negosiasi
                                                                                    </a>
                                                                                @endif

                                                                                @if (($paket->negosiasi_st ?? '') === 'NEGOSIASI_ST_02')
                                                                                    <button
                                                                                        wire:click="openUploadModal({{ $paket->id }})"
                                                                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-sm bg-green-100 text-green-800 border border-green-300 rounded hover:bg-green-200 transition">
                                                                                        <i class="fa fa-upload"></i>
                                                                                        Upload Kontrak
                                                                                    </button>
                                                                                @endif
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="7"
                                                                            class="text-center text-muted py-4">
                                                                            <i class="fa fa-folder-open"></i> Data tidak
                                                                            ditemukan.
                                                                        </td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>


                                                    <div class="mt-3">
                                                        {{ $paketKegiatans->links() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Modal Upload Surat Perjanjian --}}
                                @if ($showUploadModal)
                                    <div class="modal fade show d-block" tabindex="-1" role="dialog"
                                        style="background: rgba(0,0,0,0.5); z-index:1050;">
                                        <div class="modal-dialog" role="document">
                                            <div class="border-0 shadow modal-content">
                                                <div class="text-white modal-header bg-success">
                                                    <h5 class="modal-title">
                                                        <i class="fa fa-upload mr-2"></i> Upload Surat Perjanjian
                                                    </h5>
                                                    <button type="button" class="text-white btn-close"
                                                        wire:click="$set('showUploadModal', false)">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form wire:submit.prevent="uploadSuratPerjanjian">
                                                        <div class="form-group">
                                                            <label for="fileSuratPerjanjian">
                                                                <i class="fa fa-file-upload"></i> Pilih File Surat
                                                                Perjanjian
                                                            </label>
                                                            <input type="file" id="fileSuratPerjanjian"
                                                                wire:model="fileSuratPerjanjian"
                                                                class="form-control @error('fileSuratPerjanjian') is-invalid @enderror">
                                                            @error('fileSuratPerjanjian')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div wire:loading wire:target="fileSuratPerjanjian"
                                                            class="mt-2 text-warning">
                                                            <i class="fa fa-spinner fa-spin"></i> Uploading...
                                                        </div>

                                                        <div class="mt-4 d-flex justify-content-end">
                                                            <button type="submit" class="btn btn-success">
                                                                <i class="fa fa-save"></i> Simpan
                                                            </button>
                                                            <button type="button"
                                                                wire:click="$set('showUploadModal', false)"
                                                                class="btn btn-secondary ms-2">
                                                                <i class="fa fa-times"></i> Batal
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>
