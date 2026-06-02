<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\Apartment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function rooms()
    {
        $statusFilter = request()->get('status');
        $query = Room::with('apartment')->latest();

        if ($statusFilter && in_array($statusFilter, ['Tersedia', 'Terisi', 'Perawatan', 'Pending'])) {
            $query->where('status', $statusFilter);
        }
                
        $rooms = $query->get();
        $total = $rooms->count();
        $tersedia = $rooms->where('status', 'Tersedia')->count();
        $terisi = $rooms->where('status', 'Terisi')->count();
        $perawatan = $rooms->where('status', 'Perawatan')->count();
        $pending = $rooms->where('status', 'Pending')->count();

        return view('admin.rooms.allRooms', compact('rooms', 'total', 'tersedia', 'terisi', 'perawatan', 'pending', 'statusFilter'));
    }

    public function index(Request $request, $apartmentId)
    {
        $apartment = Apartment::findOrFail($apartmentId);
        $rooms = $apartment->rooms()->latest()->get();
        $total = $rooms->count();
        $tersedia = $rooms->where('status', 'Tersedia')->count();
        $terisi = $rooms->where('status', 'Terisi')->count();
        $perawatan = $rooms->where('status', 'Perawatan')->count();

        return view('admin.rooms.index', compact('rooms', 'total', 'tersedia', 'terisi', 'perawatan', 'apartment'));
    }

    public function listRooms(Request $request)
    {
        $towers = Apartment::whereNotNull('nama')
        ->where('nama', '!=', '')
        ->distinct()
        ->pluck('nama')
        ->sort()
            ->values();

        $tipes = Room::whereNotNull('tipe')
            ->where('tipe', '!=', '')
            ->distinct()
            ->pluck('tipe')
            ->sort()
            ->values();

        $apartment = Apartment::where('nama', $request->get('apartment'))->first();

        $query = empty($apartment) ? Room::whereIn('status', ['Tersedia', 'Perawatan', 'Terisi']) : $apartment->rooms()->whereIn('status', ['Tersedia', 'Perawatan', 'Terisi']);

        if ($request->filled('search')) {
            $search = trim($request->search);

            // normalize by removing common apartment words so "Apartment Sudirman",
            // "Apartemen Sudirman" and "Sudirman" all match
            $normalized = preg_replace('/\b(apartment|apartemen|apartement|apt|apart)\b/i', '', $search);
            $normalized = trim($normalized);

            $query->where(function ($q) use ($search, $normalized) {
                // search room title and tower
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('nama_tower', 'like', "%{$search}%");

                if (!empty($normalized)) {
                    $q->orWhere('judul', 'like', "%{$normalized}%")
                      ->orWhere('nama_tower', 'like', "%{$normalized}%");
                }

                // search apartment name and address
                $q->orWhereHas('apartment', function ($qa) use ($search, $normalized) {
                    $qa->where('nama', 'like', "%{$search}%")
                       ->orWhere('alamat', 'like', "%{$search}%");

                    if (!empty($normalized)) {
                        $qa->orWhere('nama', 'like', "%{$normalized}%")
                           ->orWhere('alamat', 'like', "%{$normalized}%");
                    }
                });
            });
        }

        // if ($request->filled('tower')) {
        //     $query->where('nama_tower', $request->tower);
        // }

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

    public function apartmentRooms(Apartment $apartment)
    {
        $rooms = $apartment->rooms()->whereIn('status', ['Tersedia', 'Perawatan', 'Terisi'])->latest()->get();

        return view('list-rooms', compact('rooms', 'apartment'));
    }

    public function create($apartmentId)
    {
        $apartment = Apartment::findOrFail($apartmentId);
        return view('admin.rooms.create', compact('apartment'));
    }

    public function ownerCreate()
    {
        $apartments = Apartment::orderBy('nama')->get(['id', 'nama']);

        return view('admin.rooms.owner_create', compact('apartments'));
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

    public function store(Request $request, $apartmentId)
    {
        $apartment = Apartment::findOrFail($apartmentId);
        // $request->all();
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
            'nama_tower' => 'required|string|max:255',
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

        $validated['apartment_id'] = $apartment->id;

        Room::create($validated);

        return redirect()->route('admin.apartments.rooms.index', $apartment->id)->with('success', 'Room berhasil ditambahkan!');
    }

    public function ownerStore(Request $request)
    {
        $validated = $request->validate([
            'apartment_id' => 'required|exists:apartments,id',
            'judul' => 'required|string|max:255',
            'luas' => 'required|numeric|min:0',
            'tipe' => 'required|string|max:100',
            'harga_per_malam' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|array|max:5',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'string|max:100',
            'nama_tower' => 'required|string|max:255',
            'lantai' => 'required|integer|min:1',
            'nomor_kamar' => 'required|string|max:50',
            'tamu_dewasa' => 'required|integer|min:0',
            'tamu_anak' => 'required|integer|min:0',
            'jumlah_kamar' => 'required|integer|min:1',
            'jumlah_kamar_mandi' => 'required|integer|min:1',
            'check_in' => 'required|string|max:10',
            'check_out' => 'required|string|max:10',
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

        return redirect()->route('rooms.owner.create')
            ->with('success', 'Pendaftaran room berhasil dikirim! Tim kami akan meninjau data Anda.');
    }

    public function show($apartmentId, $room_id)
    {
        $apartment = Apartment::findOrFail($apartmentId);
        $room = $apartment->rooms()->findOrFail($room_id);

        return view('admin.rooms.show', compact('room', 'apartment'));
    }

    public function edit($room_id)
    {
        $room = Room::findOrFail($room_id);
        $apartment = $room->apartment;
        $apartments = Apartment::orderBy('nama')->get(['id', 'nama']);

        return view('admin.rooms.edit', compact('room', 'apartment', 'apartments'));
    }

    public function update(Request $request, $room_id)
    {
        $room = Room::findOrFail($room_id);

        // dd($request->all());
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
            'nama_tower' => 'required|string|max:255',
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

        return redirect()->route('admin.apartments.rooms.index', $room->apartment_id)->with('success', 'Room berhasil diperbarui!');
    }

    public function destroy($room_id)
    {
        // $apartment = Apartment::findOrFail($apartmentId);
        $room = Room::find($room_id);

        if (!$room) {
            return redirect()->back()->with('error', 'Ops, terjadi kesalahan. Room tidak ditemukan!');
        }

        if ($room->gambar && is_array($room->gambar)) {
            foreach ($room->gambar as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }
        }

        $room->delete();

        return redirect()->back()->with('success', 'Room berhasil dihapus!');
    }
}

