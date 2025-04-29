<?php

namespace App\Livewire\Desa;

use App\Models\Desa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class DesaEdit extends Component
{
    public $desaId;
    public $desa = [];
    public $user = [];
    public $userExists = false;

    public function mount($id)
    {
        $desa = Desa::findOrFail($id);
        $this->desaId = $desa->id;
        $this->desa = $desa->toArray();

        $user = User::where('desa_id', $desa->id)->first();
        if ($user) {
            $this->userExists = true;
            $this->user = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ];
        }
    }

    public function save()
    {
        $this->validate([
            // Validasi Desa
            'desa.kabupaten' => 'required|string',
            'desa.kode_desa' => 'required|string|unique:desas,kode_desa,' . $this->desaId,
            'desa.kecamatan_id' => 'required|string',
            'desa.name' => 'required|string',
            'desa.kode_pos' => 'nullable|string',
            'desa.alamat' => 'nullable|string',
            'desa.web' => 'nullable|url',
            'desa.email' => 'nullable|email',
            'desa.telp' => 'nullable|string',

            // Validasi User (jika ada input email)
            'user.name' => 'nullable|string',
            'user.email' => 'nullable|email',
            'user.password' => 'nullable|string|min:6|confirmed',
        ]);

        // Update data desa
        $desa = Desa::findOrFail($this->desaId);
        $desa->update($this->desa);

        // Update atau Buat user
        if (!empty($this->user['email'])) {
            if ($this->userExists) {
                $user = User::findOrFail($this->user['id']);
                $user->name = $this->user['name'];
                $user->email = $this->user['email'];
                if (!empty($this->user['password'])) {
                    $user->password = Hash::make($this->user['password']);
                }
                $user->save();
            } else {
             $user =   User::create([
                    'name' => $this->user['name'],
                    'email' => $this->user['email'],
                    'password' => Hash::make($this->user['password']),
                    'desa_id' => $this->desaId,
                ]);
                $user->syncRoles(['desa']);
            }
        }

        session()->flash('message', 'Data Desa dan User berhasil diperbarui.');
        return redirect()->route('desa.desa-index');
    }

    public function render()
    {
        return view('livewire.desa.desa-edit');
    }
}
