<?php

namespace App\Http\Controllers;

use App\User;

class SiswaController extends Controller
{
    public function destroy(User $siswa)
    {
        $siswa->delete();
        return redirect()->back()->with('message', "Siswa Berhasil Dihapus");
    }
}