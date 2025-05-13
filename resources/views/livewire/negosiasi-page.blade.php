<div>
    <!-- Header section -->
    <x-slot name="header">
        <div class="mb-1 row">
            <div class="col-sm-6">
                <h3 class="m-0">Negosiasi</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Master</a></li>
                    <li class="breadcrumb-item active">Negosiasi</li>
                </ol>
            </div>
        </div>
    </x-slot>

    <!-- Content section -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <!-- Card untuk Status Negosiasi dan Nilai Negosiasi -->
                    <div class="row">
                        <!-- Status Negosiasi -->
                        <div class="col-md-4">
                            <div
                                class="card mb-4 {{ $negosiasiStatus == 'NEGOSIASI_ST_02' ? 'border-success shadow-success' : 'border-warning' }}">
                                <div class="card-body">
                                    <h5>Status Negosiasi:</h5>
                                    <span
                                        class="badge {{ $paketKegiatan->negosiasi?->negosiasi_st == 'NEGOSIASI_ST_02' ? 'bg-success' : 'bg-warning' }}">
                                        {{ $paketKegiatan->negosiasi?->status?->code_nm ?? 'Status tidak tersedia' }}
                                    </span>

                                    <hr>

                                    <h5>Nilai Negosiasi Disepakati:</h5>
                                    @if ($paketKegiatan->nilai_kesepakatan && $paketKegiatan->nilai_kesepakatan > 0)
                                        <h4>Rp {{ number_format($paketKegiatan->nilai_kesepakatan, 2, ',', '.') }}</h4>
                                    @else
                                        <h5 class="text-danger">Belum ditentukan</h5>
                                    @endif

                                    <hr>

                                    <h5>Berita Acara Negosiasi:</h5>
                                    @if ($paketKegiatan->negosiasi?->ba_negoisasi)
                                        <a href="{{ route('helper.show-picture', ['path' => $paketKegiatan->negosiasi->ba_negoisasi]) }}"
                                            target="_blank" class="mt-2 btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Lihat BA Negosiasi
                                        </a>
                                    @else
                                        <button type="button" class="mt-2 btn btn-secondary btn-sm" disabled>
                                            <i class="fas fa-eye-slash"></i> BA Belum Tersedia
                                        </button>
                                    @endif

                                    <hr>

                                    <h5>Penawaran Awal:</h5>
                                    <h4>Rp {{ number_format($penawaranAwalDetail->nilai ?? 0, 2, ',', '.') }}</h4>

                                    <hr>

                                    <h5>Dokumen Tambahan:</h5>

                                    @if ($penawaranAwalDetail?->bukti_setor_pajak)
                                        <a href="{{ route('helper.show-picture', ['path' => $penawaranAwalDetail->bukti_setor_pajak]) }}"
                                            target="_blank" class="mb-1 btn btn-outline-primary btn-sm">
                                            <i class="fas fa-file-download"></i> Bukti Setor Pajak
                                        </a>
                                    @endif

                                    @if ($penawaranAwalDetail?->dok_penawaran)
                                        <a href="{{ route('helper.show-picture', ['path' => $penawaranAwalDetail->dok_penawaran]) }}"
                                            target="_blank" class="mb-1 btn btn-outline-info btn-sm">
                                            <i class="fas fa-file-download"></i> Dokumen Penawaran
                                        </a>
                                    @endif

                                    @if (!$penawaranAwalDetail?->bukti_setor_pajak && !$penawaranAwalDetail?->dok_penawaran)
                                        <p class="text-muted">Tidak ada dokumen tambahan.</p>
                                    @endif
                                </div>
                            </div>
                        </div>



                        <!-- Detail Kegiatan -->
                        <div class="col-md-4">
                            <div class="mb-4 card border-info shadow-info">
                                <div class="card-body">
                                    <h5>Detail Kegiatan</h5>
                                    <dl class="row">
                                        <dt class="col-sm-5">Bidang</dt>
                                        <dd class="col-sm-7">{{ $paketKegiatan->paketPekerjaan->nama_bidang ?? '-' }}
                                        </dd>
                                        <dt class="col-sm-5">Sub Bidang</dt>
                                        <dd class="col-sm-7">
                                            {{ $paketKegiatan->paketPekerjaan->nama_subbidang ?? '-' }}
                                        </dd>

                                        <dt class="col-sm-5">Nama Kegiatan</dt>
                                        <dd class="col-sm-7">{{ $paketKegiatan->paketPekerjaan->nama_kegiatan ?? '-' }}
                                        </dd>

                                        <dt class="col-sm-5">Tahun Anggaran</dt>
                                        <dd class="col-sm-7">{{ $paketKegiatan->paketPekerjaan->tahun ?? '-' }}</dd>




                                        <dt class="col-sm-5">Sumber Dana</dt>
                                        <dd class="col-sm-7">{{ $paketKegiatan->paketPekerjaan->sumberdana ?? '-' }}
                                        </dd>







                                        <dt class="col-sm-5">HPS</dt>
                                        <dd class="col-sm-7">Rp
                                            {{ number_format($paketKegiatan->jumlah_anggaran ?? 0, 2, ',', '.') }}</dd>

                                        <dt class="col-sm-5">PKPKD</dt>
                                        <dd class="col-sm-7">{{ $paketKegiatan->paketPekerjaan->nm_pptkd ?? '-' }}
                                            ({{ $paketKegiatan->paketPekerjaan->jbt_pptkd ?? '-' }})</dd>
                                    </dl>

                                </div>
                            </div>
                        </div>

                        <!-- Detail Vendor -->
                        <div class="col-md-4">
                            <div class="mb-4 card border-primary shadow-primary">
                                <div class="card-body">
                                    <h5>Detail Penyedia </h5>
                                    @if ($vendor)
                                        <dl class="row">
                                            <dt class="col-sm-5">Nama</dt>
                                            <dd class="col-sm-7">{{ $vendor->nama_perusahaan }}</dd>

                                            <dt class="col-sm-5">Alamat</dt>
                                            <dd class="col-sm-7">{{ $vendor->alamat }}</dd>

                                            <dt class="col-sm-5">Kontak</dt>
                                            <dd class="col-sm-7">{{ $vendor->kontak }}</dd>

                                            <dt class="col-sm-5">Email</dt>
                                            <dd class="col-sm-7">{{ $vendor->email ?? '-' }}</dd>

                                            <dt class="col-sm-5">NPWP</dt>
                                            <dd class="col-sm-7">{{ $vendor->npwp ?? '-' }}</dd>
                                            <a href="{{ route('penyedia.vendor-profile', $vendor->id) }}"
                                                target="_blank" class="btn btn-sm btn-primary">
                                                <i class="fas fa-user"></i> Lihat Profil Penyedia
                                            </a>
                                        </dl>
                                    @else
                                        <p>Vendor tidak ditemukan.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Card for Riwayat Negosiasi -->
                    <div class="card card-info card-outline">
                        <div class="card-body">
                            <h5>Riwayat Negosiasi</h5>
                            <div class="chat-history">
                                @foreach ($negosiasiLogs as $log)
                                    @php
                                        $isMine = $log->user_id == auth()->id();
                                        $canApprove =
                                            !$log->status_st &&
                                            $loop->first &&
                                            $log->user_id !== auth()->id() &&
                                            $negosiasiStatus != 'NEGOSIASI_ST_02';
                                    @endphp

                                    <div class="mb-2 border shadow-sm card"
                                        style="border-left: 5px solid {{ $isMine ? '#17a2b8' : '#6c757d' }};">
                                        <div
                                            class="px-3 py-2 card-header d-flex justify-content-between align-items-center">
                                            <strong>{{ $log->user->name ?? 'Admin' }}</strong>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($log->created_at)->translatedFormat('d F Y, H:i') }}
                                            </small>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-1">
                                                <strong>Penawaran:</strong>
                                                <span class="text-primary">Rp
                                                    {{ number_format($log->penawaran, 2, ',', '.') }}</span>
                                            </p>

                                            <p class="mb-1">
                                                <strong>Status Log:</strong>
                                                @if ($log->status_st)
                                                    <span class="badge bg-success">Disetujui</span>
                                                @else
                                                    <span class="badge bg-secondary">Belum Disetujui</span>
                                                @endif
                                            </p>

                                            <p class="mb-1">
                                                <strong>Keterangan:</strong> {{ $log->keterangan ?? '-' }}
                                            </p>
                                            @if ($log->items->count())
                                                <div class="mt-3">
                                                    <h5 class="text-muted">Rincian Item:</h5>
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-bordered">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th style="width:5%">#</th>
                                                                    <th>Uraian</th>
                                                                    <th style="width:10%">Volume</th>
                                                                    <th style="width:10%">Satuan</th>
                                                                    <th style="width:15%" class="text-end">Harga Satuan
                                                                        (Rp)</th>
                                                                    <th style="width:15%" class="text-end">Total (Rp)
                                                                    </th>
                                                                    <th>Catatan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($log->items as $i => $item)
                                                                    @php
                                                                        $qty = $item->rincian->quantity ?? 1;
                                                                        $satuan =
                                                                            $item->rincian->rincian->satuan ?? '-';
                                                                        $uraian =
                                                                            $item->rincian->rincian->uraian ?? '-';
                                                                        $harga = $item->penawaran ?? 0;
                                                                        $total = $harga * $qty;
                                                                    @endphp
                                                                    <tr>
                                                                        <td>{{ $i + 1 }}</td>
                                                                        <td>{{ $uraian }}</td>
                                                                        <td class="text-center">{{ $qty }}
                                                                        </td>
                                                                        <td class="text-center">{{ $satuan }}
                                                                        </td>
                                                                        <td class="text-end">Rp
                                                                            {{ number_format($harga, 2, ',', '.') }}
                                                                        </td>
                                                                        <td class="text-end">Rp
                                                                            {{ number_format($total, 2, ',', '.') }}
                                                                        </td>
                                                                        <td>{{ $item->catatan ?? '-' }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                </div>
                                            @endif

                                            @if ($log->ba_negoisasi)
                                                <p class="mb-1">
                                                    <strong>BA Negosiasi:</strong>
                                                    <a href="{{ asset('storage/' . $log->ba_negoisasi) }}"
                                                        target="_blank" class="text-info">
                                                        <i class="fas fa-file-alt"></i> Lihat BA
                                                    </a>
                                                </p>
                                            @endif

                                            @if ($canApprove)
                                                <button wire:click="konfirmasiSetujuiLog({{ $log->id }})"
                                                    class="mt-2 btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i> Setujui
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach




                            </div>

                            <!-- Form Input Negosiasi -->

                            <div class="mt-4 shadow-sm card border-info">
                                <div class="text-white card-header bg-info">
                                    <h5 class="mb-0"><i class="fas fa-comments-dollar"></i> Form Negosiasi</h5>
                                </div>
                                <div class="card-body">

                                    <form wire:submit.prevent="saveNegosiasi">
                                        <!-- Penawaran Otomatis -->
                                        @if (!$logSudahDisetujui)
                                            <div class="form-group">
                                                <label for="penawaran">Penawaran Total (otomatis dari item)</label>
                                                <input type="number" wire:model="penawaran" class="form-control"
                                                    id="penawaran" readonly style="background-color: #f8f9fa;">
                                                @error('penawaran')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Keterangan -->
                                            <div class="form-group">
                                                <label for="keterangan">Keterangan</label>
                                                <textarea wire:model="keterangan" class="form-control" id="keterangan"
                                                    {{ $lastSenderId == auth()->id() || $negosiasiStatus == 'NEGOSIASI_ST_02' ? 'disabled' : '' }}></textarea>
                                                @error('keterangan')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Tabel Negosiasi per Item -->
                                            <div class="mt-4">
                                                <h5>Negosiasi per Item Rincian:</h5>
                                                <div class="table-responsive">
                                                    <table class="table mb-0 table-bordered table-sm">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th style="width:5%">#</th>
                                                                <th>Uraian</th>
                                                                <th style="width:10%">Qty</th>
                                                                <th style="width:15%">Harga Satuan (Rp)</th>
                                                                <th style="width:15%">Total (Rp)</th>
                                                                <th>Catatan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($logItems as $index => $item)
                                                                @php
                                                                    $qty = $item['quantity'] ?: 1;
                                                                    $hargaSatuan = $item['penawaran'] ?? 0;
                                                                    $total = $hargaSatuan * $qty;
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $item['uraian'] }}</td>

                                                                    {{-- Quantity --}}
                                                                    <td>
                                                                        <input type="number"
                                                                            class="form-control form-control-sm bg-light"
                                                                            value="{{ $qty }}" readonly
                                                                            tabindex="-1">
                                                                    </td>

                                                                    {{-- Harga Satuan --}}
                                                                    <td>
                                                                        <input type="number"
                                                                            class="form-control form-control-sm"
                                                                            wire:model.defer="logItems.{{ $index }}.penawaran"
                                                                            {{ $lastSenderId == auth()->id() || $negosiasiStatus == 'NEGOSIASI_ST_02' ? 'disabled' : '' }}>
                                                                    </td>

                                                                    {{-- Total Penawaran --}}
                                                                    <td>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm bg-light"
                                                                            value="Rp {{ number_format($total, 0, ',', '.') }}"
                                                                            readonly tabindex="-1">
                                                                    </td>

                                                                    {{-- Catatan --}}
                                                                    <td>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            wire:model.defer="logItems.{{ $index }}.catatan"
                                                                            {{ $lastSenderId == auth()->id() || $negosiasiStatus == 'NEGOSIASI_ST_02' ? 'disabled' : '' }}>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>


                                                        <tfoot>
                                                            <tr class="bg-light">
                                                                <th colspan="2" class="text-end">Total Penawaran
                                                                </th>
                                                                <th colspan="2">
                                                                    Rp
                                                                    {{ number_format(array_sum(array_column($logItems, 'penawaran')), 2, ',', '.') }}
                                                                </th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Tombol -->
                                        <div class="gap-2 mt-4 d-flex justify-content-start">
                                            <button type="submit" class="btn btn-primary"
                                                {{ $lastSenderId == auth()->id() || $negosiasiStatus == 'NEGOSIASI_ST_02' ? 'disabled' : '' }}>
                                                <i class="fas fa-save"></i> Simpan Negosiasi Log
                                            </button>

                                            @role(['desa', 'dinsos', 'superadministrator'])
                                                @if ($negosiasiStatus != 'NEGOSIASI_ST_02' && $negosiasiLogs->contains('status_st', true))
                                                    <button type="button" class="btn btn-success"
                                                        wire:click="openModal">
                                                        <i class="fas fa-upload"></i> Upload Berita Acara Negosiasi
                                                    </button>
                                                @endif
                                            @endrole
                                        </div>

                                        @if ($lastSenderId == auth()->id())
                                            <p class="mt-2 text-danger">Menunggu balasan pihak lain sebelum dapat
                                                mengisi negosiasi baru.</p>
                                        @endif
                                    </form>
                                </div>
                            </div>



                        </div>
                    </div>

                    <!-- Modal Upload BA Negosiasi -->
                    @if ($showModal)
                        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog"
                            aria-modal="true" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Upload Berita Acara Negosiasi</h5>
                                        <button type="button" class="close" wire:click="closeModal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        @if (session()->has('message'))
                                            <div class="alert alert-success">{{ session('message') }}</div>
                                        @endif
                                        @if (session()->has('error'))
                                            <div class="alert alert-danger">{{ session('error') }}</div>
                                        @endif

                                        <form wire:submit.prevent="uploadBANegosiasi">
                                            <div class="form-group">
                                                <label for="nilaiDisepakati">Nilai Negosiasi Disepakati</label>
                                                <input type="number" wire:model="nilaiDisepakati"
                                                    class="form-control" id="nilaiDisepakati" required>
                                                @error('nilaiDisepakati')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="mt-3 form-group">
                                                <label for="ba_negoisasi">Pilih Berita Acara Negosiasi
                                                    (PDF/JPG/PNG)</label>
                                                <input type="file" wire:model="ba_negoisasi" class="form-control"
                                                    id="ba_negoisasi" required>
                                                @error('ba_negoisasi')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div wire:loading wire:target="ba_negoisasi" class="mt-1 text-info">
                                                <i class="fas fa-spinner fa-spin"></i> Mengunggah file...
                                            </div>

                                            <div class="gap-3 mt-3 form-group d-flex justify-content-start">
                                                <!-- Unggah BA Button -->
                                                <button type="submit"
                                                    class="mr-1 btn btn-primary d-flex align-items-center">
                                                    <i class="mr-1 fas fa-upload"></i> Upload
                                                </button>

                                                <!-- Batal Button -->
                                                <button type="button"
                                                    class="mr-1 btn btn-secondary d-flex align-items-center"
                                                    wire:click="closeModal">
                                                    <i class="mr-1 fas fa-times"></i> Batal
                                                </button>

                                                <!-- Generate BA Button -->
                                                <a href="{{ route('generator.penyedia.berita-acara-hasil-negosiasi') }}"
                                                    target="_blank"
                                                    class="ml-auto btn btn-outline-success d-flex align-items-center">
                                                    <i class="mr-1 fas fa-file-download"></i> Generate Berita Acara
                                                </a>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-backdrop fade show"></div>
                    @endif

                </div>
            </div>
        </div>
    </section>
    <!-- Custom CSS tambahan -->

</div>
