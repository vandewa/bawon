<div>
    <x-slot name="header">
        <div class="mb-1 row">
            <div class="col-sm-6">
                <h3 class="m-0">Pengajuan Penawaran</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Penyedia</a></li>
                    <li class="breadcrumb-item active">Pengajuan Penawaran</li>
                </ol>
            </div>
        </div>
    </x-slot>

    <section class="content">
        <div class="container-fluid">
            {{-- Detail Paket --}}
            <div class="mb-3 card">
                <div class="text-white card-header bg-info">
                    <h5 class="mb-0">📋 Detail Paket Pekerjaan</h5>
                </div>
                <div class="card-body row">
                    <div class="col-md-6">
                        <h5><i class="fas fa-map-marker-alt"></i> Nama Desa</h5>
                        <p>{{ $penawaran->paketKegiatan->paketPekerjaan->desa->name ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5><i class="fas fa-calendar-alt"></i> Tahun Kegiatan</h5>
                        <p>{{ $penawaran->paketKegiatan->paketPekerjaan->tahun ?? '-' }}</p>
                    </div>
                    <div class="mt-3 col-md-6">
                        <h5><i class="fas fa-tasks"></i> Nama Kegiatan</h5>
                        <p>{{ $penawaran->paketKegiatan->paketPekerjaan->nama_kegiatan ?? '-' }}</p>
                    </div>
                    <div class="mt-3 col-md-6">
                        <h5><i class="fas fa-money-bill"></i> HPS</h5>
                        <p>Rp {{ number_format($penawaran->paketKegiatan->jumlah_anggaran ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="mt-3 col-md-12">
                        <h5><i class="fas fa-clock"></i> Batas Akhir Pengajuan</h5>
                        <p>
                            {{ \Carbon\Carbon::parse($penawaran->batas_akhir)->translatedFormat('d F Y H:i') }}
                            @if (now()->greaterThan($penawaran->batas_akhir))
                                <span class="ml-2 badge badge-danger">Batas Waktu Terlampaui</span>
                            @endif
                        </p>
                    </div>

                    <div class="mt-3 col-md-12">
                        <h5><i class="fas fa-folder-open"></i> Dokumen Terkait</h5>
                        <ul class="list-group">
                            @if ($penawaran->paketKegiatan->spek_teknis)
                                <li class="list-group-item">
                                    <a href="{{ route('helper.show-picture', ['path' => $penawaran->paketKegiatan->spek_teknis]) }}"
                                        target="_blank">
                                        📄 Spek Teknis
                                    </a>
                                </li>
                            @endif
                            @if ($penawaran->paketKegiatan->kak)
                                <li class="list-group-item">
                                    <a href="{{ route('helper.show-picture', ['path' => $penawaran->paketKegiatan->kak]) }}"
                                        target="_blank">
                                        📄 KAK (Kerangka Acuan Kerja)
                                    </a>
                                </li>
                            @endif
                            @if ($penawaran->paketKegiatan->jadwal_pelaksanaan)
                                <li class="list-group-item">
                                    <a href="{{ route('helper.show-picture', ['path' => $penawaran->paketKegiatan->jadwal_pelaksanaan]) }}"
                                        target="_blank">
                                        📄 Jadwal Pelaksanaan
                                    </a>
                                </li>
                            @endif
                            @if ($penawaran->paketKegiatan->rencana_kerja)
                                <li class="list-group-item">
                                    <a href="{{ route('helper.show-picture', ['path' => $penawaran->paketKegiatan->rencana_kerja]) }}"
                                        target="_blank">
                                        📄 Rencana Kerja
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </div>
            </div>

            {{-- Form Upload --}}
            @if (now()->lessThanOrEqualTo($penawaran->batas_akhir))
                <div class="mt-3 card">
                    <form wire:submit.prevent="save">
                        <div class="card-header">
                            <h5>Form Upload Penawaran</h5>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label>Nilai Penawaran (Rp)</label>
                                <input type="number" class="form-control" wire:model="nilai">
                                @error('nilai')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Bukti Setor Pajak --}}
                            <div class="form-group">
                                <label>Bukti Setor Pajak</label>
                                @if ($penawaran->bukti_setor_pajak)
                                    <div class="mb-2">
                                        <a href="{{ route('helper.show-picture', ['path' => $penawaran->bukti_setor_pajak]) }}"
                                            target="_blank" class="btn btn-sm btn-info">Lihat File Sebelumnya</a>
                                    </div>
                                @endif
                                <input type="file" class="form-control" wire:model="bukti_setor_pajak">
                                <div wire:loading wire:target="bukti_setor_pajak" class="mt-2 text-info">
                                    <i class="fas fa-spinner fa-spin"></i> Mengunggah bukti setor pajak...
                                </div>
                                @error('bukti_setor_pajak')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Dokumen Penawaran --}}
                            <div class="form-group">
                                <label>Dokumen Penawaran</label>
                                @if ($penawaran->dok_penawaran)
                                    <div class="mb-2">
                                        <a href="{{ route('helper.show-picture', ['path' => $penawaran->dok_penawaran]) }}"
                                            target="_blank" class="btn btn-sm btn-info">Lihat File Sebelumnya</a>
                                    </div>
                                @endif
                                <input type="file" class="form-control" wire:model="dok_penawaran">
                                <div wire:loading wire:target="dok_penawaran" class="mt-2 text-info">
                                    <i class="fas fa-spinner fa-spin"></i> Mengunggah dokumen penawaran...
                                </div>
                                @error('dok_penawaran')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Dokumen Kebenaran Usaha --}}
                            <div class="form-group">
                                <label>Dokumen Kebenaran Usaha</label>
                                @if ($penawaran->dok_kebenaran_usaha)
                                    <div class="mb-2">
                                        <a href="{{ route('helper.show-picture', ['path' => $penawaran->dok_kebenaran_usaha]) }}"
                                            target="_blank" class="btn btn-sm btn-info">Lihat File Sebelumnya</a>
                                    </div>
                                @endif
                                <input type="file" class="form-control" wire:model="dok_kebenaran_usaha">
                                <div wire:loading wire:target="dok_kebenaran_usaha" class="mt-2 text-info">
                                    <i class="fas fa-spinner fa-spin"></i> Mengunggah dokumen kebenaran usaha...
                                </div>
                                @error('dok_kebenaran_usaha')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Keterangan --}}
                            <div class="form-group">
                                <label>Keterangan Tambahan</label>
                                <textarea class="form-control" rows="3" wire:model="keterangan"></textarea>
                            </div>

                            <h5 class="mb-3">📦 Penawaran per Item</h5>

                            <table class="table table-bordered table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th>Uraian</th>
                                        <th class="text-center" style="width: 10%">Qty</th>
                                        <th class="text-center" style="width: 15%">Satuan</th>
                                        <th class="text-center" style="width: 20%">Harga Satuan (Rp)</th>
                                        <th class="text-center" style="width: 20%">Subtotal (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penawaran->paketKegiatan->rincian as $index => $rinci)
                                        @php

                                            $pekerjaan = $rinci->rincian;
                                            $qty = $rinci->quantity;
                                            $harga = $penawaranItems[$rinci->id] ?? 0;
                                            $subtotal = $qty * $harga;
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>{{ $pekerjaan->uraian ?? '—' }}</td>
                                            <td class="text-center">{{ $qty }}</td>
                                            <td class="text-center">{{ $pekerjaan->satuan ?? '-' }}</td>
                                            <td>
                                                <input type="number" step="any" min="0"
                                                    class="text-right form-control"
                                                    wire:model.live.debounce.250ms
="penawaranItems.{{ $rinci->id }}"
                                                    placeholder="0.00">
                                                @error("penawaranItems.$rinci->id")
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </td>
                                            <td class="text-right">
                                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                @if (!empty($penawaranItems))
                                    <tfoot>
                                        @php
                                            $total = 0;
                                            foreach ($penawaranItems as $rinciId => $harga) {
                                                $rinci = $penawaran->paketKegiatan->rincian->firstWhere('id', $rinciId);
                                                $qty = $rinci?->quantity ?? 0;
                                                $total += $harga * $qty;
                                            }
                                        @endphp
                                        <tr>
                                            <th colspan="5" class="text-right">Total Penawaran</th>
                                            <th class="text-right">Rp {{ number_format($total, 0, ',', '.') }}</th>
                                        </tr>
                                    </tfoot>
                                @endif
                            </table>


                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                                    wire:target="bukti_setor_pajak,dok_penawaran,dok_kebenaran_usaha">
                                    Simpan Pengajuan
                                </button>
                                <a href="{{ route('penyedia.penawaran-index') }}"
                                    class="btn btn-secondary">Kembali</a>
                                <a href="{{ asset('surat_penawaran.docx') }}" class="btn btn-info">Generate
                                    Penawaran</a>
                            </div>
                    </form>
                </div>
            @else
                <div class="mt-3 alert alert-danger">
                    <h5 class="mb-1"><i class="fas fa-exclamation-triangle"></i> Batas Waktu Pengajuan Telah
                        Terlampaui</h5>
                    <p>Maaf, Anda tidak dapat lagi mengirimkan atau mengubah dokumen penawaran untuk paket ini.</p>
                    <a href="{{ route('penyedia.penawaran-index') }}" class="mt-2 btn btn-sm btn-light">Kembali ke
                        Daftar Paket</a>
                </div>
            @endif
        </div>
    </section>
</div>
