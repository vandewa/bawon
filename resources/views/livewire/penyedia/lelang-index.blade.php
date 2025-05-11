<div>
    <x-slot name="header">
        <div class="mb-1 row">
            <div class="col-sm-6 d-flex align-items-center">
                <h3 class="m-0">
                    <i class="mr-2 fas fa-briefcase"></i> Paket Lelang untuk Penyedia
                </h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#"><i class="fas fa-building"></i> Penyedia</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <i class="fas fa-tasks"></i> Paket Lelang
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
                                                    {{ $item->paketPekerjaan->desa->name ?? '-' }}
                                                </td>
                                                <td class="px-3 py-2 align-middle">
                                                    {{ $item->paketPekerjaan->tahun ?? '-' }}
                                                </td>
                                                <td class="px-3 py-2 align-middle">
                                                    {{ $item->paketPekerjaan->nama_kegiatan ?? '-' }}
                                                </td>
                                                <td class="px-3 py-2 align-middle">
                                                    <span
                                                        class="badge
                                                        @switch($item->paketType->com_cd ?? '')
                                                            @case('PAKET_TYPE_01') bg-primary @break
                                                            @case('PAKET_TYPE_02') bg-warning text-dark @break
                                                            @case('PAKET_TYPE_03') bg-success @break
                                                            @default bg-secondary
                                                        @endswitch">
                                                        {{ $item->paketType->code_nm ?? '-' }}
                                                    </span>
                                                </td>
                                                <td class="px-3 py-2 align-middle text-end">
                                                    Rp{{ number_format($item->jumlah_anggaran ?? 0, 0, ',', '.') }}
                                                </td>
                                                <td class="px-3 py-2 align-middle text-end">
                                                    Rp{{ number_format($item->nilai_kontrak ?? 0, 0, ',', '.') }}
                                                </td>
                                                <td class="px-3 py-2 align-middle">
                                                    {{-- <ul class="mb-0 list-unstyled">
                                                        <li>
                                                            @if ($item->bukti_setor_pajak)
                                                                <i class="fas fa-check-circle text-success"></i>
                                                                <a href="{{ Storage::url($item->bukti_setor_pajak) }}"
                                                                    target="_blank">Bukti Setor Pajak</a>
                                                            @else
                                                                <i class="fas fa-times-circle text-danger"></i> Bukti
                                                                Setor Pajak
                                                            @endif
                                                        </li>
                                                        <li>
                                                            @if ($item->dok_penawaran)
                                                                <i class="fas fa-check-circle text-success"></i>
                                                                <a href="{{ Storage::url($item->dok_penawaran) }}"
                                                                    target="_blank">Dokumen Penawaran</a>
                                                            @else
                                                                <i class="fas fa-times-circle text-danger"></i> Dokumen
                                                                Penawaran
                                                            @endif
                                                        </li>
                                                        <li>
                                                            @if ($item->dok_kebenaran_usaha)
                                                                <i class="fas fa-check-circle text-success"></i>
                                                                <a href="{{ Storage::url($item->dok_kebenaran_usaha) }}"
                                                                    target="_blank">Dok Kebenaran Usaha</a>
                                                            @else
                                                                <i class="fas fa-times-circle text-danger"></i> Dok
                                                                Kebenaran Usaha
                                                            @endif
                                                        </li>
                                                    </ul> --}}
                                                </td>
                                                <td class="px-3 py-2 align-middle">
                                                    {{-- @if ($item->statusPenawaran)
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
                                                    @endif --}}
                                                </td>
                                                {{-- <h1>{{ $item->id . ' ' . auth()->user()->vendor_id }}</h1> --}}
                                                <td class="px-3 py-2 text-center align-middle">
                                                    <div class="d-flex justify-content-center gap-3">
                                                        <!-- Tombol Upload/Edit -->
                                                        <a href="{{ route('penyedia.pengajuan-lelang.create', ['paketKegiatanId' => $item->id, 'vendorId' => auth()->user()->vendor_id]) }}"
                                                            class="btn btn-outline-secondary btn-sm d-flex align-items-center mr-1">
                                                            <i class="mr-1 fas fa-upload"></i> Upload/Edit
                                                        </a>


                                                        <!-- Tombol Negosiasi (conditional) -->
                                                        @if (
                                                            $item->paketKegiatan->negosiasi &&
                                                                $item->paketKegiatan->paket_type != 'PAKET_TYPE_02' &&
                                                                $item->statusPenawaran?->com_cd == 'PENAWARAN_ST_02')
                                                            <a href="{{ route('desa.penawaran.pelaksanaan.negosiasi', $item->paketKegiatan->id) }}"
                                                                class="btn btn-outline-info btn-sm d-flex align-items-center mr-1">
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
