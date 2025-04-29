<div>
    <x-slot name="header">
        <div class="mb-1 row">
            <div class="col-sm-6 d-flex align-items-center">
                <h3 class="m-0">
                    <i class="fas fa-briefcase mr-2"></i> Paket Pekerjaan untuk Penyedia
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
                                <table class="table table-hover table-borderless shadow rounded overflow-hidden">
                                    <thead style="background-color: #404040; color: white;">
                                        <tr>
                                            <th class="px-3 py-2">Desa</th>
                                            <th class="px-3 py-2">Tahun</th>
                                            <th class="px-3 py-2">Kegiatan</th>
                                            <th class="px-3 py-2 text-end">Pagu</th>
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
                                                    {{ $item->paketKegiatan->paketPekerjaan->desa->name ?? '-' }}</td>
                                                <td class="px-3 py-2 align-middle">
                                                    {{ $item->paketKegiatan->paketPekerjaan->tahun ?? '-' }}</td>
                                                <td class="px-3 py-2 align-middle">
                                                    {{ $item->paketKegiatan->paketPekerjaan->nama_kegiatan ?? '-' }}
                                                </td>
                                                <td class="px-3 py-2 text-end align-middle">
                                                    Rp{{ number_format($item->paketKegiatan->jumlah_anggaran ?? 0, 0, ',', '.') }}
                                                </td>
                                                <td class="px-3 py-2 align-middle">
                                                    <ul class="list-unstyled mb-0">
                                                        <li>
                                                            @if ($item->bukti_setor_pajak)
                                                                <i class="fas fa-check-circle text-success"></i>
                                                                <a href="{{ Storage::url($item->bukti_setor_pajak) }}"
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
                                                                <a href="{{ Storage::url($item->dok_penawaran) }}"
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
                                                                <a href="{{ Storage::url($item->dok_kebenaran_usaha) }}"
                                                                    target="_blank">
                                                                    Dok Kebenaran Usaha
                                                                </a>
                                                            @else
                                                                <i class="fas fa-times-circle text-danger"></i> Dok
                                                                Kebenaran Usaha
                                                            @endif
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td class="px-3 py-2 align-middle">
                                                    @if ($item->statusPenawaran)
                                                        <span
                                                            class="badge badge-{{ $item->statusPenawaran->com_cd == 'PENAWARAN_ST_01' ? 'warning' : 'success' }}">
                                                            {{ $item->statusPenawaran->code_nm }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-secondary">-</span>
                                                    @endif
                                                </td>
                                                <td class="px-3 py-2 text-center align-middle">
                                                    <div class="flex flex-wrap justify-center gap-2">
                                                        <a href="{{ route('penyedia.penawaran.create', $item->id) }}"
                                                            class="inline-flex items-center gap-1 px-3 py-1.5 text-sm bg-green-100 text-green-800 border border-green-300 rounded hover:bg-green-200 transition">
                                                            <i class="fas fa-upload"></i> Upload/Edit
                                                        </a>

                                                        @if ($item->paketKegiatan->negosiasi && $item->paketKegiatan->paket_type !== 'PAKET_TYPE_02')
                                                            <a href="{{ route('desa.penawaran.pelaksanaan.negosiasi', $item->paketKegiatan->id) }}"
                                                                class="inline-flex items-center gap-1 px-3 py-1.5 text-sm bg-cyan-100 text-cyan-800 border border-cyan-300 rounded hover:bg-cyan-200 transition">
                                                                <i class="fas fa-handshake"></i> Negosiasi
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-4">
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
