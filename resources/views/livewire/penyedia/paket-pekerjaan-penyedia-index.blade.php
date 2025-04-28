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
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-md-3">
                                <input type="text" class="form-control" placeholder="Cari kegiatan..."
                                    wire:model.live="cari">
                            </div>
                        </div>

                        <div class="card card-info card-outline card-tabs">
                            <div class="tab-content">
                                <div class="tab-pane fade show active">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Desa</th>
                                                        <th>Tahun</th>
                                                        <th>Kegiatan</th>
                                                        <th>Sumber Dana</th>
                                                        <th>Pagu</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($posts as $item)
                                                        <tr>
                                                            <td>{{ $item->desa->name ?? '-' }}</td>
                                                            <td>{{ $item->tahun }}</td>
                                                            <td>{{ $item->nama_kegiatan }}</td>
                                                            <td>{{ $item->sumberdana }}</td>
                                                            <td class="text-right">
                                                                {{ number_format($item->pagu_pak, 0, ',', '.') }}
                                                            </td>
                                                            <td>
                                                                <a href="" class="btn btn-sm btn-success">
                                                                    Pengajuan Penawaran
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        {{ $posts->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
</div>
