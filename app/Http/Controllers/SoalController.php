<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Traits\MediaUploadingTrait;

class SoalController extends Controller
{
    use MediaUploadingTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_soal = Soal::withCount('jawaban')->simplePaginate(10);
        
        return view('soal.index', compact('all_soal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('soal.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $this->validateStoreAndUpdate($request);

        DB::beginTransaction();
        
        $soal = Soal::create($validatedData);
        $compact = $this->createJawabanDanAlasanJawaban($validatedData, $soal);

        DB::commit();

        $jumlah_soal = Soal::count();

        return redirect()->back()->withInput($validatedData)->with('message', 'Soal berhasil disimpan dengan ' . count($compact['all_jawaban']) . ' Jawaban dan ' . count($compact['all_alasan']) . ' Alasan Jawaban.  Total soal saat ini ' . $jumlah_soal);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Soal  $soal
     * @return \Illuminate\Http\Response
     */
    public function edit(Soal $soal)
    {
        $soal->load('jawaban');

        return view('soal.edit', compact('soal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Soal  $soal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Soal $soal)
    {
        $validatedData = $this->validateStoreAndUpdate($request);
        
        DB::beginTransaction();
        
        $soal->update($validatedData);
        $soal->jawaban()->delete();
        $soal->alasanJawaban()->delete();
        $compact = $this->createJawabanDanAlasanJawaban($validatedData, $soal);
        
        DB::commit();

        $jumlah_soal = Soal::count();

        return redirect()->back()->withInput($validatedData)->with('message', 'Soal berhasil disimpan dengan ' . count($compact['all_jawaban']) . ' Jawaban dan ' . count($compact['all_alasan']) . ' Alasan Jawaban.  Total soal saat ini ' . $jumlah_soal);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Soal  $soal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Soal $soal)
    {
        $soal->delete();
        return redirect()->back()->with('message', 'Soal berhasil dihapus');
    }

    public function validateStoreAndUpdate(Request $request)
    {
        return $request->validate([
            'is_aktif' => ['required'],
            'teks' => ['required'],
            'jawaban_teks' => ['required'],
            'alasan_teks' => ['required'],
            'is_jawaban_benar' => ['nullable'],
            'is_alasan_benar' => ['nullable'],
        ]);
    }

    private function createJawabanDanAlasanJawaban($validatedData, Soal $soal)
    {
        $all_jawaban = collect($validatedData['jawaban_teks'])->filter(function ($value, $key) {
            return ! is_null($value);
        })->transform(function($item, $key) use ($validatedData) {
            return ['teks' => $item, 'is_benar' => $validatedData['is_jawaban_benar'][$key]];
        });

        $all_alasan = collect($validatedData['alasan_teks'])->filter(function ($value, $key) {
            return ! is_null($value);
        })->transform(function($item, $key) use ($validatedData) {
            return ['teks' => $item, 'is_benar' => $validatedData['is_alasan_benar'][$key]];
        });

        $soal->jawaban()->createMany($all_jawaban);
        $soal->alasanJawaban()->createMany($all_alasan);

        return compact('all_jawaban', 'all_alasan');
    }
}
