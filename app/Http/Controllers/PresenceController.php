<?php

namespace App\Http\Controllers;

use App\DataTables\PresencesDataTable;
use App\Models\Presence;
use App\Models\PresenceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PresenceController extends Controller{
    /**
     * Display a listing of the resource.
     */
    public function index(PresencesDataTable $dataTable)
    {
        // $presences = Presence::all();
        return $dataTable->render('pages.presence.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.presence.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required',
            'tgl_kegiatan' => 'required',
            'waktu_mulai' => 'required',
        ]);
        
        $data = [
            'nama_kegiatan' => $request->nama_kegiatan,
            'slug' => Str::slug($request->nama_kegiatan),
            'tgl_kegiatan' => $request->tgl_kegiatan. ' ' .$request->waktu_mulai,
        ];
        
        Presence::create($data);

        return redirect()->route('presence.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {   
        $presence = Presence::findOrFail($id);
        $presenceDetails = PresenceDetail::where('presence_id', $id)->get();
        return view('pages.presence.detail.index', compact('presence', 'presenceDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $presence = Presence::findOrFail($id);
        return view('pages.presence.edit', compact('presence'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kegiatan' => 'required',
            'tgl_kegiatan' => 'required',
            'waktu_mulai' => 'required',
        ]);
        
        $presence = Presence::findOrFail($id);
        $presence->nama_kegiatan = $request->nama_kegiatan;
        $presence->slug = Str::slug($request->nama_kegiatan);
        $presence->tgl_kegiatan = $request->tgl_kegiatan. ' ' .$request->waktu_mulai;
        $presence->save();

        return redirect()->route('presence.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Delete presence detail absen
        $presenceDetails = PresenceDetail::where('presence_id', $id)->get();
        foreach ($presenceDetails as $pd) {
            if ($pd->tanda_tangan) {
                Storage::disk('public_uploads')->delete($pd->tanda_tangan);
            }
            $pd->delete();
        }
        
        // Delete kegiatan
        Presence::destroy($id);
        
        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus.']);
    }
}
