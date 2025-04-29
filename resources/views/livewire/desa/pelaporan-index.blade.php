<div>
    <x-slot name="header">
        <div class="mb-1 row">
            <div class="col-sm-6">
                <h3 class="m-0">Pelaporan Paket Kegiatan</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Pelaporan</a></li>
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
                                                    @if ($item->penawaran_st !== 'PENAWARAN_ST_01')
                                                        @if (!empty($item->paketKegiatan->ba_evaluasi_penawaran))
                                                            <a href="{{ Storage::url($item->paketKegiatan->ba_evaluasi_penawaran) }}"
                                                                target="_blank" class="btn btn-sm btn-outline-primary">
                                                                Lihat BA Evaluasi
                                                            </a>
                                                        @else
                                                            <span class="badge bg-warning text-dark">BA Evaluasi belum
                                                                tersedia</span>
                                                        @endif
                                                    @else
                                                        {{ $item->statusPenawaran->code_nm ?? '-' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-primary">
                                                        Lihat Detail
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">
                                                    Tidak ada data pelaporan yang tersedia.
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
    </section>
</div>
