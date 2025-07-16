<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\PresenceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AbsenController extends Controller
{
    public function index($slug)
    {
        $presence = Presence::where('slug', $slug)->first();
        $presenceDetails = PresenceDetail::where('presence_id', $presence->id)->get();
        return view('pages.absen.index', compact('presence', 'presenceDetails'));
    }
    public function save(Request $request, string $id){
        
        $presence = Presence::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'asal_instansi' => 'required',
            'signature' => 'required',
        ]);

        $presenceDetail = new PresenceDetail();
        $presenceDetail->presence_id = $presence->id;
        $presenceDetail->nama = $request->nama;
        $presenceDetail->jabatan = $request->jabatan;
        $presenceDetail->asal_instansi = $request->asal_instansi;

        // decode base64 img
        $base64_image = $request->signature;
        @list($type, $file_data) = explode(';', $base64_image);
        @list(, $file_data) = explode(',', $file_data);

        // generate nama file
        $uniqChar = date('YmdHis') . uniqid();
        $signature = "tanda-tangan/{$uniqChar}.png";

        // simpan file ke storage
        Storage::disk('public_uploads')->put($signature, base64_decode($file_data));

        $presenceDetail->tanda_tangan = $signature;
        $presenceDetail->save();

        return redirect()->back();
    }
}
