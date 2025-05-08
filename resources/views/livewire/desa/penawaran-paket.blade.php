<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h5 class="card-title">Penawaran Penyedia untuk Paket:
                            {{ $paketKegiatan->paketPekerjaan->nama_kegiatan ?? '-' }}</h5>

                    </div>

                    <div class="card-body">
                        <div class="p-3 mb-4 border rounded bg-light">
                            <h5 class="text-primary">Informasi Kegiatan</h5>

                            <dl class="mb-0 row">
                                <dt class="col-sm-4">Bidang / Subbidang</dt>
                                <dd class="col-sm-8">
                                    {{ $paketKegiatan->paketPekerjaan->nama_bidang ?? '-' }} /
                                    {{ $paketKegiatan->paketPekerjaan->nama_subbidang ?? '-' }}
                                </dd>
                                <dt class="col-sm-4">Nama Kegiatan</dt>
                                <dd class="col-sm-8">{{ $paketKegiatan->paketPekerjaan->nama_kegiatan ?? '-' }}</dd>

                                <dt class="col-sm-4">Tahun Anggaran</dt>
                                <dd class="col-sm-8">{{ $paketKegiatan->paketPekerjaan->tahun ?? '-' }}</dd>




                                <dt class="col-sm-4">Jumlah Anggaran (Pengajuan)</dt>
                                <dd class="col-sm-8">
                                    Rp{{ number_format($paketKegiatan->jumlah_anggaran ?? 0, 2, ',', '.') }}</dd>

                                <dt class="col-sm-4">Pagu Kegiatan</dt>
                                <dd class="col-sm-8">
                                    Rp{{ number_format($paketKegiatan->paketPekerjaan->pagu_pak ?? 0, 2, ',', '.') }}
                                </dd>
                                <dt class="col-sm-4">Jenis Paket</dt>
                                <dd class="col-sm-8">
                                    @php
                                        $badgeColor = match ($paketKegiatan->paket_type) {
                                            'PAKET_TYPE_01' => 'primary',
                                            'PAKET_TYPE_02' => 'success',
                                            'PAKET_TYPE_03' => 'warning',
                                            default => 'secondary',
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $badgeColor }} text-white">
                                        {{ $paketKegiatan->paketType->code_nm ?? 'Tidak Diketahui' }}
                                    </span>
                                </dd>



                            </dl>
                        </div>


                        @if (!$negosiasiExists)
                            <div class="mb-3">
                                <button class="btn btn-info" wire:click="$set('showModalVendor', true)">
                                    <i class="mr-1 fas fa-plus-square"></i> Tambah Vendor
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr class="bg-light">
                                        <th>Nama Vendor</th>
                                        <th>Batas Akhir</th>
                                        <th>Surat Undangan</th>
                                        <th>Keterangan</th>
                                        <th>Status Kirim</th> <!-- tambahan -->
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($penawarans as $item)
                                        <tr>
                                            <td>{{ $item['vendor']['nama_perusahaan'] ?? '-' }}</td>
                                            <td>{{ $item['batas_akhir'] }}</td>
                                            <td>
                                                @if ($item['surat_undangan'])
                                                    <a href="{{ route('helper.show-picture', ['path' => $item['surat_undangan']]) }}"
                                                        target="_blank" class="btn btn-sm btn-secondary">
                                                        Preview
                                                    </a>
                                                @else
                                                    <span class="text-muted">Belum ada</span>
                                                @endif
                                            </td>
                                            <td>{{ $item['keterangan'] }}</td>
                                            <td>
                                                @if ($item['kirim_st'] ?? false)
                                                    <span class="badge bg-success">Terkirim</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Belum Terkirim</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (!$negosiasiExists)
                                                    <button class="btn btn-warning btn-sm"
                                                        wire:click="editPenawaran({{ $item['vendor_id'] }})">
                                                        Edit
                                                    </button>
                                                    <button class="btn btn-danger btn-sm"
                                                        wire:click="delete({{ $item['vendor_id'] }})">
                                                        Hapus
                                                    </button>
                                                @else
                                                    <span class="text-white badge bg-danger">
                                                        <i class="mr-1 fas fa-lock"></i> Terkunci
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Belum ada data penawaran
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>
                            @if (!$negosiasiExists)
                                <div class="mt-3 d-flex justify-content-end">
                                    <button class="btn btn-primary" wire:click="konfirmasiKirimUndangan">
                                        <i class="fas fa-paper-plane"></i> Kirim Undangan
                                    </button>
                                </div>
                            @endif
                        </div>

                        @if (session()->has('message'))
                            <div class="mt-3 alert alert-success">{{ session('message') }}</div>
                        @endif
                    </div>
                </div>


                @if ($vendorId)
                    <div class="mt-3 card">
                        <div class="card-header bg-light">
                            <h4 class="mb-0 text-primary fw-bold">
                                @if ($editMode)
                                    Edit
                                @else
                                    Tambah
                                @endif Penawaran Vendor
                            </h4>
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="simpanPenawaranVendor">
                                <div class="form-group">
                                    <label>Batas Akhir Penawaran</label>
                                    <input type="date" class="form-control" wire:model="batasAkhir">
                                    @error('batasAkhir')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Surat Permintaan Penawaran</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" wire:model="suratUndangan">
                                        <div class="input-group-append">
                                            <a href="{{ route('generator.penyedia.surat-penawaran', ['paketKegiatan' => $paketKegiatan->id, 'vendorId' => $vendorId]) }}"
                                                target="_blank" class="ml-1 btn btn-outline-success">
                                                <i class="fas fa-magic"></i> Generate
                                            </a>
                                        </div>
                                    </div>

                                    <div wire:loading wire:target="suratUndangan" class="mt-2 text-info">
                                        <i class="fas fa-spinner fa-spin"></i> Mengunggah Surat Undangan...
                                    </div>

                                    @error('suratUndangan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea class="form-control" wire:model="keterangan"></textarea>
                                </div>

                                <button type="submit" class="btn btn-success">
                                    <i class="mr-1 fas fa-save"></i> Simpan Penawaran
                                </button>
                                <button type="button" class="btn btn-secondary" wire:click="resetForm">
                                    Batal
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h5 class="card-title">Penawaran Penyedia</h5>
                    </div>

                    <div class="card-body">
                        <livewire:components.penawaran-list :paketKegiatanId="$paketKegiatan->id" />
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Modal pilih vendor --}}
    @if ($showModalVendor)
        <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg" role="document">
                <div class="border-0 shadow modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="text-white modal-title">Pilih Vendor</h5>
                        <button type="button" class="text-white btn-close" wire:click="$set('showModalVendor', false)">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" wire:model.debounce.500ms="searchVendor"
                                    placeholder="Cari nama perusahaan atau NIB...">
                            </div>
                        </div>

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>NIB</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($vendors as $vendor)
                                    <tr>
                                        <td>{{ $vendor->nama_perusahaan }}</td>
                                        <td>{{ $vendor->nib }}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm"
                                                wire:click="tambahVendor({{ $vendor->id }})">
                                                Pilih
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            wire:click="$set('showModalVendor', false)">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>
