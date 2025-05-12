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
                                <input type="number" class="form-control" wire:model="jumlah_anggaran" readonly
                                    style="background-color: #f8f9fa;">
                                <small class="form-text text-muted">Otomatis dihitung dari rincian yang dipilih.</small>
                                @error('jumlah_anggaran')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
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
                                            <th>No</th>
                                            <th>Uraian</th>
                                            <th>Jumlah</th>
                                            <th>Satuan</th>
                                            <th>Harga</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($rincianList as $i => $rinci)
                                            <tr class="{{ $rinci['use_st'] ? 'table-secondary text-muted' : '' }}">
                                                <td class="text-center align-middle">
                                                    <input type="checkbox" wire:model.live="selectedRincian"
                                                        value="{{ $rinci['id'] }}"
                                                        {{ $rinci['use_st'] ? 'disabled' : '' }}>
                                                </td>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $rinci['uraian'] }}</td>
                                                <td>{{ number_format($rinci['jml_satuan_pak'], 0, ',', '.') }}</td>
                                                <td>{{ $rinci['satuan'] }}</td>
                                                <td>{{ number_format($rinci['hrg_satuan_pak'], 0, ',', '.') }}</td>
                                                <td><strong>{{ number_format($rinci['anggaran_stlh_pak'], 0, ',', '.') }}</strong>
                                                </td>
                                                <td>
                                                    @if ($rinci['use_st'])
                                                        <span class="badge badge-secondary">Sudah dibelanjakan</span>
                                                    @else
                                                        <span class="badge badge-success">Tersedia</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-muted">Tidak ada rincian
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
