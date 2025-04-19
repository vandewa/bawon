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

            {{-- Informasi Paket --}}
            <livewire:components.paket.informasi-paket :paket-pekerjaan-id="$paketPekerjaan->id" />

            <form wire:submit.prevent="save" class="mt-4">
                <div class="border-0 shadow-sm card">
                    <div class="text-white card-header bg-info">
                        <h5 class="mb-0">
                            <i class="mr-2 fas fa-upload"></i> Upload Dokumen Persiapan
                        </h5>
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
                                'spek_teknis' => 'Spek Teknis',
                                'kak' => 'KAK',
                                'jadwal_pelaksanaan' => 'Jadwal Pelaksanaan',
                                'rencana_kerja' => 'Rencana Kerja',
                                'hps' => 'HPS',
                            ];
                        @endphp

                        <div class="row">
                            @foreach ($labelDokumen as $field => $label)
                                <div class="mb-4 col-md-6">
                                    <label><strong>{{ $label }}</strong></label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="{{ $field }}"
                                                wire:model="{{ $field }}">
                                            <label class="custom-file-label" for="{{ $field }}">Pilih
                                                file...</label>
                                        </div>

                                        @php
                                            $existingFile = $paketKegiatan?->{$field} ?? null;
                                        @endphp

                                        <div class="input-group-append">
                                            @if ($existingFile)
                                                <a href="{{ Storage::url($existingFile) }}" target="_blank"
                                                    class="btn btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif
                                            <a href="https://google.com" target="_blank"
                                                class="ml-1 btn btn-outline-success">
                                                <i class="fas fa-magic"></i> Generate
                                            </a>
                                        </div>
                                    </div>
                                    @error($field)
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="card-footer bg-light d-flex justify-content-end">
                        <a href="" class="mr-2 btn btn-secondary">
                            <i class="mr-1 fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="mr-1 fas fa-save"></i> Simpan Dokumen
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
