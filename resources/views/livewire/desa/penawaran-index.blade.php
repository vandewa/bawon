<div>
    <x-slot name="header">
        <div class="mb-1 row">
            <div class="col-sm-6">
                <h3 class="m-0">Paket Kegiatan</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Penawaran</a></li>
                    <li class="breadcrumb-item active">Index</li>
                </ol>
            </div>
        </div>
    </x-slot>

    <section class="content">
        <div class="container-fluid">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info card-outline">
                        <div class="card-body">
                            <div class="mb-3 row">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="Cari kegiatan..."
                                        wire:model.debounce.500ms="search">
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr class="bg-light">
                                            <th>Desa</th>
                                            <th>Tahun</th>
                                            <th>Kegiatan</th>
                                            <th>Paket</th>
                                            <th>Anggaran</th>
                                            <th>Dokumen</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($paketKegiatans as $paket)
                                            <tr>
                                                <td>{{ $paket->paketPekerjaan->desa->name ?? '-' }}</td>
                                                <td>{{ $paket->paketPekerjaan->tahun ?? '-' }}</td>
                                                <td>{{ $paket->paketPekerjaan->nama_kegiatan ?? '-' }}</td>
                                                <td>{{ $paket->paket_kegiatan }}</td>
                                                <td class="text-end">
                                                    Rp{{ number_format($paket->jumlah_anggaran, 0, ',', '.') }}
                                                </td>
                                                <td>
                                                    @if ($paket->surat_perjanjian)
                                                        <a href="{{ Storage::url($paket->surat_perjanjian) }}"
                                                            target="_blank" class="btn btn-sm btn-outline-success">
                                                            Lihat Surat Perjanjian
                                                        </a>
                                                    @else
                                                        <span class="badge bg-warning text-dark">Belum Upload</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('desa.penawaran.paket', $paket->id) }}"
                                                        class="mb-1 btn btn-sm btn-primary">
                                                        Kelola Penawaran
                                                    </a>

                                                    @if ($paket->negosiasi && $paket->paket_type !== 'PAKET_TYPE_02')
                                                        <a href="{{ route('desa.penawaran.pelaksanaan.negosiasi', $paket->id) }}"
                                                            class="mb-1 btn btn-sm btn-info">
                                                            Negosiasi
                                                        </a>
                                                    @endif

                                                    @if (($paket->negosiasi_st ?? '') === 'NEGOSIASI_ST_02')
                                                        <button wire:click="openUploadModal({{ $paket->id }})"
                                                            class="mb-1 btn btn-sm btn-success">
                                                            Upload Kontrak
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">Data tidak ditemukan.
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
                            <h5 class="modal-title">Upload Surat Perjanjian</h5>
                            <button type="button" class="text-white btn-close"
                                wire:click="$set('showUploadModal', false)">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form wire:submit.prevent="uploadSuratPerjanjian">
                                <div class="form-group">
                                    <label for="fileSuratPerjanjian">Pilih File Surat Perjanjian</label>
                                    <input type="file" id="fileSuratPerjanjian" wire:model="fileSuratPerjanjian"
                                        class="form-control @error('fileSuratPerjanjian') is-invalid @enderror">
                                    @error('fileSuratPerjanjian')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div wire:loading wire:target="fileSuratPerjanjian" class="mt-2 text-warning">
                                    Uploading...
                                </div>

                                <div class="mt-4 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success">
                                        Simpan
                                    </button>
                                    <button type="button" wire:click="$set('showUploadModal', false)"
                                        class="btn btn-secondary ms-2">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </section>
</div>
