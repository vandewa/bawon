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
                                <table class="table overflow-hidden rounded shadow table-hover table-borderless">
                                    <thead style="background-color: #404040; color: white;">
                                        <tr>
                                            <th class="px-3 py-2">Desa</th>
                                            <th class="px-3 py-2">Tahun</th>
                                            <th class="px-3 py-2">Kegiatan</th>
                                            <th class="px-3 py-2">Jenis Pengadaan</th>
                                            <th class="px-3 py-2 text-end">Pagu</th>
                                            <th class="px-3 py-2 text-end">Nilai Kesepakatan</th>
                                            <th class="px-3 py-2">Status Dokumen</th>
                                            <th class="px-3 py-2">Status</th>
                                            <th class="px-3 py-2 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($posts as $item)
                                            <tr style="transition: background-color 0.2s;"
                                                onmouseover="this.style.background='#f0f9ff'"
                                                onmouseout="this.style.background='white'">
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
                                                    Rp{{ number_format($item->paketKegiatan->nilai_kontrak ?? 0, 0, ',', '.') }}
                                                </td>
                                                <td class="px-3 py-2 align-middle">
                                                    <ul class="mb-0 list-unstyled">
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
                                                        <!-- Tombol Upload/Edit -->
                                                        @if ($item->statusPenawaran?->com_cd == 'PENAWARAN_ST_01')
                                                            <a href="{{ route('penyedia.penawaran.create', $item->id) }}"
                                                                class="mr-1 btn btn-outline-secondary btn-sm d-flex align-items-center">
                                                                <i class="mr-1 fas fa-upload"></i> Upload/Edit
                                                            </a>
                                                        @endif
                                                        <!-- Tombol Negosiasi (conditional) -->
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
                                                    </div>
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="py-4 text-center text-muted">
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

                        </div> <!-- /.card-body -->
                    </div> <!-- /.card -->
                </div>
            </div> <!-- /.row -->
        </div>
    </section>
</div>
