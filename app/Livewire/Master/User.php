<?php

namespace App\Livewire\Master;

use Livewire\Component;
use App\Models\Role;
use App\Models\User as ModelsUser;

class User extends Component
{

    public $role, $listRole, $konfirmasi_password, $idHapus, $edit = false, $user, $isGantiPassword = false;

    public $form = [
        'name' => null,
        'email' => null,
        'whatsapp' => null,
        'password' => null,
    ];


    public function mount($id = '')
    {
        if ($id) {
            $user = ModelsUser::find($id)->only(['name', 'email', 'whatsapp']);
            $data = ModelsUser::find($id);
            $this->form = $user;
            $this->role = $data->roles()->first()->id ?? '';
            $this->edit = true;
            $this->user = $id;
        }

        $this->listRole = Role::all()->toArray();
    }

    public function ambilRole()
    {
        return Role::all()->toArray();

    }

    public function save()
    {

        if ($this->edit) {
            $this->storeUpdate();
        } else {
            $this->store();
        }

        $this->js(<<<'JS'
        Swal.fire({
            title: 'Good job!',
            text: 'You clicked the button!',
            icon: 'success',
          })
        JS);

        return redirect(route('master.user-index'));
    }

    public function store()
    {
        $this->validate([
            'konfirmasi_password' => 'required|same:form.password',
            'form.password' => 'required',
            'form.name' => 'required',
            'form.email' => 'required|unique:users,email',
            'role' => 'required',
        ]);

        $this->form['password'] = bcrypt($this->form['password']);
        $a = ModelsUser::create($this->form);
        $a->addrole($this->role);
    }

    public function storeUpdate()
    {
        $this->validate([
            'konfirmasi_password' => 'same:form.password',
            'form.name' => 'required',
            'form.email' => 'required|email|unique:users,email,' . $this->user,
            'role' => 'required',
        ]);

        // Only hash and update password if it's not empty
        if (!empty($this->form['password'])) {
            $this->form['password'] = bcrypt($this->form['password']);
        } else {
            // Remove password from the form array if it's empty to avoid updating with an empty value
            unset($this->form['password']);
        }

        ModelsUser::find($this->user)->update($this->form);

        $a = ModelsUser::find($this->user);
        $a->syncRoles([$this->role]);
        $this->reset();
        $this->edit = false;
    }

    public function updated($property)
    {
        if ($property === 'isGantiPassword' && $this->isGantiPassword === false) {
            $this->form['password'] = null;
            $this->konfirmasi_password = null;
        }
    }

    public function render()
    {
        return view('livewire.master.user', [
            'listRole' => $this->ambilRole()
        ]);
    }
}
