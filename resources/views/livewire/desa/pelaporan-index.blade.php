<div>
    <x-slot name="header">
        <div class="mb-1 row">
            <div class="col-sm-6 d-flex align-items-center">
                <h3 class="m-0">
                    <i class="fas fa-file-alt mr-2"></i> Pelaporan Paket Kegiatan
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
                                                                            @if ($paket->penawaran_st !== 'PENAWARAN_ST_01')
                                                                                @if (!empty($paket->paketKegiatan->ba_evaluasi_penawaran))
                                                                                    <a href="{{ Storage::url($paket->paketKegiatan->ba_evaluasi_penawaran) }}"
                                                                                        target="_blank"
                                                                                        class="btn btn-sm btn-success mb-1">
                                                                                        <i class="fas fa-file-alt"></i>
                                                                                        BA Evaluasi
                                                                                    </a>
                                                                                @else
                                                                                    <span
                                                                                        class="badge bg-warning text-dark">
                                                                                        <i
                                                                                            class="fas fa-exclamation-circle"></i>
                                                                                        Belum Upload
                                                                                    </span>
                                                                                @endif
                                                                            @else
                                                                                <span class="badge bg-secondary">
                                                                                    {{ $paket->statusPenawaran->code_nm ?? '-' }}
                                                                                </span>
                                                                            @endif
                                                                        </td>
                                                                        <td
                                                                            class="px-3 py-2 text-center align-middle text-nowrap">
                                                                            <a href="#"
                                                                                class="btn btn-sm btn-info mb-1">
                                                                                <i class="fas fa-eye"></i> Lihat Detail
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="7"
                                                                            class="text-center text-muted py-4">
                                                                            <i class="fas fa-folder-open"></i> Tidak ada
                                                                            data pelaporan yang tersedia.
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
            </div> <!-- /.row -->

        </div>
    </section>
</div>
