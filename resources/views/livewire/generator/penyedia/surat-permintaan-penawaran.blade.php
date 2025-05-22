<div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if (session()->has('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif
                <div class="card mb-3 shadow-sm border-primary">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-calendar-alt"></i> Jadwal Kegiatan Pengadaan
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="tgl_pemasukan">Pemasukan dan Pembukaan Dokumen Penawaran</label>
                                <input type="datetime-local" wire:model.defer="tgl_pemasukan" class="form-control"
                                    id="tgl_pemasukan">
                                @error('tgl_pemasukan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="tgl_evaluasi">Evaluasi Teknis dan Biaya</label>
                                <input type="datetime-local" wire:model.defer="tgl_evaluasi" class="form-control"
                                    id="tgl_evaluasi">
                                @error('tgl_evaluasi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="tgl_negosiasi">Negosiasi Harga</label>
                                <input type="datetime-local" wire:model.defer="tgl_negosiasi" class="form-control"
                                    id="tgl_negosiasi">
                                @error('tgl_negosiasi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="paling_lambat">Paling Lambat Penyerahan Penawaran</label>
                                <input type="datetime-local" wire:model.defer="paling_lambat" class="form-control"
                                    id="paling_lambat">
                                @error('paling_lambat')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="jangka_waktu">Jangka Waktu (hari kalender)</label>
                                <input type="number" wire:model.defer="jangka_waktu" class="form-control"
                                    id="jangka_waktu" min="1" placeholder="misal: 7">
                                @error('jangka_waktu')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-primary mt-2" wire:click="simpanTanggal">
                            <i class="fas fa-save"></i> Simpan Jadwal Tanggal
                        </button>
                    </div>

                </div>

                <!-- Summernote Editor -->
                <div wire:ignore>
                    <textarea id="summernote">{!! $isiSurat !!}</textarea>
                </div>

                <!-- Tombol Aksi -->
                <div class="mt-3 mb-3">
                    {{-- <button class="btn btn-primary" wire:click="simpan">
                        <i class="fas fa-save"></i> Simpan Dokumen
                    </button> --}}

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
                orientation: 'portrait'
            });

            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'Surat Permintaan Penawaran.docx';
            link.click();
        }
    </script>
@endpush
