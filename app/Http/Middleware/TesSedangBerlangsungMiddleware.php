<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\Models\SiswaTes;
use App\Models\Pengaturan;
use App\Models\SimulasiSiswaTes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

class TesSedangBerlangsungMiddleware
{
    public function handle($request, Closure $next)
    {
        if(auth()->check() && Route::current()->getName() !== 'tes' && $request->isMethod('get')){
            $pengaturan = Pengaturan::first() ?? Pengaturan::create(['durasi_menit'=> 120, 'durasi_menit_simulasi_simulasi' => 5]);
            $tes = SiswaTes::where('siswa_id', auth()->id())->first();
            if($tes){
                //jika tes sedang berlangsung
                if($tes->waktu_mulai->addMinutes($pengaturan->durasi_menit)->greaterThan(now()) && ! $tes->waktu_selesai){
                    return redirect('tes');
                }
            }
        }elseif(auth()->check() && Route::current()->getName() !== 'tes_simulasi' && $request->isMethod('get')){
            $pengaturan = Pengaturan::first() ?? Pengaturan::create(['durasi_menit'=> 120, 'durasi_menit_simulasi_simulasi' => 5]);
            $tes = SimulasiSiswaTes::where('siswa_id', auth()->id())->first();
            if($tes){
                //jika simulasi sedang berlangsung
                if($tes->waktu_mulai->addMinutes($pengaturan->durasi_menit_simulasi)->greaterThan(now()) && ! $tes->waktu_selesai){
                    return redirect('simulasi');
                }
            }
        }

        return $next($request);
    }
}
