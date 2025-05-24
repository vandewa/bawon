<div>
    <x-slot name="header">
        <h3 class="m-0 text-dark">
            <i class="mr-2 fas fa-file-alt text-info"></i> Dokumen Persiapan - {{ $paketPekerjaan->nama_kegiatan }}
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

            <livewire:components.paket.informasi-paket :paket-pekerjaan-id="$paketPekerjaan->id" />

            <form wire:submit.prevent="save" class="mt-4">
                <div class="border-0 shadow-sm card">
                    <div class="text-white card-header bg-info">
                        <h5 class="mb-0"><i class="mr-2 fas fa-upload"></i> Upload Dokumen Persiapan</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
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
                                <div class="form-group">
                                    <label><strong>TPK (Tahun {{ $paketPekerjaan->tahun }})</strong></label>
                                    <select class="form-control" wire:model="tim_id">
                                        <option value="">-- Pilih TPK --</option>
                                        @foreach ($tpks as $tpk)
                                            <option value="{{ $tpk->id }}"> {{ $tpk->nama ?? '-' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tim_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Jumlah Anggaran</strong></label>
                                    <p class="form-control">
                                        {{ number_format($jumlah_anggaran, 0, ',', '.') }}
                                    </p>
                                    <p class="text-muted small fst-italic">
                                        {{ ucwords(terbilang($jumlah_anggaran)) }}
                                    </p>
                                    @error('jumlah_anggaran')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>

                        </div>

                        <div class="mt-4 card">
                            <div class="card-header bg-light">
                                <strong>Rincian Anggaran (Centang yang ingin digunakan)</strong>
                            </div>
                            <div class="p-0 card-body">
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
                                        @php
                                            $grouped = collect($rincianList)->groupBy('nama_obyek');
                                        @endphp

                                        @forelse ($grouped as $obyek => $groupItems)
                                            <tr class="table-secondary">
                                                <td colspan="11"><strong>{{ $obyek }}</strong></td>
                                            </tr>

                                            @foreach ($groupItems as $rinci)
                                                @php
                                                    $usedQty = $rinci['quantity'] ?? 0;
                                                    $sisaQty = $rinci['jml_satuan_pak'] - $usedQty;
                                                    $isDisabled = $sisaQty <= 0;
                                                    $qty = (float) ($quantities[$rinci['id']] ?? 0);
                                                    $hargaInput = (float) ($hargas[$rinci['id']] ?? 0);
                                                    $totalBelanja = $qty * $hargaInput;
                                                @endphp
                                                <tr>
                                                    <td class="text-center align-middle">
                                                        <input type="checkbox" wire:model.live="selectedRincian"
                                                            value="{{ $rinci['id'] }}"
                                                            {{ $isDisabled ? 'disabled' : '' }}>
                                                    </td>
                                                    <td>{{ $rinci['kd_rincian'] }}</td>
                                                    <td>{{ $rinci['uraian'] }}</td>
                                                    <td>{{ $rinci['jml_satuan_pak'] }}</td>
                                                    <td>{{ $usedQty }}</td>
                                                    <td>
                                                        <input type="number" min="1" max="{{ $sisaQty }}"
                                                            wire:model.live="quantities.{{ $rinci['id'] }}"
                                                            class="form-control form-control-sm" style="width: 80px;"
                                                            {{ in_array($rinci['id'], $selectedRincian) ? '' : 'disabled' }}>
                                                    </td>
                                                    <td>{{ $rinci['satuan'] }}</td>
                                                    <td>{{ number_format($rinci['hrg_satuan_pak'], 0, ',', '.') }}</td>
                                                    <td>{{ number_format($rinci['anggaran_stlh_pak'], 0, ',', '.') }}
                                                    </td>
                                                    {{-- Kolom input harga (user input) --}}
                                                    <td>
                                                        <input type="number" min="0" step="0.01" required
                                                            wire:model.live="hargas.{{ $rinci['id'] }}"
                                                            class="form-control form-control-sm" style="width: 100px;"
                                                            {{ in_array($rinci['id'], $selectedRincian) ? '' : 'disabled' }}>
                                                    </td>
                                                    {{-- Kolom Total Belanja --}}
                                                    @php
                                                        $qty = (float) ($quantities[$rinci['id']] ?? 0);
                                                        $hargaInput = (float) ($hargas[$rinci['id']] ?? 0);
                                                        $totalBelanja = $qty * $hargaInput;
                                                    @endphp
                                                    <td>
                                                        <strong>{{ number_format($totalBelanja, 0, ',', '.') }}</strong>
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
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="save">
                                <i class="mr-1 fas fa-save"></i> Simpan Dokumen
                            </span>
                            <span wire:loading wire:target="save">
                                <i class="mr-1 fas fa-spinner fa-spin"></i> Menyimpan...
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
