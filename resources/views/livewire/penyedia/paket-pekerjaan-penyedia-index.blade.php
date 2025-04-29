<div>
    <x-slot name="header">
        <div class="mb-1 row">
            <div class="col-sm-6">
                <h3 class="m-0">Paket Pekerjaan untuk Penyedia</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Penyedia</a></li>
                    <li class="breadcrumb-item active">Paket Pekerjaan</li>
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
                                    <input type="text" class="form-control" placeholder="Cari kegiatan..."
                                        wire:model.debounce.500ms="cari">
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr class="bg-light">
                                            <th>Desa</th>
                                            <th>Tahun</th>
                                            <th>Kegiatan</th>
                                            <th>Pagu</th>
                                            <th>Status Dokumen</th>
                                            <th>Status</th> <!-- Tambahan -->
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($posts as $item)
                                            <tr>
                                                <td>{{ $item->paketKegiatan->paketPekerjaan->desa->name ?? '-' }}</td>
                                                <td>{{ $item->paketKegiatan->paketPekerjaan->tahun ?? '-' }}</td>
                                                <td>{{ $item->paketKegiatan->paketPekerjaan->nama_kegiatan ?? '-' }}
                                                </td>
                                                <td class="text-end">
                                                    Rp{{ number_format($item->paketKegiatan->jumlah_anggaran ?? 0, 0, ',', '.') }}
                                                </td>
                                                <td>
                                                    <ul class="mb-0 list-unstyled">
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
                                                <td>
                                                    {{ $item->statusPenawaran->code_nm ?? '-' }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('penyedia.penawaran.create', $item->id) }}"
                                                        class="btn btn-sm btn-success">
                                                        Upload / Edit Penawaran
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">
                                                    Tidak ada data.
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
</div>
