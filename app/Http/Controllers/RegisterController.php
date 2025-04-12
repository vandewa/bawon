<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Session;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nik' => 'required|unique:users,nik',
                'email' => 'required|unique:users,email',
                'name' => 'required|string|max:255',
                'wa' => 'required|numeric|unique:users,wa',
                'password' => 'required|confirmed|min:8',
                'password_confirmation' => 'required|same:password',
            ],
            [
                'nik.required' => 'NIK harus diisi.',
                'email.required' => 'Email harus diisi.',
                'nik.unique' => 'NIK sudah terdaftar.',
                'email.unique' => 'Email sudah terdaftar.',
                'wa.required' => 'WhatsApp harus diisi.',
                'wa.unique' => 'WhatsApp sudah terdaftar.',
            ]
        );

        $a = User::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'wa' => $request->wa,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $a->addrole('3');

        return redirect(route('registrasi.index'))->with('status', 'oke');

    }
}
