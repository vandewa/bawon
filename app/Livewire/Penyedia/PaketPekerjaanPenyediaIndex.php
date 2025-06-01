<?php

namespace App\Livewire\Penyedia;

use Livewire\Component;
use App\Models\Penawaran;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Jobs\kirimPesan; // Import the Job

class PaketPekerjaanPenyediaIndex extends Component
{
    use WithPagination;
    use WithFileUploads;

    const PAKET_TYPE_01 = 'PAKET_TYPE_01';

    public string $cari = '';

    protected string $paginationTheme = 'bootstrap';

    public bool $showUploadBuktiPemeriksaanModal = false;
    public ?int $selectedPenawaranId = null;
    public $buktiPemeriksaanFile;

    protected array $rules = [
        'buktiPemeriksaanFile' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
    ];

    protected array $messages = [
        'buktiPemeriksaanFile.required' => 'File bukti pemeriksaan wajib diunggah.',
        'buktiPateriPemeriksaanFile.file' => 'Input harus berupa file.',
        'buktiPemeriksaanFile.mimes' => 'File harus berformat PDF, JPG, JPEG, atau PNG.',
        'buktiPemeriksaanFile.max' => 'Ukuran file maksimal 5MB.',
    ];

    public function render()
    {
        $query = Penawaran::with([
            'paketKegiatan' => function ($query) {
                $query->with(['paketPekerjaan.desa.user', 'paketType', 'statusKegiatan', 'negosiasi']); // Tambahkan 'desa.user'
            },
            'statusPenawaran'
        ])
        ->where('kirim_st', true)
        ->whereHas('paketKegiatan', function ($q) {
            $q->where('paket_type', self::PAKET_TYPE_01);
        })
        ->when($this->cari, function ($q) {
            $q->whereHas('paketKegiatan.paketPekerjaan', function ($subQuery) {
                $subQuery->where('nama_kegiatan', 'like', '%' . $this->cari . '%');
            });
        });

        if (Auth::user()->vendor_id) {
            $query->where('vendor_id', Auth::user()->vendor_id);
        }

        $posts = $query->latest()->paginate(10);

        return view('livewire.penyedia.paket-pekerjaan-penyedia-index', compact('posts'));
    }

    public function openUploadBuktiPemeriksaanModal(int $penawaranId)
    {
        $this->resetValidation();
        $this->selectedPenawaranId = $penawaranId;
        $this->buktiPemeriksaanFile = null;
        $this->showUploadBuktiPemeriksaanModal = true;
    }

    public function closeUploadBuktiPemeriksaanModal()
    {
        $this->showUploadBuktiPemeriksaanModal = false;
        $this->reset(['selectedPenawaranId', 'buktiPemeriksaanFile']);
    }

    public function saveBuktiPemeriksaan()
    {
        $this->validate();

        try {
            $penawaran = Penawaran::find($this->selectedPenawaranId);

            if (!$penawaran) {
                session()->flash('error', 'Penawaran tidak ditemukan.');
                $this->js('Swal.fire({
                    icon: "error",
                    title: "Gagal!",
                    text: "Penawaran tidak ditemukan!",
                    showConfirmButton: true,
                });');
                $this->closeUploadBuktiPemeriksaanModal();
                return;
            }

            $paketKegiatan = $penawaran->paketKegiatan;

            if (!$paketKegiatan) {
                session()->flash('error', 'Paket Kegiatan terkait tidak ditemukan.');
                $this->js('Swal.fire({
                    icon: "error",
                    title: "Gagal!",
                    text: "Paket Kegiatan terkait tidak ditemukan!",
                    showConfirmButton: true,
                });');
                $this->closeUploadBuktiPemeriksaanModal();
                return;
            }

            $filePath = $this->buktiPemeriksaanFile->store('dokumen_penyedia/bukti_pemeriksaan');

            $paketKegiatan->update([
                'laporan_hasil_pemeriksaan' => $filePath,
            ]);

            session()->flash('success', 'Bukti pemeriksaan berhasil diunggah.');
            $this->js('Swal.fire({
                icon: "success",
                title: "Berhasil!",
                text: "Bukti pemeriksaan berhasil diunggah!",
                showConfirmButton: false,
                timer: 2500
            });');
            $this->closeUploadBuktiPemeriksaanModal();
            $this->dispatch('refreshComponent');

            // --- Bagian Baru: Mengirim Pesan ke Desa Menggunakan Job ---

            // 1. Dapatkan nomor HP desa
            // Menggunakan relasi desa->user->whatsapp
            $nohapeDesa = $paketKegiatan->paketPekerjaan->desa->user->whatsapp ?? null;

            if ($nohapeDesa) {
                // 2. Buat pesan
                $namaKegiatan = $paketKegiatan->paketPekerjaan->nama_kegiatan ?? 'Tidak Diketahui';
                // Menggunakan nama perusahaan vendor dari penawaran
                $vendorName = $penawaran->vendor->nama_perusahaan ?? 'Penyedia Tidak Diketahui';
                $pesan = "Halo, bukti pemeriksaan untuk kegiatan '{$namaKegiatan}' telah diunggah oleh penyedia '{$vendorName}'. Mohon segera diperiksa.";

                // 3. Dispatch Job kirimPesan
                kirimPesan::dispatch($nohapeDesa, $pesan);

                // Opsional: Log atau notifikasi bahwa pesan sedang dikirim
                // \Log::info("Pesan notifikasi ke desa ({$nohapeDesa}) untuk kegiatan '{$namaKegiatan}' sedang dikirim.");
            } else {
                // \Log::warning("Nomor HP desa tidak ditemukan untuk paket kegiatan ID: {$paketKegiatan->id}. Pesan tidak dikirim.");
            }

            // --- Akhir Bagian Baru ---

        } catch (\Exception $e) {
            session()->flash('error', 'Gagal mengunggah bukti pemeriksaan: ' . $e->getMessage());
            $this->js('Swal.fire({
                icon: "error",
                title: "Gagal!",
                text: "Gagal mengunggah bukti pemeriksaan: ' . addslashes($e->getMessage()) . '",
                showConfirmButton: true,
            });');
            // \Log::error('Error uploading bukti pemeriksaan: ' . $e->getMessage());
        }
    }
}
