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
                        <h5 class="mb-0">Petunjuk Pengisian</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Uraian</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Kolom a diisi dengan nomor urut.</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>
                                        Kolom b diisi dengan uraian kegiatan/pekerjaan yang dibutuhkan. Misal:<br>
                                        <ul>
                                            <li>Pekerjaan konstruksi: Pondasi, Atap, Dinding, kualifikasi sumber daya
                                                manusia dan lain-lain</li>
                                            <li>Narasumber: Pelatih menjahit</li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>
                                        Kolom c diisi dengan spesifikasi atau informasi kriteria yang dibutuhkan dari
                                        uraian/material/sumber daya manusia. Misal:<br>
                                        <ul>
                                            <li>Pekerjaan konstruksi: Batu kali, Kayu 5/7 kelas II, Batu Belah 15/20
                                            </li>
                                            <li>Narasumber: memiliki sertifikat menjahit, pengalaman 2 tahun, dsb</li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
