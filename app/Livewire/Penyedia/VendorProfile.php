<?php

namespace App\Livewire\Penyedia;

use App\Models\ComCode;
use App\Models\Tag;
use App\Models\TagVendor;
use App\Models\User;
use App\Models\Vendor;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class VendorProfile extends Component
{
    public $vendor;
    public $user;
    public $klasifikasiUsaha = [];
    public $formattedData = [];

    public function mount($vendorId)
    {
        $this->vendor = Vendor::findOrFail($vendorId);
        $this->user = User::where('vendor_id', $vendorId)->first();

        // Load klasifikasi usaha
        $this->klasifikasiUsaha = TagVendor::where('vendor_id', $vendorId)
            ->get()
            ->map(function ($tagVendor) {
                $tag = Tag::find($tagVendor->tag_id);
                return [
                    'nama' => $tag ? $tag->id : null,
                    'nama_text' => $tag ? "{$tag->kode_kbli} - {$tag->nama}" : 'Unknown',
                    'foto' => $tagVendor->photo_path,
                    'latitude' => $tagVendor->latitude,
                    'longitude' => $tagVendor->longitude,
                ];
            })
            ->toArray();

        // Format ComCode values
        $this->formattedData = [
            'jenis_usaha' => $this->getCodeName($this->vendor->jenis_usaha, 'JENIS_USAHA_ST'),
            'kualifikasi' => $this->getCodeName($this->vendor->kualifikasi, 'KUALIFIKASI_ST'),
            'bank_st' => $this->getCodeName($this->vendor->bank_st, 'BANK_ST'),
            'masa_berlaku_nib' => $this->vendor->masa_berlaku_nib ? date('d M Y', strtotime($this->vendor->masa_berlaku_nib)) : '-',
        ];
    }

    private function getCodeName($code, $group)
    {
        $comCode = ComCode::where('code_group', $group)->where('com_cd', $code)->first();
        return $comCode ? $comCode->code_nm : '-';
    }

    public function render()
    {
        return view('livewire.penyedia.vendor-profile');
    }
}
