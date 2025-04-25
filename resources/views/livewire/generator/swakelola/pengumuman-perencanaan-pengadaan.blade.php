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
                            <li>Kolom b diisi dengan nama kegiatan pengadaan.</li>
                            <li>Kolom c diisi dengan nilai pengadaan di setiap kegiatan dalam rupiah.</li>
                            <li>Kolom d diisi dengan memilih salah satu cara pengadaan, yaitu Swakelola atau Penyedia.
                            </li>
                            <li>Kolom e diisi dengan keluaran jumlah volume.</li>
                            <li>Kolom f diisi dengan satuan volume. Misal: unit, orang, dokumen.</li>
                            <li>Kolom g diisi dengan nama TPK yang ditetapkan berdasarkan hasil Musrenbangdes atau SK
                                Kepala Desa tentang penetapan TPK.</li>
                            <li>Kolom h diisi dengan lokasi tempat pengadaan dilaksanakan.</li>
                            <li>Kolom i diisi dengan rencana rentang waktu dilaksanakannya pengadaan.</li>
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
            link.download = 'Pengumuman Perencanaan Pengadaan.docx';
            link.click();
        }
    </script>
@endpush
