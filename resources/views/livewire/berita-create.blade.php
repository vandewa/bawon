<div>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Berita</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Master</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('master.berita-index') }}">Berita</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </x-slot>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info card-outline">
                        <form class="form-horizontal mt-2" wire:submit="save">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="judul" class="col-sm-2 col-form-label">Judul</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="judul"
                                                    wire:model="form.judul" placeholder="Judul Berita">
                                                @error('form.judul')
                                                    <span class="form-text text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row" wire:ignore>
                                            <label for="isi_berita" class="col-sm-2 col-form-label">Isi Berita</label>
                                            <div class="col-sm-10">
                                                <textarea id="summernote" class="summernote" wire:model="form.isi_berita"></textarea>
                                                @error('form.isi_berita')
                                                    <span class="form-text text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="file_berita" class="col-sm-2 col-form-label">Gambar</label>
                                            <div class="col-sm-10">
                                                <input type="file" class="form-control" id="file_berita"
                                                    wire:model="file_berita" accept="image/*">
                                                @error('file_berita')
                                                    <span class="form-text text-danger">{{ $message }}</span>
                                                @enderror

                                                @if ($file_berita)
                                                    <div class="mt-3">
                                                        <img src="{{ $file_berita->temporaryUrl() }}" height="250">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                                <a href="{{ route('master.berita-index') }}"
                                    class="btn btn-default float-right">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('js')
    <script>
        document.addEventListener('livewire:initialized', () => {
            function initializeSummernote() {
                // Hancurkan Summernote jika sudah ada
                if ($('.summernote').hasClass('summernote')) {
                    $('.summernote').summernote('destroy');
                }

                // Inisialisasi Summernote
                $('.summernote').summernote({
                    height: 150,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link']],
                        ['view', ['fullscreen', 'codeview']],
                    ],
                    callbacks: {
                        onChange: function(contents) {
                            @this.set('form.isi_berita', contents);
                        }
                    }
                });
            }

            // Inisialisasi Summernote saat event diterima
            Livewire.on('init-summernote', () => {
                initializeSummernote();
            });

            // Inisialisasi awal
            initializeSummernote();
        });
    </script>
@endpush
