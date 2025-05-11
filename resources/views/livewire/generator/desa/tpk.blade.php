<div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if (session()->has('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif

                <!-- Summernote Editor -->
                <div wire:ignore>
                    <textarea id="summernote" wire:model="isiSurat"></textarea>
                </div>

                <!-- Tombol Aksi -->
                <div class="mt-3 mb-3">
                    <button class="btn btn-success" onclick="downloadWord()">
                        <i class="fas fa-file-word"></i> Download Word
                    </button>
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
                    margin: 0;  /* Menghapus margin global pada body */
                    padding: 0; /* Menghapus padding pada body */
                }

                /* Global table border */
                table, th, td {
                    border: 1px solid black;
                    border-collapse: collapse;
                }

                th, td {
                    padding: 5px;
                    margin: 0;  /* Menghapus margin pada cell table */
                }

                /* Khusus untuk tabel tanpa border */
                table.no-border, table.no-border td {
                    border: none !important;
                }

                /* Menghilangkan spasi antara paragraf dan elemen lainnya */
                p, div, td {
                    margin: 0; 
                    padding: 0; 
                }

                /* Menghapus margin tambahan setelah tag br (line break) */
                br {
                    margin: 0;
                    padding: 0;
                }

                /* Mengatur jarak spasi kosong di bawah tanda tangan */
                .signature {
                    margin-bottom: 0;
                }

            </style>
        </head>
        <body>
        `;

            const docFooter = `</body></html>`;
            const fullHtml = docHeader + content + docFooter;

            const blob = window.htmlDocx.asBlob(fullHtml, {
                orientation: 'portrait'
            });

            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'Surat Keputusan TPK.docx';
            link.click();
        }
    </script>


    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                callbacks: {
                    onChange: function(contents) {
                        // Kirim nilai terbaru ke Livewire
                        @this.set('isiSurat', contents);
                    }
                }
            });

            // Set nilai awal dari Livewire ke Summernote
            $('#summernote').summernote('code', @this.isiSurat);
        });
    </script>
@endpush
