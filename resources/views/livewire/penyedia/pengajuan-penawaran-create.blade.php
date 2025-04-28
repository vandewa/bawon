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
            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">📋 Detail Paket Pekerjaan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5><i class="fas fa-map-marker-alt"></i> Nama Desa</h5>
                            <p>{{ $penawaran->paketKegiatan->paketPekerjaan->desa->name ?? '-' }}</p>
                        </div>

                        <div class="col-md-6">
                            <h5><i class="fas fa-calendar-alt"></i> Tahun Kegiatan</h5>
                            <p>{{ $penawaran->paketKegiatan->paketPekerjaan->tahun ?? '-' }}</p>
                        </div>

                        <div class="col-md-12 mt-3">
                            <h5><i class="fas fa-tasks"></i> Nama Kegiatan</h5>
                            <p>{{ $penawaran->paketKegiatan->paketPekerjaan->nama_kegiatan ?? '-' }}</p>
                        </div>

                        <div class="col-md-12 mt-3">
                            <h5><i class="fas fa-clock"></i> Batas Akhir Pengajuan</h5>
                            <p>
                                {{ \Carbon\Carbon::parse($penawaran->batas_akhir)->translatedFormat('d F Y H:i') }}
                                @if (now()->greaterThan($penawaran->batas_akhir))
                                    <span class="badge badge-danger ml-2">Batas Waktu Terlampaui</span>
                                @endif
                            </p>
                        </div>

                        <div class="col-md-12 mt-3">
                            <h5><i class="fas fa-folder-open"></i> Dokumen Terkait</h5>
                            <ul class="list-group">
                                @if ($penawaran->paketKegiatan->spek_teknis)
                                    <li class="list-group-item">
                                        <a href="{{ Storage::url($penawaran->paketKegiatan->spek_teknis) }}"
                                            target="_blank">
                                            📄 Spek Teknis
                                        </a>
                                    </li>
                                @endif
                                @if ($penawaran->paketKegiatan->kak)
                                    <li class="list-group-item">
                                        <a href="{{ Storage::url($penawaran->paketKegiatan->kak) }}" target="_blank">
                                            📄 KAK (Kerangka Acuan Kerja)
                                        </a>
                                    </li>
                                @endif
                                @if ($penawaran->paketKegiatan->jadwal_pelaksanaan)
                                    <li class="list-group-item">
                                        <a href="{{ Storage::url($penawaran->paketKegiatan->jadwal_pelaksanaan) }}"
                                            target="_blank">
                                            📄 Jadwal Pelaksanaan
                                        </a>
                                    </li>
                                @endif
                                @if ($penawaran->paketKegiatan->rencana_kerja)
                                    <li class="list-group-item">
                                        <a href="{{ Storage::url($penawaran->paketKegiatan->rencana_kerja) }}"
                                            target="_blank">
                                            📄 Rencana Kerja
                                        </a>
                                    </li>
                                @endif
                                @if ($penawaran->paketKegiatan->hps)
                                    <li class="list-group-item">
                                        <a href="{{ Storage::url($penawaran->paketKegiatan->hps) }}" target="_blank">
                                            📄 Harga Perkiraan Sendiri (HPS)
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Cek Batas Akhir --}}
            @if (now()->lessThanOrEqualTo($penawaran->batas_akhir))
                {{-- Form Upload Penawaran --}}
                <div class="card mt-3">
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

                            <div class="form-group">
                                <label>Bukti Setor Pajak</label>
                                @if ($penawaran->bukti_setor_pajak)
                                    <div class="mb-2">
                                        <a href="{{ Storage::url($penawaran->bukti_setor_pajak) }}" target="_blank"
                                            class="btn btn-sm btn-info">
                                            Lihat File Sebelumnya
                                        </a>
                                    </div>
                                @endif
                                <input type="file" class="form-control" wire:model="bukti_setor_pajak">
                                @error('bukti_setor_pajak')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Dokumen Penawaran</label>
                                @if ($penawaran->dok_penawaran)
                                    <div class="mb-2">
                                        <a href="{{ Storage::url($penawaran->dok_penawaran) }}" target="_blank"
                                            class="btn btn-sm btn-info">
                                            Lihat File Sebelumnya
                                        </a>
                                    </div>
                                @endif
                                <input type="file" class="form-control" wire:model="dok_penawaran">
                                @error('dok_penawaran')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Dokumen Kebenaran Usaha</label>
                                @if ($penawaran->dok_kebenaran_usaha)
                                    <div class="mb-2">
                                        <a href="{{ Storage::url($penawaran->dok_kebenaran_usaha) }}" target="_blank"
                                            class="btn btn-sm btn-info">
                                            Lihat File Sebelumnya
                                        </a>
                                    </div>
                                @endif
                                <input type="file" class="form-control" wire:model="dok_kebenaran_usaha">
                                @error('dok_kebenaran_usaha')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Keterangan Tambahan</label>
                                <textarea class="form-control" rows="3" wire:model="keterangan"></textarea>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan Pengajuan</button>
                            <a href="{{ route('penyedia.penawaran-index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            @else
                {{-- Info Batas Akhir Terlampaui --}}
                <div class="alert alert-danger mt-3">
                    <h5 class="mb-1"><i class="fas fa-exclamation-triangle"></i> Batas Waktu Pengajuan Telah
                        Terlampaui</h5>
                    <p>Maaf, Anda tidak dapat lagi mengirimkan atau mengubah dokumen penawaran untuk paket ini.</p>
                    <a href="{{ route('penyedia.penawaran-index') }}" class="btn btn-sm btn-light mt-2">Kembali ke
                        Daftar
                        Paket</a>
                </div>
            @endif

        </div>
    </section>
</div>
