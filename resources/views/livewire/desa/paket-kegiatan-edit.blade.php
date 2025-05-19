<div>
    <x-slot name="header">
        <h3 class="m-0 text-dark">
            <i class="mr-2 fas fa-edit text-warning"></i> Edit Dokumen Persiapan - {{ $paketPekerjaan->nama_kegiatan }}
        </h3>
    </x-slot>

    <section class="content">
        <div class="container-fluid">

            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="mr-1 fas fa-check-circle"></i> {{ session('message') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            {{-- Informasi Paket --}}
            <livewire:components.paket.informasi-paket :paket-pekerjaan-id="$paketPekerjaan->id" />

            <form wire:submit.prevent="update" class="mt-4">
                <div class="border-0 shadow-sm card">
                    <div class="text-white card-header bg-warning">
                        <h5 class="mb-0"><i class="mr-2 fas fa-file-upload"></i> Edit Dokumen Persiapan</h5>
                    </div>
                    <div class="card-body">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label><strong>Jenis Paket</strong></label>
                                <select class="form-control" wire:model.live="paket_type">
                                    <option value="">-- Pilih Jenis Paket --</option>
                                    @foreach ($paketTypes as $code => $label)
                                        <option value="{{ $code }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('paket_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label><strong>Jumlah Anggaran</strong></label>
                                <input type="number" class="form-control bg-light" wire:model.live="jumlah_anggaran"
                                    readonly>
                                <small class="form-text text-muted">Otomatis dijumlah dari rincian yang dipilih.</small>
                                @error('jumlah_anggaran')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label><strong>TPK (Tahun {{ $paketPekerjaan->tahun }})</strong></label>
                                <select class="form-control" wire:model="tpk_id">
                                    <option value="">-- Pilih TPK --</option>
                                    @foreach ($tpks as $tpk)
                                        <option value="{{ $tpk->id }}"> {{ $tpk->aparatur->nama ?? '-' }} -
                                            {{ $tpk->jenis->code_nm }}</option>
                                    @endforeach
                                </select>
                                @error('tpk_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        @php
                            $labelDokumen = [
                                'spek_teknis' => 'Spesifikasi Teknis',
                                'kak' => 'Kerangka Acuan Kerja (KAK)',
                                'jadwal_pelaksanaan' => 'Jadwal Pelaksanaan',
                                'rencana_kerja' => 'Rencana Kerja (Bila diperlukan)',
                                'hps' => 'Harga Perkiraan Sendiri (HPS)',
                            ];

                            $generateRoutes = [
                                'spek_teknis' => 'spesifikasi-teknis',
                                'kak' => 'kak',
                                'jadwal_pelaksanaan' => 'jadwal-pelaksanaan',
                                'hps' => 'hps',
                            ];

                            $prefix = match ($paket_type) {
                                'PAKET_TYPE_01' => 'generator.penyedia.',
                                'PAKET_TYPE_02' => 'generator.swakelola.',
                                'PAKET_TYPE_03' => 'generator.lelang.',
                                default => '',
                            };
                        @endphp

                        <div class="row">
                            @foreach ($labelDokumen as $field => $label)
                                <div class="mb-4 col-md-6">
                                    <label><strong>{{ $label }}</strong></label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="form-control" id="{{ $field }}"
                                                wire:model="{{ $field }}">
                                        </div>

                                        <div class="input-group-append">
                                            @if (isset($generateRoutes[$field]) && $prefix)
                                                <a href="{{ route($prefix . $generateRoutes[$field], ['id' => $paketKegiatan->id]) }}"
                                                    target="_blank" class="ml-1 btn btn-outline-success">
                                                    <i class="fas fa-magic"></i> Generate
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div wire:loading wire:target="{{ $field }}" class="mb-2 text-info">
                                        <i class="fas fa-spinner fa-spin"></i> Mengunggah
                                        {{ $label }}...
                                    </div>

                                    {{-- Preview dokumen lama --}}
                                    @if ($paketKegiatan->{$field})
                                        <div class="mt-2">
                                            <a href="{{ route('helper.show-picture', ['path' => $paketKegiatan->{$field}]) }}"
                                                target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="mr-1 fas fa-eye"></i> Lihat Dokumen Lama
                                            </a>
                                        </div>
                                    @endif

                                    @error($field)
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        {{-- Tabel Rincian --}}
                        <div class="mt-4 card">
                            <div class="card-header bg-light">
                                <strong>Rincian Anggaran Terkait</strong>
                            </div>
                            <div class="p-0 card-body">
                                @php
                                    $grouped = $paketPekerjaan->rincian->groupBy('nama_obyek');
                                @endphp

                                <table class="table mb-0 table-sm table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width: 40px;"></th>
                                            <th>KD Rincian</th>
                                            <th>Uraian</th>
                                            <th>Jumlah Awal</th>
                                            <th>Jumlah Dibelanjakan</th>
                                            <th>Jumlah</th>
                                            <th>Satuan</th>
                                            <th>Harga</th>
                                            <th>Total Anggaran</th>
                                            <th>Harga Input</th>
                                            <th>Total Belanja</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($grouped as $obyek => $rincianGroup)
                                            <tr class="table-secondary">
                                                <td colspan="11"><strong>{{ $obyek }}</strong></td>
                                            </tr>
                                            @foreach ($rincianGroup as $rinci)
                                                @php
                                                    $terkait = $rinci
                                                        ->kegiatanRinci()
                                                        ->where('paket_kegiatan_id', $paketKegiatan->id)
                                                        ->exists();
                                                    $dipakaiDiKegiatanLain = $rinci
                                                        ->kegiatanRinci()
                                                        ->where('paket_kegiatan_id', '!=', $paketKegiatan->id)
                                                        ->exists();
                                                    $jumlahDibelanjakan = \App\Models\PaketKegiatanRinci::where(
                                                        'paket_pekerjaan_rinci_id',
                                                        $rinci->id,
                                                    )
                                                        ->where('paket_kegiatan_id', '!=', $paketKegiatan->id)
                                                        ->sum('quantity');
                                                    $sisaTersedia = $rinci->jml_satuan_pak - $jumlahDibelanjakan;
                                                    $qty = (float) ($quantities[$rinci->id] ?? 0);
                                                    $hargaInput =
                                                        (float) ($hargas[$rinci->id] ?? $rinci->hrg_satuan_pak);
                                                    $totalBelanja = $qty * $hargaInput;
                                                @endphp

                                                @continue($dipakaiDiKegiatanLain && !$terkait)

                                                <tr>
                                                    <td class="text-center align-middle">
                                                        <input type="checkbox" wire:model.live="selectedRincian"
                                                            value="{{ $rinci->id }}">
                                                    </td>
                                                    <td>{{ $rinci->kd_rincian }}</td>
                                                    <td>{{ $rinci->uraian }}</td>
                                                    <td>{{ number_format($rinci->jml_satuan_pak, 0, ',', '.') }}</td>
                                                    <td>{{ number_format($jumlahDibelanjakan, 0, ',', '.') }}</td>
                                                    <td>
                                                        <input type="number" class="form-control form-control-sm"
                                                            wire:model.live="quantities.{{ $rinci->id }}"
                                                            min="1" max="{{ $sisaTersedia }}"
                                                            {{ in_array($rinci->id, $selectedRincian) ? '' : 'disabled' }}>
                                                    </td>
                                                    <td>{{ $rinci->satuan }}</td>
                                                    <td>{{ number_format($rinci->hrg_satuan_pak, 0, ',', '.') }}</td>
                                                    <td>{{ number_format($rinci->anggaran_stlh_pak, 0, ',', '.') }}
                                                    </td>
                                                    <td>
                                                        @if (in_array($rinci->id, $selectedRincian))
                                                            <input type="number" min="0" step="0.01"
                                                                wire:model.live="hargas.{{ $rinci->id }}"
                                                                class="form-control form-control-sm"
                                                                style="width: 100px;">
                                                            @error('hargas.' . $rinci->id)
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        @else
                                                            <span
                                                                class="text-muted">{{ number_format($hargaInput, 0, ',', '.') }}</span>
                                                        @endif
                                                    </td>
                                                    <td><strong>{{ number_format($totalBelanja, 0, ',', '.') }}</strong>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @empty
                                            <tr>
                                                <td colspan="11" class="text-center text-muted">Tidak ada rincian
                                                    tersedia.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>





                            </div>
                        </div>


                    </div>

                    <div class="card-footer bg-light d-flex justify-content-end">
                        <a href="{{ route('desa.paket-kegiatan', $paketPekerjaan) }}" class="mr-2 btn btn-secondary">
                            <i class="mr-1 fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="text-white btn btn-warning" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="update">
                                <i class="mr-1 fas fa-save"></i> Perbarui Dokumen
                            </span>
                            <span wire:loading wire:target="update">
                                <i class="mr-1 fas fa-spinner fa-spin"></i> Memproses...
                            </span>
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </section>
</div>
