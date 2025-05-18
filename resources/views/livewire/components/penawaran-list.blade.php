<div>
    <div class="row">
        @foreach ($penawarans as $penawaran)
            <div class="col-md-4">
                <div
                    class="card card-outline {{ $penawaran->penawaran_st == 'PENAWARAN_ST_02' ? 'card-success' : 'card-info' }}">
                    <div class="text-center card-header">
                        <h3 class="mb-0 card-title">Penawaran #{{ $penawaran->iteration }}</h3>
                    </div>
                    <div class="card-body">
                        <h5 class="text-center">{{ $penawaran->vendor->nama_perusahaan }}</h5>

                        <h5 class="text-center text-muted">
                            Rp {{ number_format($penawaran->nilai, 0, ',', '.') }}
                        </h5>
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

                                @if ($penawaran->dok_penawaran)
                                    <a href="{{ route('helper.show-picture', ['path' => $penawaran->dok_penawaran]) }}"
                                        target="_blank">
                                        📄 Lihat Dokumen
                                    </a>
                                @else
                                    <span class="mt-2 badge badge-secondary">Tidak ada dokumen</span>
                                @endif
                            </li>
                        </ul>
                    </div>
                    <div class="text-center card-footer">
                        @if ($penawaran->penawaran_st == 'PENAWARAN_ST_01')
                            @if ($allDokPenawaranUploaded)
                                <button wire:click="openModal({{ $penawaran->id }})" class="btn btn-success btn-sm">
                                    <i class="fas fa-check"></i> Setujui
                                </button>
                            @else
                                <button class="btn btn-secondary btn-sm" disabled>
                                    <i class="fas fa-info-circle"></i> Tunggu Semua Upload Penawaran
                                </button>
                            @endif
                        @elseif ($penawaran->penawaran_st == 'PENAWARAN_ST_02')
                            <button class="btn btn-danger btn-sm" disabled>
                                <i class="fas fa-times"></i> Sudah Disetujui
                            </button>
                        @endif


                        <a href="{{ route('desa.penawaran.pelaksanaan.preview', $penawaran->id) }}"
                            class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i> Evaluasi Penawaran
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


                            <div class="mt-3 form-group d-flex justify-content-between">
                                <div>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="button" class="btn btn-secondary"
                                        wire:click="closeModal">Batal</button>
                                </div>

                                <!-- Tombol Generate -->
                                <a href="#" target="_blank"
                                    class="btn btn-outline-success d-flex align-items-center">
                                    <i class="mr-1 fas fa-file-download"></i> Generate BA Evaluasi
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>
