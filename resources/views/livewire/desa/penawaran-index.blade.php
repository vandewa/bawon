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
            <div class="row">
                <div class="col-md-12">
                    <div class="card-body">
                        <div class="tab-pane fade active show">
                            <div class="tab-pane active show fade" id="custom-tabs-one-rm" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-info card-outline card-tabs">
                                            <div class="tab-content">
                                                <div class="tab-pane fade show active">
                                                    <div class="card-body">
                                                        <div class="mb-3 row">
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Cari kegiatan..."
                                                                    wire:model.debounce.500ms="search">
                                                            </div>
                                                        </div>

                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Desa</th>
                                                                        <th>Tahun</th>
                                                                        <th>Kegiatan</th>
                                                                        <th>Paket</th>
                                                                        <th>Anggaran</th>
                                                                        <th>Aksi</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($paketKegiatans as $paket)
                                                                        <tr>
                                                                            <td>{{ $paket->paketPekerjaan->desa->name ?? '-' }}
                                                                            </td>
                                                                            <td>{{ $paket->paketPekerjaan->tahun ?? '-' }}
                                                                            </td>
                                                                            <td>{{ $paket->paketPekerjaan->nama_kegiatan ?? '-' }}
                                                                            </td>
                                                                            <td>{{ $paket->paket_kegiatan }}</td>
                                                                            <td class="text-right">
                                                                                Rp{{ number_format($paket->jumlah_anggaran, 0, ',', '.') }}
                                                                            </td>
                                                                            <td>
                                                                                <a href="{{ route('desa.penawaran.paket', $paket->id) }}"
                                                                                    class="btn btn-sm btn-primary">
                                                                                    Kelola Penawaran
                                                                                </a>
                                                                                <a href="{{ route('desa.penawaran.pelaksanaan.negosiasi', $paket->id) }}"
                                                                                    class="btn btn-sm btn-info">Negosiasi</a>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        {{ $paketKegiatans->links() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
</div>
