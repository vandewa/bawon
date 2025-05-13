<div>
    <x-slot name="header">
        <div class="mb-1 row">
            <div class="col-sm-6 d-flex align-items-center">
                <h3 class="m-0">
                    <i class="mr-2 fa fa-folder-open"></i> Paket Kegiatan
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
                                                            class="table overflow-hidden rounded shadow table-hover table-borderless">
                                                            <thead style="background-color: #404040; color: white;">
                                                                <tr>
                                                                    <th class="px-3 py-2">Desa</th>
                                                                    <th class="px-3 py-2">Tahun</th>
                                                                    <th class="px-3 py-2">Kegiatan</th>
                                                                    <th class="px-3 py-2">Jenis Pengadaan</th>
                                                                    <th class="px-3 py-2 text-end">Anggaran</th>
                                                                    <th class="px-3 py-2 text-end">Nilai Kesepakatan
                                                                    </th>
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
                                                                            @php
                                                                                $type =
                                                                                    $paket->paketType->com_cd ?? null;
                                                                                $label =
                                                                                    $paket->paketType->code_nm ?? '-';
                                                                                $badgeClass = match ($type) {
                                                                                    'PAKET_TYPE_01'
                                                                                        => 'badge bg-primary', // Penyedia
                                                                                    'PAKET_TYPE_02'
                                                                                        => 'badge bg-warning', // Swakelola
                                                                                    'PAKET_TYPE_03'
                                                                                        => 'badge bg-info', // Lelang
                                                                                    default => 'badge bg-secondary',
                                                                                };
                                                                            @endphp

                                                                            <span class="{{ $badgeClass }}">
                                                                                <i class="mr-1 fas fa-tag"></i>
                                                                                {{ $label }}
                                                                            </span>

                                                                        </td>
                                                                        <td class="px-3 py-2 align-middle text-end">
                                                                            Rp{{ number_format($paket->jumlah_anggaran, 0, ',', '.') }}
                                                                        </td>
                                                                        <td class="px-3 py-2 align-middle text-end">
                                                                            @php
                                                                                $nilaiKesepakatan =
                                                                                    $paket->negosiasi?->nilai ?? 0;
                                                                            @endphp

                                                                            @if ($nilaiKesepakatan > 0)
                                                                                Rp{{ number_format($nilaiKesepakatan, 0, ',', '.') }}
                                                                            @else
                                                                                <span class="text-muted">-</span>
                                                                            @endif
                                                                        </td>

                                                                        <td class="px-3 py-2 align-middle">
                                                                            @if ($paket->surat_perjanjian)
                                                                                <a href="{{ route('helper.show-picture', ['path' => $paket->surat_perjanjian]) }}"
                                                                                    target="_blank"
                                                                                    class="btn btn-sm btn-success">
                                                                                    <i class="fa fa-file-contract"></i>
                                                                                    Surat Perjanjian
                                                                                </a>
                                                                            @else
                                                                                <span
                                                                                    class="badge bg-warning text-dark">
                                                                                    <i
                                                                                        class="fa fa-exclamation-circle"></i>
                                                                                    Surat Perjanjian Belum Upload
                                                                                </span>
                                                                            @endif
                                                                            @if ($paket->spk)
                                                                                <a href="{{ route('helper.show-picture', ['path' => $paket->spk]) }}"
                                                                                    target="_blank"
                                                                                    class="btn btn-sm btn-success">
                                                                                    <i class="fa fa-file-contract"></i>
                                                                                    SPK
                                                                                </a>
                                                                            @else
                                                                                <span
                                                                                    class="badge bg-warning text-dark">
                                                                                    <i
                                                                                        class="fa fa-exclamation-circle"></i>
                                                                                    SPK Belum Upload
                                                                                </span>
                                                                            @endif
                                                                        </td>
                                                                        <td
                                                                            class="px-3 py-2 text-center align-middle text-nowrap">
                                                                            <a href="{{ route('desa.penawaran.paket', $paket->id) }}"
                                                                                class="mb-1 btn btn-sm btn-primary">
                                                                                <i class="fa fa-edit"></i> Kelola
                                                                                Penawaran
                                                                            </a>
                                                                            @php
                                                                                $langsungKontrak =
                                                                                    $paket->paket_type ==
                                                                                    'PAKET_TYPE_02';
                                                                            @endphp

                                                                            @if (!$langsungKontrak && $paket->negosiasi && $paket->negosiasi->negosiasi_st !== 'NEGOSIASI_ST_02')
                                                                                <a href="{{ route('desa.penawaran.pelaksanaan.negosiasi', $paket->id) }}"
                                                                                    class="mb-1 btn btn-sm btn-info">
                                                                                    <i class="fa fa-handshake"></i>
                                                                                    Negosiasi
                                                                                </a>
                                                                            @endif


                                                                            @if ($langsungKontrak || ($paket->negosiasi->negosiasi_st ?? '') == 'NEGOSIASI_ST_02')
                                                                                <button
                                                                                    wire:click="openUploadModal({{ $paket->id }})"
                                                                                    class="mb-1 btn btn-sm btn-success">
                                                                                    <i class="fa fa-upload"></i> Upload
                                                                                    Kontrak
                                                                                </button>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="7"
                                                                            class="py-4 text-center text-muted">
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

                                                </div> <!-- /.card-body -->
                                            </div> <!-- /.tab-pane -->
                                        </div> <!-- /.tab-content -->
                                    </div> <!-- /.card -->
                                </div>
                            </div>
                        </div>
                    </div> <!-- /.card-body -->
                </div>
            </div>

        </div>
    </section>

    {{-- Modal Upload Surat Perjanjian --}}
    {{-- Modal Upload Surat Perjanjian --}}
    {{-- Modal Upload Surat Perjanjian & SPK --}}
    @if ($showUploadModal)
        <div class="modal fade show d-block" tabindex="-1" role="dialog"
            style="background: rgba(0,0,0,0.5); z-index:1050;">
            <div class="modal-dialog" role="document">
                <form wire:submit.prevent="uploadSuratPerjanjian" class="rounded shadow modal-content">
                    <div class="text-white modal-header bg-success">
                        <h5 class="modal-title">
                            <i class="mr-2 fa fa-upload"></i> Upload Dokumen
                        </h5>
                        <button type="button" class="btn-close" wire:click="$set('showUploadModal', false)">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        {{-- Input Surat Perjanjian --}}
                        <div class="form-group">
                            <label for="fileSuratPerjanjian"><i class="fa fa-file-upload"></i> Pilih File Surat
                                Perjanjian</label>
                            <input type="file" id="fileSuratPerjanjian" wire:model="fileSuratPerjanjian"
                                class="form-control @error('fileSuratPerjanjian') is-invalid @enderror">
                            @error('fileSuratPerjanjian')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div wire:loading wire:target="fileSuratPerjanjian" class="mt-2 text-info">
                                <i class="fa fa-spinner fa-spin"></i> Uploading Surat Perjanjian...
                            </div>
                        </div>

                        {{-- Input SPK --}}
                        <div class="mt-3 form-group">
                            <label for="fileSPK"><i class="fa fa-file-upload"></i> Pilih File SPK</label>
                            <input type="file" id="fileSPK" wire:model="fileSPK"
                                class="form-control @error('fileSPK') is-invalid @enderror">
                            @error('fileSPK')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div wire:loading wire:target="fileSPK" class="mt-2 text-info">
                                <i class="fa fa-spinner fa-spin"></i> Uploading SPK...
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-between">
                        {{-- Tombol Dummy Generate --}}
                        <div class="gap-2 d-flex">
                            <a href="{{ route('generator.penyedia.surat-perjanjian', ['paketId' => $paketIdUpload]) }}"
                                target="_blank" class="mr-1 btn btn-outline-dark">
                                <i class="fas fa-magic"></i> Generate Surat Perjanjian
                            </a>

                            <a href="{{ route('generator.penyedia.spk', ['paketId' => $paketIdUpload]) }}"
                                target="_blank" class="mr-1 btn btn-outline-dark">
                                <i class="fas fa-file-alt"></i> Generate SPK
                            </a>

                        </div>

                        {{-- Tombol Simpan dan Batal --}}
                        <div class="gap-2 d-flex">
                            <button type="submit" class="mr-2 btn btn-success" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="uploadSuratPerjanjian">
                                    <i class="fa fa-save"></i> Simpan
                                </span>
                                <span wire:loading wire:target="uploadSuratPerjanjian">
                                    <i class="fas fa-spinner fa-spin"></i> Menyimpan...
                                </span>
                            </button>

                            <button type="button" class="btn btn-secondary"
                                wire:click="$set('showUploadModal', false)">
                                <i class="fa fa-times"></i> Batal
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif



</div>
