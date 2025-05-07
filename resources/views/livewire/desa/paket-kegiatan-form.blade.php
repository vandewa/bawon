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
                                'rencana_kerja' => 'Rencana Kerja',
                                'hps' => 'Harga Perkiraan Sendiri (HPS)',
                            ];

                            $generateRoutes = [
                                'spek_teknis' => 'spesifikasi-teknis',
                                'kak' => 'kak',
                                'jadwal_pelaksanaan' => 'jadwal-pelaksanaan',
                                'rencana_kerja' => 'rencana-kerja',
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

                                    <div wire:loading wire:target="{{ $field }}" class="mb-2 text-info">
                                        <i class="fas fa-spinner fa-spin"></i> Mengunggah {{ $label }}...
                                    </div>

                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="form-control" id="{{ $field }}"
                                                wire:model="{{ $field }}">

                                        </div>

                                        @if (!empty($paket_type) && isset($generateRoutes[$field]) && !empty($prefix))
                                            <div class="input-group-append">
                                                <a href="{{ route($prefix . $generateRoutes[$field], ['id' => $paketPekerjaan->id]) }}"
                                                    target="_blank" class="ml-1 btn btn-outline-success">
                                                    <i class="fas fa-magic"></i> Generate
                                                </a>
                                            </div>
                                        @endif
                                    </div>

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
