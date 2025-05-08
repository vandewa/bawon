<div>
    <x-slot name="header">
        <h3 class="m-0">
            <i class="fas fa-info-circle"></i> Detail Pelaporan Kegiatan
        </h3>
    </x-slot>

    <section class="content">
        <div class="container-fluid">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('message') }}
                </div>
            @endif

            <div class="row">
                <!-- Left Side -->
                <div class="col-md-8">
                    <!-- Statistik -->
                    <div class="mb-4 row">
                        @foreach ([['label' => 'HPS', 'value' => $paketKegiatan->jumlah_anggaran], ['label' => 'Nilai Pengadaan', 'value' => $paketKegiatan->nilai_kesepakatan], ['label' => 'Sisa', 'value' => $paketKegiatan->jumlah_anggaran - $paketKegiatan->nilai_kesepakatan ?? '-']] as $stat)
                            <div class="col-md-4">
                                <div class="text-center shadow-sm card">
                                    <div class="card-body">
                                        <div class="text-muted small">{{ $stat['label'] }}</div>
                                        <div class="h5">
                                            {{ is_numeric($stat['value']) ? 'Rp' . number_format($stat['value'], 0, ',', '.') : $stat['value'] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Profil Vendor -->
                    <div class="mb-4 shadow-sm card">
                        <div class="card-header bg-light">
                            <strong>Profil Vendor</strong>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 media">
                                <img class="mr-3 rounded-circle" width="48"
                                    src="https://ui-avatars.com/api/?name={{ urlencode($paketKegiatan->negosiasi?->vendor?->nama_perusahaan ?? 'V') }}"
                                    alt="vendor">
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1">
                                        {{ $paketKegiatan->negosiasi?->vendor?->nama_perusahaan ?? '-' }}</h6>
                                    <p class="mb-1"><small class="text-muted">NIB:
                                            {{ $paketKegiatan->negosiasi?->vendor?->nib ?? '-' }}</small></p>
                                    <p class="mb-1">NPWP: {{ $paketKegiatan->negosiasi?->vendor?->npwp ?? '-' }}</p>
                                    <p class="mb-1">Alamat: {{ $paketKegiatan->negosiasi?->vendor?->alamat ?? '-' }}
                                    </p>
                                    <p class="mb-1">Telepon: {{ $paketKegiatan->negosiasi?->vendor?->telepon ?? '-' }}
                                    </p>
                                    <p class="mb-1">Direktur:
                                        {{ $paketKegiatan->negosiasi?->vendor?->nama_direktur ?? '-' }}</p>
                                    <a href="{{ route('penyedia.vendor-profile', $paketKegiatan->negosiasi?->vendor?->id) }}"
                                        class="mt-2 btn btn-sm btn-outline-primary">
                                        <i class="fas fa-user"></i> Lihat Profil Lengkap
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Dokumen dan Tutup/Batal Kegiatan -->
                    <div class="mb-4 shadow-sm card border-top border-primary">
                        <div class="text-white card-header bg-primary">
                            <i class="fas fa-upload"></i> Upload Dokumen Pelaporan Akhir
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="save" enctype="multipart/form-data">
                                @if ($paketKegiatan->paket_kegiatan === 'PAKET_KEGIATAN_ST_02')
                                    <div class="row">
                                        @foreach ([
        'laporan_hasil_pemeriksaan' => 'Laporan Hasil Pemeriksaan',
        'bast_penyedia' => 'BAST Penyedia',
        'bast_kades' => 'BAST Kepala Desa',
    ] as $field => $label)
                                            <div class="mb-3 col-md-4">
                                                <label for="{{ $field }}"
                                                    class="form-label">{{ $label }}</label>
                                                <div class="input-group">
                                                    <input type="file" wire:model="{{ $field }}"
                                                        class="form-control">
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        wire:click="generateDummy('{{ $field }}')">
                                                        <i class="fas fa-magic"></i>
                                                    </button>
                                                </div>
                                                @error($field)
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p>Kegiatan telah di tutup</p>
                                @endif

                                <div class="d-flex justify-content-between">

                                    <button type="submit" class="btn btn-success"
                                        @if ($paketKegiatan->paket_kegiatan === 'KEGIATAN_ST_02') disabled @endif>
                                        <i class="fas fa-save"></i> Simpan Dokumen
                                    </button>

                                    @if ($paketKegiatan->laporan_hasil_pemeriksaan && $paketKegiatan->bast_penyedia && $paketKegiatan->bast_kades)
                                        @if ($paketKegiatan->paket_kegiatan !== 'PAKET_KEGIATAN_ST_02')
                                            <button type="button" class="btn btn-warning"
                                                wire:click="konfirmasiBatalPenutupan">
                                                <i class="fas fa-undo"></i> Batalkan Penutupan
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-danger"
                                                wire:click="konfirmasiTutupKegiatan">
                                                <i class="fas fa-check-circle"></i> Tutup Kegiatan
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="col-md-4">
                    <div class="mb-4 shadow-sm card">
                        <div class="bg-white card-header">
                            <strong>Informasi Proyek</strong>
                        </div>
                        <div class="card-body">
                            <p><strong>Nama
                                    Kegiatan:</strong><br>{{ $paketKegiatan->paketPekerjaan->nama_kegiatan ?? '-' }}
                            </p>
                            <p><strong>Status:</strong><br>{{ $paketKegiatan->statusKegiatan->code_nm ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="shadow-sm card">
                        <div class="bg-white card-header">
                            <strong><i class="fas fa-file-alt"></i> Dokumen Tersedia</strong>
                        </div>
                        <div class="list-group list-group-flush">
                            @php
                                $dokumenAll = [
                                    'Surat Perjanjian' => $paketKegiatan->surat_perjanjian,
                                    'SPK' => $paketKegiatan->spk,
                                    'BA Evaluasi' => $paketKegiatan->ba_evaluasi_penawaran,
                                    'Spek Teknis' => $paketKegiatan->spek_teknis,
                                    'KAK' => $paketKegiatan->kak,
                                    'Jadwal Pelaksanaan' => $paketKegiatan->jadwal_pelaksanaan,
                                    'Rencana Kerja' => $paketKegiatan->rencana_kerja,
                                    'HPS' => $paketKegiatan->hps,
                                    'Laporan Pemeriksaan' => $paketKegiatan->laporan_hasil_pemeriksaan,
                                    'BAST Penyedia' => $paketKegiatan->bast_penyedia,
                                    'BAST Kades' => $paketKegiatan->bast_kades,
                                    'Surat Undangan' => $paketKegiatan->penawaranTerpilih?->surat_undangan,
                                    'Bukti Setor Pajak' => $paketKegiatan->penawaranTerpilih?->bukti_setor_pajak,
                                    'Dokumen Penawaran' => $paketKegiatan->penawaranTerpilih?->dok_penawaran,
                                    'Dokumen Kebenaran Usaha' =>
                                        $paketKegiatan->penawaranTerpilih?->dok_kebenaran_usaha,
                                ];
                            @endphp
                            @foreach ($dokumenAll as $label => $file)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $label }}
                                    @if ($file)
                                        <a href="{{ route('helper.show-picture', ['path' => $file]) }}" target="_blank"
                                            class="badge bg-success">Lihat</a>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
