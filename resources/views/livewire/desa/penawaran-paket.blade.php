<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h5 class="card-title">Penawaran Vendor untuk Paket: {{ $paketKegiatan->paket_kegiatan }}</h5>
                    </div>

                    <div class="card-body">
                        <p><strong>Anggaran:</strong> Rp{{ number_format($paketKegiatan->jumlah_anggaran) }}</p>

                        <div class="mb-3">
                            <button class="btn btn-info" wire:click="$set('showModalVendor', true)">
                                <i class="fas fa-plus-square mr-1"></i> Tambah Vendor
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr class="bg-light">
                                        <th>Nama Vendor</th>
                                        <th>Batas Akhir</th>
                                        <th>Surat Undangan</th>
                                        <th>Keterangan</th>
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
                                                    <a href="{{ Storage::url($item['surat_undangan']) }}"
                                                        target="_blank" class="btn btn-sm btn-secondary">
                                                        Preview
                                                    </a>
                                                @else
                                                    <span class="text-muted">Belum ada</span>
                                                @endif
                                            </td>
                                            <td>{{ $item['keterangan'] }}</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm"
                                                    wire:click="editPenawaran({{ $item['vendor_id'] }})">
                                                    Edit
                                                </button>
                                                <button class="btn btn-danger btn-sm"
                                                    wire:click="delete({{ $item['vendor_id'] }})">
                                                    Hapus
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Belum ada data penawaran
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if (session()->has('message'))
                            <div class="mt-3 alert alert-success">{{ session('message') }}</div>
                        @endif
                    </div>
                </div>

                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h5 class="card-title">Penawaran Penyedia</h5>
                    </div>

                    <div class="card-body">
                        <livewire:components.penawaran-list :paket-kegiatan-id="$paketKegiatan->id" />
                    </div>
                </div>

                @if ($vendorId)
                    <div class="card mt-3">
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
                                    <label>Upload Surat Undangan</label>
                                    <input type="file" class="form-control" wire:model="suratUndangan">
                                    @error('suratUndangan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea class="form-control" wire:model="keterangan"></textarea>
                                </div>

                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save mr-1"></i> Simpan Penawaran
                                </button>
                                <button type="button" class="btn btn-secondary" wire:click="resetForm">
                                    Batal
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal pilih vendor --}}
    @if ($showModalVendor)
        <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title text-white">Pilih Vendor</h5>
                        <button type="button" class="btn-close text-white" wire:click="$set('showModalVendor', false)">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row mb-3">
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
