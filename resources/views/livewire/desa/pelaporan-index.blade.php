<div>
    <x-slot name="header">
        <div class="mb-1 row">
            <div class="col-sm-6 d-flex align-items-center">
                <h3 class="m-0">
                    <i class="mr-2 fas fa-file-alt"></i> Pelaporan Paket Kegiatan
                </h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#"><i class="fas fa-folder-open"></i> Pelaporan</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <i class="fas fa-list"></i> Index
                    </li>
                </ol>
            </div>
        </div>
    </x-slot>

    <section class="content">
        <div class="container-fluid">

            @if (session()->has('message'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('message') }}
                </div>
            @endif

            <div class="card card-info card-outline">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fas fa-list-alt"></i> Daftar Pelaporan Kegiatan
                    </h5>
                </div>

                <div class="card-body">
                    <div class="mb-3 row">
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="🔍 Cari kegiatan..."
                                wire:model.debounce.500ms="search">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="text-white bg-dark">
                                <tr>
                                    <th>Desa</th>
                                    <th>Tahun</th>
                                    <th>Kegiatan</th>
                                    <th>Jenis Pengadaan</th>
                                    <th>Status Kegiatan</th>
                                    <th class="text-end">Anggaran</th>
                                    <th>Dokumen</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($paketKegiatans as $paket)
                                    <tr>
                                        <td>{{ $paket->paketPekerjaan->desa->name ?? '-' }}</td>
                                        <td>{{ $paket->paketPekerjaan->tahun ?? '-' }}</td>
                                        <td>{{ $paket->paketPekerjaan->nama_kegiatan ?? '-' }}</td>
                                        <td class="px-3 py-2 align-middle">
                                            @php
                                                $type = $paket->paketType->com_cd ?? null;
                                                $label = $paket->paketType->code_nm ?? '-';
                                                $badgeClass = match ($type) {
                                                    'PAKET_TYPE_01' => 'badge bg-primary', // Penyedia
                                                    'PAKET_TYPE_02' => 'badge bg-warning', // Swakelola
                                                    'PAKET_TYPE_03' => 'badge bg-info', // Lelang
                                                    default => 'badge bg-secondary',
                                                };
                                            @endphp

                                            <span class="{{ $badgeClass }}">
                                                <i class="mr-1 fas fa-tag"></i>
                                                {{ $label }}
                                            </span>

                                        </td>
                                        <td>

                                            <span class="badge bg-secondary">
                                                {{ $paket->statusKegiatan->code_nm ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            Rp{{ number_format($paket->jumlah_anggaran, 0, ',', '.') }}
                                        </td>
                                        <td class="text-nowrap">
                                            {{-- Surat Perjanjian --}}
                                            @if ($paket->surat_perjanjian)
                                                <a href="{{ route('helper.show-picture', ['path' => $paket->surat_perjanjian]) }}"
                                                    target="_blank" class="mb-1 btn btn-sm btn-primary">
                                                    <i class="fas fa-file-signature"></i> Surat Perjanjian
                                                </a>
                                            @else
                                                <span class="badge bg-secondary">Belum Ada SP</span>
                                            @endif

                                            {{-- BA Evaluasi jika anggaran > 10jt --}}
                                            @if ($paket->jumlah_anggaran > 10000000)
                                                <br>
                                                @if ($paket->ba_evaluasi_penawaran)
                                                    <a href="{{ route('helper.show-picture', ['path' => $paket->ba_evaluasi_penawaran]) }}"
                                                        target="_blank" class="mt-1 btn btn-sm btn-success">
                                                        <i class="fas fa-file-alt"></i> BA Evaluasi
                                                    </a>
                                                @else
                                                    <span class="mt-1 badge bg-warning text-dark">
                                                        <i class="fas fa-exclamation-circle"></i> Belum Upload BA
                                                    </span>
                                                @endif
                                            @endif
                                        </td>

                                        <td class="text-center text-nowrap">
                                            <a href="" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Lihat Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-4 text-center text-muted">
                                            <i class="fas fa-folder-open"></i> Tidak ada data pelaporan tersedia.
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
    </section>
</div>
