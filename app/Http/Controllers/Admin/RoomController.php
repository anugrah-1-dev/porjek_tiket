<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rooms;
use App\Models\ProgramCamp;
use Illuminate\Http\Request;
use App\Models\PendaftaranProgramCamp;
use Carbon\Carbon;

class RoomController extends Controller
{

    public function index()
    {
        $programCamps = ProgramCamp::all();
        $rooms = Rooms::all();

        $durasiToDays = [
            'perhari' => 1,
            'satu_minggu' => 7,
            'dua_minggu' => 14,
            'satu_bulan' => 30,
            'dua_bulan' => 60,
            'tiga_bulan' => 90,
            'enam_bulan' => 180,
            'satu_tahun' => 365,
        ];

        $penghuniExpired = [];

        $pendaftar = PendaftaranProgramCamp::whereNotNull('room_id')->get();

        foreach ($pendaftar as $p) {
            $durasi = $durasiToDays[$p->durasi_paket] ?? 0;
            $endDate = Carbon::parse($p->updated_at)->addDays($durasi);

            if (now()->greaterThan($endDate)) {
                $penghuniExpired[] = [
                    'nama' => $p->nama_lengkap,
                    'no_hp' => $p->no_hp,
                    'nama_kamar' => $p->nama_kamar,
                    'trx_id' => $p->trx_id,
                    'durasi' => $p->durasi_paket,
                    'expired_at' => $endDate->format('d M Y')
                ];
            }
        }

        return view('admin.rooms.index', compact('rooms', 'programCamps', 'penghuniExpired'));
    }


    public function edit(Rooms $room)
    {
        $programs = ProgramCamp::all();
        return view('admin.rooms.edit', compact('room', 'programs'));
    }

    public function update(Request $request, $id)
    {
        $room = Rooms::findOrFail($id);

        $request->validate([
            'gender' => 'required|in:putra,putri',
            'kategori' => 'required|in:vvip,vip,barack',
            'kapasitas' => 'required|integer|min:1',
            'penghuni' => 'required|integer|min:0',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        if ($request->status === 'nonaktif' && $room->penghuni > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Kamar memiliki penghuni. Pindahkan peserta terlebih dahulu.'
            ]);
        }


        $room->update([
            'gender' => $request->input('gender'),
            'kategori' => $request->input('kategori'),
            'kapasitas' => $request->input('kapasitas'),
            'penghuni' => $request->input('penghuni'),
            'status' => $request->input('status'),
        ]);



        return response()->json(['success' => true]);
    }


    public function getPenghuni($id)
    {
        $penghuni = PendaftaranProgramCamp::with('period') // penting untuk akses period.created_at
            ->where('room_id', $id)
            ->orderBy('updated_at', 'desc')
            ->get([
                'nama_lengkap',
                'trx_id',
                'durasi_paket',
                'no_hp',
                'gender',
                'period_id',
                'updated_at'
            ]);

        return response()->json($penghuni);
    }



    public function kickPenghuni($trx_id)
    {
        $pendaftar = PendaftaranProgramCamp::where('trx_id', $trx_id)->first();

        if (!$pendaftar) {
            return response()->json(['success' => false, 'message' => 'Peserta tidak ditemukan.']);
        }

        $pendaftar->update([
            'room_id' => null,
            'nama_kamar' => null
        ]);

        return response()->json(['success' => true, 'message' => 'Penghuni berhasil dikeluarkan.']);
    }

    public function listAktif()
    {
        $rooms = Rooms::where('status', 'aktif')->get(['id', 'nomor_kamar', 'gender']);
        return response()->json($rooms);
    }

    public function pindahPeserta(Request $request)
    {
        $request->validate([
            'trx_id' => 'required|string',
            'room_id_baru' => 'required|exists:rooms,id'
        ]);

        $peserta = PendaftaranProgramCamp::where('trx_id', $request->trx_id)->first();

        if (!$peserta) {
            return response()->json(['success' => false, 'message' => 'Peserta tidak ditemukan.']);
        }

        $peserta->room_id = $request->room_id_baru;
        $peserta->save();

        return response()->json(['success' => true]);
    }

    public function getPesertaDetail($roomId)
    {
        $peserta = PendaftaranProgramCamp::where('room_id', $roomId)->get();

        $filtered_rooms = [];
        foreach ($peserta as $p) {
            $room = $p->room; // relasi room
            if (!$room) continue;

            $filtered_rooms[$p->id] = Rooms::where('id', '!=', $room->id)
                ->where('program_camp_id', $room->program_camp_id)
                ->where('gender', $room->gender)
                ->where('kategori', $room->kategori)
                ->where('status', 'aktif')
                ->whereRaw('penghuni < kapasitas')
                ->get(['id', 'nomor_kamar']);
        }


        return response()->json([
            'peserta' => $peserta,
            'filtered_rooms' => $filtered_rooms,
        ]);
    }
}
