<div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if (session()->has('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif

                <!-- Petunjuk Pengisian dalam Card -->
                <div class="card mb-3">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-book mr-2"></i> Petunjuk Pengisian
                        </h5>
                    </div>

                    <div class="card-body">
                        <ol>
                            <li>Kolom a diisi dengan nomor urut.</li>
                            <li>Kolom b diisi dengan uraian kegiatan/pekerjaan yang dibutuhkan. Misal:
                                <ul>
                                    <li>Pekerjaan konstruksi: Pondasi, Atap, Dinding, kualifikasi sumber daya manusia
                                        dan lain-lain</li>
                                    <li>Meja kantor, kursi, lemari arsip, dsb</li>
                                </ul>
                            </li>
                            <li>Kolom c diisi dengan keluaran jumlah volume.</li>
                            <li>Kolom d diisi dengan satuan volume. Misal: unit, rim, set, lusin, m², m³</li>
                            <li>Kolom e diisi dengan spesifikasi atau informasi kriteria yang dibutuhkan dari
                                uraian/material/bahan/dimensi. Misal:
                                <ul>
                                    <li>Pekerjaan konstruksi: Batu kali, Kayu 5/7 kelas II, Batu Belah 15/20</li>
                                    <li>Barang: dimensi, jenis bahan</li>
                                </ul>
                            </li>
                        </ol>
                    </div>
                </div>

                <!-- Summernote Editor -->
                <div wire:ignore>
                    <textarea id="summernote">{!! $isiSurat !!}</textarea>
                </div>

                <!-- Tombol Aksi -->
                <div class="mt-3 mb-3">
                    <button class="btn btn-primary" wire:click="simpan">
                        <i class="fas fa-save"></i> Simpan Dokumen
                    </button>

                    @if ($sudahDisimpan)
                        <button class="btn btn-success" onclick="downloadWord()">
                            <i class="fas fa-file-word"></i> Download Word
                        </button>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
