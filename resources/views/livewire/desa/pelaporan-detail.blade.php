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
                                <div class="text-center card shadow-lg rounded">
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
                    <div class="mb-4 shadow-md card">
                        <div class="card-header bg-secondary">
                            <strong>Profil Penyedia</strong>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 d-flex align-items-start">
                                <!-- Vendor Image -->
                                <img class="mr-3 rounded-circle" width="80" height="80"
                                    src="https://ui-avatars.com/api/?name={{ urlencode($paketKegiatan->negosiasi?->vendor?->nama_perusahaan ?? 'V') }}"
                                    alt="vendor">

                                <!-- Vendor Details -->
                                <div class="media-body">
                                    <table class="no-border"
                                        style="width: 100%; font-family: Arial, sans-serif; font-size: 10pt; border: none; border-collapse: collapse;">
                                        <tr>
                                            <td style="width: 30%;"><strong>Nama Perusahaan</strong></td>
                                            <td style="width: 70%;">
                                                {{ $paketKegiatan->negosiasi?->vendor?->nama_perusahaan ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>NIB</strong></td>
                                            <td>{{ $paketKegiatan->negosiasi?->vendor?->nib ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>NPWP</strong></td>
                                            <td>{{ $paketKegiatan->negosiasi?->vendor?->npwp ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Alamat</strong></td>
                                            <td>{{ $paketKegiatan->negosiasi?->vendor?->alamat ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Telepon</strong></td>
                                            <td>{{ $paketKegiatan->negosiasi?->vendor?->telepon ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Direktur</strong></td>
                                            <td>{{ $paketKegiatan->negosiasi?->vendor?->nama_direktur ?? '-' }}</td>
                                        </tr>
                                    </table>

                                    <a href="{{ route('penyedia.vendor-profile', $paketKegiatan->negosiasi?->vendor?->id) }}"
                                        class="mt-2 btn btn-sm btn-outline-primary">
                                        <i class="fas fa-user"></i> Lihat Profil Lengkap
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>


                    <!-- Upload Dokumen dan Tutup/Batal Kegiatan -->
                    <div class="mb-4 shadow-md card border-top border-primary">
                        <div class="text-white card-header bg-secondary">
                            <i class="fas fa-upload"></i> Upload Dokumen Pelaporan Akhir
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="save" enctype="multipart/form-data">
                                @if ($paketKegiatan->paket_kegiatan === 'PAKET_KEGIATAN_ST_02')
                                    <div class="row">
                                        @foreach ([
        'laporan-hasil-pemeriksaan' => 'Laporan Hasil Pemeriksaan',
        'bast-dari-penyedia-kepada-kasi' => 'BAST Penyedia',
        'bast-dari-kasi-kepada-kades' => 'BAST Kepala Desa',
    ] as $field => $label)
                                            <div class="mb-3 col-md-4">
                                                <label for="{{ $field }}"
                                                    class="form-label">{{ $label }}</label>
                                                <div class="input-group">
                                                    <input type="file" wire:model="{{ $field }}"
                                                        class="form-control">
                                                    <a href="{{ route('generator.penyedia.' . $field) }}"
                                                        target="_blank" class="btn btn-outline-info">
                                                        <i class="fas fa-magic"></i>
                                                    </a>
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

                                    @if ($paketKegiatan->bast_penyedia && $paketKegiatan->bast_kades && $paketKegiatan->laporan_hasil_pemeriksaan)
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
                        <div class="bg-secondary card-header">
                            <strong>Informasi Proyek</strong>
                        </div>
                        <div class="card-body">
                            <p><strong>Nama
                                    Kegiatan:</strong><br>{{ $paketKegiatan->paketPekerjaan->nama_kegiatan ?? '-' }}
                            </p>
                            <p><strong>Status:</strong><br>
                                <span class="badge badge-info">
                                    {{ $paketKegiatan->statusKegiatan->code_nm ?? '-' }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="shadow-sm card">
                        <div class="bg-secondary card-header">
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
                                            class="badge bg-primary">Lihat</a>
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
