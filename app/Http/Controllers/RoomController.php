<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::latest()->get();
        $total = $rooms->count();
        $tersedia = $rooms->where('status', 'Tersedia')->count();
        $terisi = $rooms->where('status', 'Terisi')->count();
        $perawatan = $rooms->where('status', 'Perawatan')->count();

        return view('admin.rooms.index', compact('rooms', 'total', 'tersedia', 'terisi', 'perawatan'));
    }

    public function listRooms(Request $request)
    {
        $towers = Room::whereNotNull('nama_tower')
            ->where('nama_tower', '!=', '')
            ->distinct()
            ->pluck('nama_tower')
            ->sort()
            ->values();

        $tipes = Room::whereNotNull('tipe')
            ->where('tipe', '!=', '')
            ->distinct()
            ->pluck('tipe')
            ->sort()
            ->values();

        $query = Room::whereIn('status', ['Tersedia', 'Perawatan', 'Terisi']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('nama_tower', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tower')) {
            $query->where('nama_tower', $request->tower);
        }

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->filled('harga_min')) {
            $query->where('harga_per_malam', '>=', (float) $request->harga_min);
        }
        if ($request->filled('harga_max')) {
            $query->where('harga_per_malam', '<=', (float) $request->harga_max);
        }

        if ($request->filled('tamu')) {
            $query->where('tamu_dewasa', '>=', (int) $request->tamu);
        }

        $hasCheckIn = $request->filled('check_in');
        $hasCheckOut = $request->filled('check_out');

        $checkIn = null;
        $checkOut = null;

        try {
            if ($hasCheckIn && $hasCheckOut) {
                $checkIn = Carbon::parse($request->check_in)->startOfDay();
                $checkOut = Carbon::parse($request->check_out)->startOfDay();
            } else {
                $checkIn = Carbon::today()->startOfDay();
                $checkOut = Carbon::today()->addDay()->startOfDay();
            }

            if ($checkOut && $checkIn && $checkOut->gt($checkIn)) {
                $conflictingRoomIds = Booking::whereIn('status', ['pending', 'confirmed'])
                    ->where(function ($q) use ($checkIn, $checkOut) {
                        $q->where('check_in', '<', $checkOut->toDateString())
                            ->where('check_out', '>', $checkIn->toDateString());
                    })
                    ->pluck('room_id')
                    ->unique()
                    ->toArray();

                if (!empty($conflictingRoomIds)) {
                    $query->whereNotIn('id', $conflictingRoomIds);
                }
            }
        } catch (\Exception $e) {
            // ignore invalid dates and continue without date filtering
        }

        $sort = $request->get('sort', 'terbaru');
        switch ($sort) {
            case 'harga_rendah':
                $query->orderBy('harga_per_malam', 'asc');
                break;
            case 'harga_tinggi':
                $query->orderBy('harga_per_malam', 'desc');
                break;
            case 'luas_besar':
                $query->orderBy('luas', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $rooms = $query->paginate(12)->appends(request()->query());

        return view('list-rooms', compact('rooms', 'towers', 'tipes'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function ownerCreate()
    {
        return view('admin.rooms.owner_create');
    }

    private function uploadImages(Request $request): ?array
    {
        $uploadedImages = [];
        if ($request->hasFile('gambar')) {
            $images = $request->file('gambar');
            if (!is_array($images)) {
                $images = [$images];
            }
            foreach ($images as $image) {
                $uploadedImages[] = $image->store('rooms', 'public');
            }
        }

        return $uploadedImages ?: null;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'luas' => 'required|numeric|min:0',
            'tipe' => 'required|string|max:100',
            'harga_per_malam' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|array|max:5',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'string|max:100',
            'nama_tower' => 'required|string|max:100',
            'lantai' => 'required|integer|min:1',
            'nomor_kamar' => 'required|string|max:50',
            'tamu_dewasa' => 'required|integer|min:0',
            'tamu_anak' => 'required|integer|min:0',
            'jumlah_kamar' => 'required|integer|min:1',
            'jumlah_kamar_mandi' => 'required|integer|min:1',
            'check_in' => 'required|string|max:10',
            'check_out' => 'required|string|max:10',
            'status' => 'required|in:Tersedia,Terisi,Perawatan',
            'tata_tertib' => 'nullable|string',
            'owner_nama' => 'required|string|max:255',
            'owner_wa' => 'required|string|max:20',
            'owner_rekening' => 'required|string|max:100',
            'owner_bank_name' => 'required|string|max:50',
        ]);

        $images = $this->uploadImages($request);
        if ($images) {
            $validated['gambar'] = $images;
        }

        Room::create($validated);

        return redirect()->route('admin.rooms.index')->with('success', 'Room berhasil ditambahkan!');
    }

    public function ownerStore(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'luas' => 'required|numeric|min:0',
            'tipe' => 'required|string|max:100',
            'harga_per_malam' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|array|max:5',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'string|max:100',
            'nama_tower' => 'required|string|max:100',
            'lantai' => 'required|integer|min:1',
            'nomor_kamar' => 'required|string|max:50',
            'tamu_dewasa' => 'required|integer|min:0',
            'tamu_anak' => 'required|integer|min:0',
            'jumlah_kamar' => 'required|integer|min:1',
            'jumlah_kamar_mandi' => 'required|integer|min:1',
            'check_in' => 'required|string|max:10',
            'check_out' => 'required|string|max:10',
            'status' => 'required|in:Tersedia,Terisi,Perawatan',
            'tata_tertib' => 'nullable|string',
            'owner_nama' => 'required|string|max:255',
            'owner_wa' => 'required|string|max:20',
            'owner_rekening' => 'required|string|max:100',
            'owner_bank_name' => 'required|string|max:50',
        ]);

        $images = $this->uploadImages($request);
        if ($images) {
            $validated['gambar'] = $images;
        }

        Room::create($validated);

        return redirect()->route('admin.rooms.owner.create')
            ->with('success', 'Pendaftaran room berhasil dikirim! Tim kami akan meninjau data Anda.');
    }

    public function show(Room $room)
    {
        return view('admin.rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'luas' => 'required|numeric|min:0',
            'tipe' => 'required|string|max:100',
            'harga_per_malam' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|array|max:5',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'string|max:100',
            'nama_tower' => 'required|string|max:100',
            'lantai' => 'required|integer|min:1',
            'nomor_kamar' => 'required|string|max:50',
            'tamu_dewasa' => 'required|integer|min:0',
            'tamu_anak' => 'required|integer|min:0',
            'jumlah_kamar' => 'required|integer|min:1',
            'jumlah_kamar_mandi' => 'required|integer|min:1',
            'check_in' => 'required|string|max:10',
            'check_out' => 'required|string|max:10',
            'status' => 'required|in:Tersedia,Terisi,Perawatan',
            'tata_tertib' => 'nullable|string',
            'owner_nama' => 'required|string|max:255',
            'owner_wa' => 'required|string|max:20',
            'owner_rekening' => 'required|string|max:100',
            'owner_bank_name' => 'required|string|max:50',
        ]);

        $images = $this->uploadImages($request);
        if ($images) {
            if ($room->gambar && is_array($room->gambar)) {
                foreach ($room->gambar as $oldImage) {
                    if (Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
            }
            $validated['gambar'] = $images;
        }

        $room->update($validated);

        return redirect()->route('admin.rooms.index')->with('success', 'Room berhasil diperbarui!');
    }

    public function destroy(Room $room)
    {
        if ($room->gambar && is_array($room->gambar)) {
            foreach ($room->gambar as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }
        }

        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Room berhasil dihapus!');
    }
}

