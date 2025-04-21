<div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h5>Editor Surat Dinas</h5>

                @if (session()->has('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif

                <div wire:ignore>
                    <textarea id="summernote">{!! $isiSurat !!}</textarea>
                </div>

                <button class="btn btn-primary mt-3" wire:click="simpan">Simpan Surat</button>
                <button class="btn btn-success mt-2" onclick="downloadWord()">Download Word</button>

            </div>
        </div>
    </div>
</div>


@push('js')
    <script>
        $(function() {
            $('#summernote').summernote({
                height: 400,
                fontNames: ['Arial', 'Arial Black', 'Times New Roman', 'Courier New', 'Tahoma'],
                fontNamesIgnoreCheck: ['Arial'], // pastikan Arial tetap muncul
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                    ['misc', ['undo', 'redo']]
                ],
                callbacks: {
                    onInit: function() {
                        // Set default font ke Arial
                        document.execCommand('fontName', false, 'Arial');
                    }
                }
            });

            // Optional: CodeMirror untuk textarea lainnya (jika pakai)
            if (document.getElementById("codeMirrorDemo")) {
                CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
                    mode: "htmlmixed",
                    theme: "monokai"
                });
            }
        });
    </script>

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
                    body { font-family: Arial, sans-serif; }
                    table, th, td { border: 1px solid black; border-collapse: collapse; }
                    th, td { padding: 5px; }
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
            link.download = 'Surat-Dinas.docx';
            link.click();
        }
    </script>
@endpush
