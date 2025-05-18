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
                                                    <th>TPK</th>
                                                    <th>Nilai Kesepakatan</th>
                                                    <th>Status</th>
                                                    <th>Kelengkapan Dokumen</th> <!-- Kolom baru -->
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($paketKegiatans as $index => $item)
                                                    @php
                                                        $dokLengkap =
                                                            $item->spek_teknis &&
                                                            $item->kak &&
                                                            $item->jadwal_pelaksanaan &&
                                                            $item->hps;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $item->paketType->code_nm }}</td>
                                                        <td>Rp {{ number_format($item->jumlah_anggaran, 0, ',', '.') }}
                                                        </td>
                                                        <td>{{ $item->tpk->aparatur->nama ?? '-' }} -
                                                            {{ $item->tpk->jenis->code_nm ?? '-' }}</td>
                                                        <td>Rp
                                                            {{ number_format($item->nilai_kesepakatan ?? 0, 0, ',', '.') }}
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="badge {{ $item->paketKegiatan->code_value ?? 'bg-danger' }}">
                                                                {{ $item->paketKegiatan->code_nm ?? '-' }}
                                                            </span>
                                                        </td>

                                                        {{-- Kelengkapan dokumen --}}
                                                        <td>
                                                            @php
                                                                $dokumen = [
                                                                    'Spek Teknis' => $item->spek_teknis,
                                                                    'KAK' => $item->kak,
                                                                    'Jadwal Pelaksanaan' => $item->jadwal_pelaksanaan,
                                                                    'Rencana Kerja' => $item->rencana_kerja,
                                                                    'HPS' => $item->hps,
                                                                ];
                                                            @endphp

                                                            <ul class="pl-3 mb-0 small">
                                                                @foreach ($dokumen as $nama => $isi)
                                                                    <li>
                                                                        {{ $nama }}
                                                                        @if ($isi)
                                                                            <a href="{{ Storage::url($isi) }}"
                                                                                target="_blank" title="Preview dokumen"
                                                                                data-toggle="tooltip">
                                                                                ✅
                                                                            </a>
                                                                        @else
                                                                            ❌
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </td>


                                                        {{-- Aksi --}}
                                                        <td>
                                                            <a href="{{ route('desa.paket-kegiatan.persiapan.edit', $item->id) }}"
                                                                class="mr-1 btn btn-sm btn-primary">Edit</a>
                                                            {{-- @if ($item->paket_kegiatan != 'PAKET_KEGIATAN_ST_02') --}}
                                                            <button class="btn btn-sm btn-danger"
                                                                wire:click="delete('{{ $item->id }}')">Hapus</button>
                                                            {{-- @endif --}}

                                                            @if ($dokLengkap && $item->paket_kegiatan != 'PAKET_KEGIATAN_ST_02')
                                                                <button class="mt-1 btn btn-sm btn-success"
                                                                    wire:click="confirmChangeStatus('{{ $item->id }}')">
                                                                    <i class="fas fa-check"></i> Selanjutnya
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center">Belum ada data paket
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
