<div>
    <div class="row">
        @foreach ($penawarans as $penawaran)
            <div class="col-md-4">
                <div
                    class="card card-outline {{ $penawaran->penawaran_st == 'PENAWARAN_ST_02' ? 'card-success' : 'card-info' }}">
                    <div class="card-header text-center">
                        <h3 class="card-title mb-0">Penawaran #{{ $loop->iteration }}</h3>
                    </div>
                    <div class="card-body">
                        <h5 class="text-center">{{ $penawaran->vendor->nama_perusahaan }}</h5>
                        <p class="text-muted text-center">{{ $penawaran->vendor->nib }}</p>
                        <ul class="list-unstyled">
                            <li><strong>Status Penawaran:</strong> {{ $penawaran->penawaran_st }}</li>
                            <li><strong>Evaluasi Administrasi:</strong>
                                {{ $penawaran->evaluasi->surat_kebenaran_hasil ?? 'Belum Dievaluasi' }}
                            </li>
                            <li><strong>Evaluasi Teknis:</strong>
                                {{ $penawaran->evaluasi->spesifikasi_hasil ?? 'Belum Dievaluasi' }}
                            </li>
                            <li><strong>Evaluasi Harga:</strong>
                                {{ $penawaran->evaluasi->harga_hasil ?? 'Belum Dievaluasi' }}
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        @if ($penawaran->penawaran_st == 'PENAWARAN_ST_01')
                            <button wire:click="openModal({{ $penawaran->id }})" class="btn btn-success btn-sm">
                                <i class="fas fa-check"></i> Setujui
                            </button>
                        @elseif ($penawaran->penawaran_st == 'PENAWARAN_ST_02')
                            <button class="btn btn-danger btn-sm" disabled>
                                <i class="fas fa-times"></i> Sudah Disetujui
                            </button>
                        @endif

                        <a href="{{ route('desa.penawaran.pelaksanaan.preview', $penawaran->id) }}"
                            class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal for uploading BA Evaluasi -->
    @if ($isModalOpen)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Berita Acara Evaluasi</h5>
                        <button type="button" class="close" wire:click="closeModal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif

                        <!-- Menampilkan pesan flash error -->
                        @if (session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form wire:submit="simpanEvaluasi">
                            <div class="form-group">
                                <label for="baEvaluasi">Pilih File PDF</label>
                                <input type="file" wire:model="baEvaluasi" class="form-control">
                                @error('baEvaluasi')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" wire:click="closeModal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>
