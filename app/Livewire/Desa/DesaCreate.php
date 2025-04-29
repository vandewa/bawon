<?php

namespace App\Livewire\Desa;

use App\Models\Desa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class DesaCreate extends Component
{
    public $desa = [];
    public $user = [];

    public function save()
    {
        $this->validate([
            // Validasi untuk Desa
            'desa.kabupaten' => 'required|string',
            'desa.kode_desa' => 'required|string|unique:desas,kode_desa',
            'desa.kecamatan_id' => 'required|string',
            'desa.name' => 'required|string',
            'desa.kode_pos' => 'nullable|string',
            'desa.alamat' => 'nullable|string',
            'desa.web' => 'nullable|url',
            'desa.email' => 'nullable|email',
            'desa.telp' => 'nullable|string',

            // Validasi untuk User
            'user.name' => 'required|string',
            'user.email' => 'required|email|unique:users,email',
            'user.password' => 'required|string|min:6|confirmed',
        ]);

        // Simpan data Desa dulu
        $desa = Desa::create($this->desa);

        // Lalu simpan User terkait dengan desa_id
       $a =  User::create([
            'name' => $this->user['name'],
            'email' => $this->user['email'],
            'password' => Hash::make($this->user['password']),
            'desa_id' => $desa->id,
        ]);

        $a->syncRoles(['desa']);

        session()->flash('message', 'Data Desa dan User berhasil dibuat.');
        return redirect()->route('desa-index');
    }

    public function render()
    {
        return view('livewire.desa.desa-create');
    }
}
