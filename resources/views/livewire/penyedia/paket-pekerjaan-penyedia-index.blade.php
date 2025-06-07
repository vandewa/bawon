<div>
    <x-slot name="header">
        <div class="mb-1 row">
            <div class="col-sm-6 d-flex align-items-center">
                <h3 class="m-0">
                    <i class="mr-2 fas fa-briefcase"></i> Paket Pekerjaan untuk Penyedia
                </h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#"><i class="fas fa-building"></i> Penyedia</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <i class="fas fa-tasks"></i> Paket Pekerjaan
                    </li>
                </ol>
            </div>
        </div>
    </x-slot>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info card-outline card-tabs">
                        <div class="card-body">
                            <div class="mb-3 row">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="🔍 Cari kegiatan..."
                                        wire:model.debounce.500ms="cari">
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped ">
                                    <thead style="background-color: #404040; color: white;">
                                        <tr>
                                            <th class="px-3 py-2">Desa</th>
                                            <th class="px-3 py-2">Tahun</th>
                                            <th class="px-3 py-2">Kegiatan</th>
                                            <th class="px-3 py-2">Status Pengadaan</th>
                                            <th class="px-3 py-2">Jenis Pengadaan</th>
                                            <th class="px-3 py-2 text-end">Pagu</th>
                                            <th class="px-3 py-2 text-end">Nilai Kesepakatan</th>
                                            <th class="px-3 py-2">Status Dokumen</th>
                                            <th class="px-3 py-2">Status Penawaran</th>
                                            <th class="px-3 py-2 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($posts as $item)
                                            <tr>
                                                <td class="px-3 py-2 align-middle">
                                                    {{ $item->paketKegiatan->paketPekerjaan->desa->name ?? '-' }}
                                                </td>
                                                <td class="px-3 py-2 align-middle">
                                                    {{ $item->paketKegiatan->paketPekerjaan->tahun ?? '-' }}
                                                </td>
                                                <td class="px-3 py-2 align-middle">
                                                    {{ $item->paketKegiatan->paketPekerjaan->nama_kegiatan ?? '-' }}
                                                </td>
                                                <td class="px-3 py-2 align-middle">
                                                    <span
                                                        class="badge
                                                        @switch($item->paketKegiatan->statusKegiatan->com_cd ?? '')
                                                            @case('PAKET_KEGIATAN_ST_01') bg-warning @break
                                                            @case('PAKET_KEGIATAN_ST_02') bg-info text-dark @break
                                                            @case('PAKET_KEGIATAN_ST_03') bg-success @break
                                                            @case('PAKET_KEGIATAN_ST_04') bg-danger @break
                                                            @default bg-secondary
                                                        @endswitch">
                                                        {{ $item->paketKegiatan->statusKegiatan->code_nm ?? '-' }}
                                                    </span>
                                                </td>
                                                <td class="px-3 py-2 align-middle">
                                                    <span
                                                        class="badge
                                                        @switch($item->paketKegiatan->paketType->com_cd ?? '')
                                                            @case('PAKET_TYPE_01') bg-primary @break
                                                            @case('PAKET_TYPE_02') bg-warning text-dark @break
                                                            @case('PAKET_TYPE_03') bg-success @break
                                                            @default bg-secondary
                                                        @endswitch">
                                                        {{ $item->paketKegiatan->paketType->code_nm ?? '-' }}
                                                    </span>
                                                </td>
                                                <td class="px-3 py-2 align-middle text-end">
                                                    Rp{{ number_format($item->paketKegiatan->jumlah_anggaran ?? 0, 0, ',', '.') }}
                                                </td>
                                                <td class="px-3 py-2 align-middle text-end">
                                                    Rp{{ number_format($item->paketKegiatan->nilai_kesepakatan ?? 0, 0, ',', '.') }}
                                                </td>
                                                <td class="px-3 py-2 align-middle">
                                                    <ul class="mb-0 list-unstyled">
                                                        <li>
                                                            @if ($item->surat_undangan)
                                                                <i class="fas fa-check-circle text-success"></i>
                                                                <a href="{{ route('helper.show-picture', ['path' => $item->surat_undangan]) }}"
                                                                    target="_blank">
                                                                    Surat Undangan
                                                                </a>
                                                            @else
                                                                <i class="fas fa-times-circle text-danger"></i> Surat
                                                                Undangan
                                                            @endif
                                                        </li>
                                                        <li>
                                                            @if ($item->bukti_setor_pajak)
                                                                <i class="fas fa-check-circle text-success"></i>
                                                                <a href="{{ route('helper.show-picture', ['path' => $item->bukti_setor_pajak]) }}"
                                                                    target="_blank">
                                                                    Bukti Setor Pajak
                                                                </a>
                                                            @else
                                                                <i class="fas fa-times-circle text-danger"></i> Bukti
                                                                Setor Pajak
                                                            @endif
                                                        </li>
                                                        <li>
                                                            @if ($item->dok_penawaran)
                                                                <i class="fas fa-check-circle text-success"></i>
                                                                <a href="{{ route('helper.show-picture', ['path' => $item->dok_penawaran]) }}"
                                                                    target="_blank">
                                                                    Dokumen Penawaran
                                                                </a>
                                                            @else
                                                                <i class="fas fa-times-circle text-danger"></i> Dokumen
                                                                Penawaran
                                                            @endif
                                                        </li>
                                                        <li>
                                                            @if ($item->dok_kebenaran_usaha)
                                                                <i class="fas fa-check-circle text-success"></i>
                                                                <a href="{{ route('helper.show-picture', ['path' => $item->dok_kebenaran_usaha]) }}"
                                                                    target="_blank">
                                                                    Dok Kebenaran Usaha
                                                                </a>
                                                            @else
                                                                <i class="fas fa-times-circle text-danger"></i> Dok
                                                                Kebenaran Usaha
                                                            @endif
                                                        </li>
                                                        <li>
                                                            @if ($item->paketKegiatan?->ba_evaluasi_penawaran)
                                                                <i class="fas fa-check-circle text-success"></i>
                                                                <a href="{{ route('helper.show-picture', ['path' => $item->paketKegiatan->ba_evaluasi_penawaran]) }}"
                                                                    target="_blank">
                                                                    BA Evaluasi Penawaran
                                                                </a>
                                                            @else
                                                                <i class="fas fa-times-circle text-danger"></i> BA
                                                                Evaluasi Penawaran
                                                            @endif
                                                        </li>
                                                        <li>
                                                            @if ($item->paketKegiatan?->ba_pemenang)
                                                                <i class="fas fa-check-circle text-success"></i>
                                                                <a href="{{ route('helper.show-picture', ['path' => $item->paketKegiatan->ba_pemenang]) }}"
                                                                    target="_blank">
                                                                    BA Pemenang
                                                                </a>
                                                            @else
                                                                <i class="fas fa-times-circle text-danger"></i>
                                                                BA Pemenang
                                                            @endif
                                                        </li>

                                                        @if ($item->statusPenawaran?->com_cd == 'PENAWARAN_ST_02')
                                                            <li>
                                                                @if ($item->paketKegiatan?->negosiasi?->ba_negoisasi)
                                                                    <i class="fas fa-check-circle text-success"></i>
                                                                    <a href="{{ route('helper.show-picture', ['path' => $item->paketKegiatan->negosiasi->ba_negoisasi]) }}"
                                                                        target="_blank">
                                                                        BA Negosiasi
                                                                    </a>
                                                                @else
                                                                    <i class="fas fa-times-circle text-danger"></i> BA
                                                                    Negosiasi
                                                                @endif
                                                            </li>
                                                            <li>
                                                                @if ($item->paketKegiatan?->spk)
                                                                    <i class="fas fa-check-circle text-success"></i>
                                                                    <a href="{{ route('helper.show-picture', ['path' => $item->paketKegiatan->spk]) }}"
                                                                        target="_blank">
                                                                        SPK
                                                                    </a>
                                                                @else
                                                                    <i class="fas fa-times-circle text-danger"></i> SPK
                                                                @endif
                                                            </li>
                                                            <li>
                                                                @if ($item->paketKegiatan?->surat_perjanjian)
                                                                    <i class="fas fa-check-circle text-success"></i>
                                                                    <a href="{{ route('helper.show-picture', ['path' => $item->paketKegiatan->surat_perjanjian]) }}"
                                                                        target="_blank">
                                                                        Surat Perjanjian
                                                                    </a>
                                                                @else
                                                                    <i class="fas fa-times-circle text-danger"></i>
                                                                    Surat Perjanjian
                                                                @endif
                                                            </li>
                                                            <li>
                                                                @if ($item->paketKegiatan?->bukti_bayar)
                                                                    <i class="fas fa-check-circle text-success"></i>
                                                                    <a href="{{ route('helper.show-picture', ['path' => $item->paketKegiatan->bukti_bayar]) }}"
                                                                        target="_blank">
                                                                        Bukti Pembayaran
                                                                    </a>
                                                                @else
                                                                    <i class="fas fa-times-circle text-danger"></i>
                                                                    Bukti Pembayaran
                                                                @endif
                                                            </li>
                                                            <li>
                                                                @if ($item->paketKegiatan?->laporan_hasil_pemeriksaan)
                                                                    <i class="fas fa-check-circle text-success"></i>
                                                                    <a href="{{ route('helper.show-picture', ['path' => $item->paketKegiatan->laporan_hasil_pemeriksaan]) }}"
                                                                        target="_blank">
                                                                        Laporan Hasil Pemeriksaan
                                                                    </a>
                                                                @else
                                                                    <i class="fas fa-times-circle text-danger"></i>
                                                                    Laporan Hasil Pemeriksaan
                                                                @endif
                                                            </li>
                                                            <li>
                                                                @if ($item->paketKegiatan?->bast_penyedia)
                                                                    <i class="fas fa-check-circle text-success"></i>
                                                                    <a href="{{ route('helper.show-picture', ['path' => $item->paketKegiatan->bast_penyedia]) }}"
                                                                        target="_blank">
                                                                        BAST Penyedia
                                                                    </a>
                                                                @else
                                                                    <i class="fas fa-times-circle text-danger"></i> BAST
                                                                    Penyedia
                                                                @endif
                                                            </li>
                                                        @endif
                                                    </ul>


                                                </td>
                                                <td class="px-3 py-2 align-middle">
                                                    @if ($item->statusPenawaran)
                                                        <span
                                                            class="badge
                                                            @switch($item->statusPenawaran->com_cd)
                                                                @case('PENAWARAN_ST_01') badge-warning @break
                                                                @case('PENAWARAN_ST_02') badge-success @break
                                                                @case('PENAWARAN_ST_03') badge-danger @break
                                                                @default badge-secondary
                                                            @endswitch">
                                                            {{ $item->statusPenawaran->code_nm }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-secondary">-</span>
                                                    @endif
                                                </td>
                                                <td class="px-3 py-2 text-center align-middle">
                                                    <div class="gap-3 d-flex justify-content-center">
                                                        @if ($item->statusPenawaran?->com_cd == 'PENAWARAN_ST_01')
                                                            <a href="{{ route('penyedia.penawaran.create', $item->id) }}"
                                                                class="mr-1 btn btn-outline-secondary btn-sm d-flex align-items-center">
                                                                <i class="mr-1 fas fa-upload"></i> Upload/Edit
                                                            </a>
                                                        @endif
                                                        @if (
                                                            $item->paketKegiatan->negosiasi &&
                                                                $item->paketKegiatan->paket_type != 'PAKET_TYPE_02' &&
                                                                $item->statusPenawaran?->com_cd == 'PENAWARAN_ST_02' &&
                                                                $item->paketKegiatan->negosiasi->negosiasi_st != 'NEGOSIASI_ST_02')
                                                            <a href="{{ route('desa.penawaran.pelaksanaan.negosiasi', $item->paketKegiatan->id) }}"
                                                                class="mr-1 btn btn-outline-info btn-sm d-flex align-items-center">
                                                                <i class="mr-1 fas fa-handshake"></i> Negosiasi
                                                            </a>
                                                        @endif

                                                        @if (
                                                            $item->paketKegiatan->negosiasi?->negosiasi_st == 'NEGOSIASI_ST_02' &&
                                                                $item->statusPenawaran?->com_cd == 'PENAWARAN_ST_02')
                                                            <button type="button"
                                                                wire:click="openUploadBuktiPemeriksaanModal({{ $item->id }})"
                                                                class="mr-1 btn btn-outline-success btn-sm d-flex align-items-center">
                                                                <i class="mr-1 fas fa-file-upload"></i> Upload Bukti
                                                                Pemeriksaan
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="py-4 text-center text-muted">
                                                    <i class="fas fa-folder-open"></i> Tidak ada data.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $posts->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Modal untuk Upload Bukti Pemeriksaan (Inline) --}}
    @if ($showUploadBuktiPemeriksaanModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog"
            aria-labelledby="uploadBuktiPemeriksaanModalLabel" aria-modal="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="text-white modal-header bg-info">
                        <h5 class="modal-title" id="uploadBuktiPemeriksaanModalLabel">Upload Bukti Pemeriksaan</h5>
                        <button type="button" class="text-white close" wire:click="closeUploadBuktiPemeriksaanModal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form wire:submit.prevent="saveBuktiPemeriksaan">
                        <div class="modal-body">
                            @if (session()->has('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
                            @if (session()->has('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="buktiPemeriksaanFile">Pilih File Bukti Pemeriksaan (PDF, JPG, JPEG, PNG -
                                    Max 5MB)</label>
                                <input type="file" class="form-control-file" id="buktiPemeriksaanFile"
                                    wire:model="buktiPemeriksaanFile">
                                @error('buktiPemeriksaanFile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Loading indicator --}}
                            <div wire:loading wire:target="buktiPemeriksaanFile">Mengunggah file...</div>
                            <div wire:loading wire:target="saveBuktiPemeriksaan">Menyimpan...</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                wire:click="closeUploadBuktiPemeriksaanModal">Batal</button>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                                wire:target="saveBuktiPemeriksaan, buktiPemeriksaanFile">
                                <span wire:loading.remove
                                    wire:target="saveBuktiPemeriksaan, buktiPemeriksaanFile">Upload</span>
                                <span wire:loading
                                    wire:target="saveBuktiPemeriksaan, buktiPemeriksaanFile">Uploading...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Backdrop for the modal --}}
        <div class="modal-backdrop fade show"></div>
    @endif
</div>
