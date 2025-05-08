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
                                <input type="number" class="form-control" wire:model.live="jumlah_anggaran"
                                    placeholder="Contoh: 15000000">
                                @error('jumlah_anggaran')
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
                                        <div wire:loading wire:target="{{ $field }}" class="mb-2 text-info">
                                            <i class="fas fa-spinner fa-spin"></i> Mengunggah
                                            {{ $label }}...
                                        </div>
                                        <div class="input-group-append">
                                            @if (isset($generateRoutes[$field]) && $prefix)
                                                <a href="{{ route($prefix . $generateRoutes[$field], ['id' => $paketPekerjaan->id]) }}"
                                                    target="_blank" class="ml-1 btn btn-outline-success">
                                                    <i class="fas fa-magic"></i> Generate
                                                </a>
                                            @endif
                                        </div>
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
