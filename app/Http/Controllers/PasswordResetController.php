<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Jobs\kirimPesan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    public function index()
    {
        return view('auth.reset-password');
    }

    public function updatePassword(Request $request)
    {
        $cek = User::where('email', $request->data)->orWhere('nik', $request->data)->first();

        if ($cek) {

            $password = Str::random(8);

            User::where('email', $cek->email)->update([
                'password' => bcrypt($password)
            ]);

            $pesan = '*Notifikasi*' . urldecode('%0D%0A%0D%0A') .
                'Silahkan login dengan email dan password dibawah ini:' . urldecode('%0D%0A') .
                'Email : ' . $cek->email . urldecode('%0D%0A') .
                'Password :' . $password . urldecode('%0D%0A%0D%0A') .
                'Apabila ingin mengubah password Anda, klik pada menu Data Diri lalu klik "Ganti Password"'
            ;

            kirimPesan::dispatch($cek->wa, $pesan);

            return redirect(route('password.index'))->with('status', 'oke');

        } else {

            return redirect(route('password.index'))->with('wrong', 'ups');

        }

    }
}
