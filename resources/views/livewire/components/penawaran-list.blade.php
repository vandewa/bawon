<div>
    <div class="row">
        @foreach ($penawarans as $penawaran)
            <div class="col-md-4">
                <div
                    class="card card-outline {{ $penawaran->penawaran_st == 'PENAWARAN_ST_02' ? 'card-success' : 'card-info' }}">
                    <div class="text-center card-header">
                        <h3 class="mb-0 card-title">Penawaran #{{ $loop->iteration }}</h3>
                    </div>
                    <div class="card-body">
                        <h5 class="text-center">{{ $penawaran->vendor->nama_perusahaan }}</h5>
                        <p class="text-center text-muted">{{ $penawaran->vendor->nib }}</p>
                        <ul class="list-unstyled">
                            <li>
                                <strong>Status Penawaran:</strong>
                                <span
                                    class="badge
                                    @if ($penawaran->penawaran_st == 'PENAWARAN_ST_01') bg-warning
                                    @elseif ($penawaran->penawaran_st == 'PENAWARAN_ST_02') bg-success
                                    @else bg-danger @endif">
                                    {{ $penawaran->statusPenawaran->code_nm ?? $penawaran->penawaran_st }}
                                </span>
                            </li>
                            <li><strong>Evaluasi Administrasi:</strong>
                                {{ $penawaran->evaluasi->surat_kebenaran_hasil ?? 'Belum Dievaluasi' }}
                            </li>
                            <li><strong>Evaluasi Teknis:</strong>
                                {{ $penawaran->evaluasi->spesifikasi_hasil ?? 'Belum Dievaluasi' }}
                            </li>
                            <li><strong>Evaluasi Harga:</strong>
                                {{ $penawaran->evaluasi->harga_hasil ?? 'Belum Dievaluasi' }}
                            </li>
                            <li><strong>Keterangan:</strong>
                                <p>{{ $penawaran->keterangan }}</p>
                            </li>
                        </ul>
                    </div>
                    <div class="text-center card-footer">
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

                        <a href="{{ route('penyedia.vendor-profile', $penawaran->vendor->id) }}"
                            class=" btn btn-sm btn-outline-info" target="_blank">
                            <i class="fas fa-building"></i> Detail Vendor
                        </a>
                    </div>

                </div>
            </div>
        @endforeach
    </div>

    @if ($isModalOpen)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Berita Acara Evaluasi</h5>
                        <button type="button" class="close" wire:click="closeModal">
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

                        <form wire:submit.prevent="simpanEvaluasi">
                            @php
                                $modalPenawaran = \App\Models\Penawaran::with('paketKegiatan')->find($penawaranId);
                            @endphp


                            <div class="form-group">
                                <label for="baEvaluasi">Upload File BA Evaluasi</label>
                                <input type="file" wire:model="baEvaluasi" class="form-control">
                                <div wire:loading wire:target="baEvaluasi" class="mt-2 text-info">
                                    <i class="fas fa-spinner fa-spin"></i> Mengunggah...
                                </div>
                                @error('baEvaluasi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                            <div class="mt-3 form-group">
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
