<div>
    <x-slot name="header">
        <div class="mb-1 row">
            <div class="col-sm-6">
                <h3 class="m-0">Paket Kegiatan</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Pekerjaan</a></li>
                    <li class="breadcrumb-item active">Paket Kegiatan</li>
                </ol>
            </div>
        </div>
    </x-slot>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- Informasi Paket Pekerjaan -->
                    <livewire:components.paket.informasi-paket :paket-pekerjaan-id="$paketPekerjaan->id" />

                    <!-- List Paket Kegiatan -->
                    <div class="card card-info card-outline card-tabs">
                        <div class="tab-content" id="custom-tabs-six-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-six-riwayat-rm" role="tabpanel"
                                aria-labelledby="custom-tabs-six-riwayat-rm-tab">
                                <div class="card-body">
                                    <div class="mb-2 row">
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" placeholder="Search"
                                                wire:model.live='search'>
                                        </div>
                                        <div class="text-right col-md-10">
                                            <a href="{{ route('desa.paket-kegiatan.persiapan.create', $paketPekerjaan->id) }}"
                                                class="btn btn-info">
                                                <i class="mr-2 fas fa-plus-square"></i>Tambah Paket Kegiatan
                                            </a>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Jenis Paket</th>
                                                    <th>Jumlah Anggaran</th>
                                                    <th>Nilai Kesepakatan</th>
                                                    <th>Spek Teknis</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($paketKegiatans as $index => $item)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $item->paket_type }}</td>
                                                        <td>Rp {{ number_format($item->jumlah_anggaran, 0, ',', '.') }}
                                                        </td>
                                                        <td>Rp
                                                            {{ number_format($item->nilai_kesepakatan ?? 0, 0, ',', '.') }}
                                                        </td>
                                                        <td>{{ $item->spek_teknis ?? '-' }}</td>
                                                        <td>
                                                            <a href="#"
                                                                class="mr-1 btn btn-sm btn-primary">Edit</a>
                                                            <button class="btn btn-sm btn-danger"
                                                                wire:click="delete('{{ $item->id }}')">Hapus</button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center">Belum ada data paket
                                                            kegiatan.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    {{-- Pagination opsional jika pakai pagination --}}
                                    {{-- {{ $paketKegiatans->links() }} --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- /.col-md-12 -->
            </div>
        </div>
    </section>
</div>
