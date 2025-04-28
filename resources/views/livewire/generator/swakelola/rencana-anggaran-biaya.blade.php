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
                            <li>
                                Tahapan kegiatan dalam suatu pekerjaan diisi dengan urutan pada baris No 1, 2 dst.<br>
                                Contoh: 1. Persiapan; 2. Pekerjaan Pengukuran; 3. Pembangunan Pondasi; 4. dst.
                            </li>
                            <li>Kolom a diisi dengan nomor urut.</li>
                            <li>
                                Kolom b diisi dengan uraian kegiatan/pekerjaan yang dibutuhkan.<br>
                                Misal: tukang, tukang pipa, mandor, pipa PVC, sewa tripod.
                            </li>
                            <li>
                                Kolom c diisi dengan volume penggunaan tenaga kerja, bahan, dan peralatan pada setiap
                                tahapan pekerjaan.
                            </li>
                            <li>
                                Kolom d diisi dengan satuan seperti:
                                <ul>
                                    <li>Tenaga kerja: Orang Bulan (OB), Orang Harian (OH), Orang Jam (OJ)</li>
                                    <li>Bahan: meter, kg, sak, kubik (m³)</li>
                                    <li>Peralatan: unit</li>
                                </ul>
                            </li>
                            <li>Kolom e diisi dengan harga satuan sesuai dengan standar yang berlaku.</li>
                            <li>
                                Kolom f diisi dengan jumlah biaya yang merupakan hasil perkalian kolom c dan kolom e.
                            </li>
                            <li>
                                Kolom g diisi dengan rencana jadwal pekerjaan dalam hitungan hari/minggu/bulan yang
                                diisi dengan checklist.
                            </li>
                            <li>
                                Kolom h diisi dengan keterangan lain-lain jika diperlukan.
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

@push('js')
    <script>
        function downloadWord() {
            const content = $('#summernote').summernote('code');

            const docHeader = `
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Dokumen Surat</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                }

                /* Global table border */
                table, th, td {
                    border: 1px solid black;
                    border-collapse: collapse;
                }

                th, td {
                    padding: 5px;
                }

                /* Khusus untuk tabel tanpa border */
                table.no-border, table.no-border td {
                    border: none !important;
                }
            </style>
        </head>
        <body>
        `;

            const docFooter = `</body></html>`;
            const fullHtml = docHeader + content + docFooter;

            const blob = window.htmlDocx.asBlob(fullHtml, {
                orientation: 'landscape'
            });

            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'Rencana Anggaran Biaya.docx';
            link.click();
        }
    </script>
@endpush
