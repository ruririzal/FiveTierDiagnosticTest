<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function index()
    {
        $pengaturan = Pengaturan::first();

        return view('settings', compact('pengaturan'));
    }

    public function updateProfile(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore(request()->email, 'email'),
            ],
        ]);

        $user = \Auth::user();
        $user->update($validatedData);

        return redirect()->route('settings')->with('message', 'Profil Berhasil Disimpan');
    }

    public function updatePassword(Request $request)
    {
        $validatedData = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = \Auth::user();
        $user->update([ 'password' => Hash::make($validatedData['password'])]);

        return redirect()->route('settings')->with('message', 'Password Berhasil Disimpan');
    }

    public function updateDurasiTes(Request $request)
    {
        abort_if(! \Auth::user()->is_admin, Response::HTTP_UNAUTHORIZED);

        $validatedData = $request->validate([
            'durasi_menit' => ['required', 'numeric', 'min:0'],
            'durasi_menit_simulasi' => ['required', 'numeric', 'min:0'],
        ]);

        $pengaturan = Pengaturan::firstOrCreate(['id'=>1], $validatedData);
        $pengaturan->update($validatedData);

        return redirect()->route('settings')->with('message', 'Durasi Berhasil Disimpan');
    }
}
