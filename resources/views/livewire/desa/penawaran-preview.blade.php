<div>
    <x-slot name="header">
        <div class="mb-1 row">
            <div class="col-sm-6">
                <h3 class="m-0">Preview Penawaran</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Master</a></li>
                    <li class="breadcrumb-item active">Preview Penawaran</li>
                </ol>
            </div>
        </div>
    </x-slot>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-body">
                        <div class="tab-pane fade active show">
                            <div class="tab-pane active show fade" id="custom-tabs-one-rm" role="tabpanel"
                                aria-labelledby="custom-tabs-one-rm-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <a href="{{ route('desa.penawaran.paket', $penawaran->paket_kegiatan_id) }}"
                                                class="btn btn-info">
                                                <i class="mr-2 fas fa-arrow-left"></i>Kembali ke Daftar Penawaran
                                            </a>
                                        </div>
                                        <div class="card card-info card-outline card-tabs">
                                            <div class="tab-content" id="custom-tabs-six-tabContent">
                                                <div class="tab-pane fade show active" id="custom-tabs-six-riwayat-rm"
                                                    role="tabpanel" aria-labelledby="custom-tabs-six-riwayat-rm-tab">
                                                    <div class="card-body">
                                                        <!-- Penawaran Details -->
                                                        <div class="mb-4 row">
                                                            <div class="col-md-6">
                                                                <strong>Nama Vendor:</strong>
                                                                <p>{{ $penawaran->vendor->nama_perusahaan }}</p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Harga Penawaran:</strong>
                                                                <p>Rp {{ number_format($penawaran->nilai) }}
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="mb-4 row">
                                                            <div class="col-md-6">
                                                                <strong>Status Penawaran:</strong>
                                                                <p>{{ $penawaran->statusPenawaran->code_nm }}</p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Evaluasi Administrasi:</strong>
                                                                <p>{{ $penawaran->evaluasi->surat_kebenaran_hasil ?? '-' }}
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="mb-4 row">
                                                            <div class="col-md-6">
                                                                <strong>Evaluasi Teknis:</strong>
                                                                <p>{{ $penawaran->evaluasi->spesifikasi_hasil ?? '-' }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Evaluasi Harga:</strong>
                                                                <p>{{ $penawaran->evaluasi->harga_hasil ?? '-' }}</p>
                                                            </div>
                                                        </div>

                                                        <!-- Evaluasi Form -->
                                                        @if ($penawaran->penawaran_st === 'PENAWARAN_ST_01')
                                                            <div class="card card-outline card-primary">
                                                                <div class="card-header">
                                                                    <h5 class="card-title">Formulir Evaluasi Penawaran
                                                                    </h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    @livewire('components.evaluasi-penawaran-form', ['penawaranId' => $penawaran->id], key($penawaran->id))
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
</div>
