<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApartmentController extends Controller
{
    public function index()
    {
        $apartments = Apartment::latest()->get();
        $total = $apartments->count();
        $tersedia = $apartments->where('status', 'Tersedia')->count();
        $terisi = $apartments->where('status', 'Terisi')->count();
        $perawatan = $apartments->where('status', 'Perawatan')->count();
        return view('admin.apartments.index', compact('apartments', 'total', 'tersedia', 'terisi', 'perawatan'));
    }

    public function listApartments(Request $request)
    {
        // Get unique values for filters
        $towers = Apartment::whereNotNull('nama_tower')
            ->where('nama_tower', '!=', '')
            ->distinct()
            ->pluck('nama_tower')
            ->sort()
            ->values();

        $tipes = Apartment::whereNotNull('tipe')
            ->where('tipe', '!=', '')
            ->distinct()
            ->pluck('tipe')
            ->sort()
            ->values();

        // Build query with filters
        // $query = Apartment::where('status', 'Tersedia'); // Only show available apartments
        $query = Apartment::whereIn('status', ['Tersedia', 'Perawatan', 'Terisi']); // Only show available apartments

        // Filter by search keyword
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('nama_tower', 'like', "%{$search}%");
            });
        }

        // Filter by tower
        if ($request->filled('tower')) {
            $query->where('nama_tower', $request->tower);
        }

        // Filter by tipe
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        // Filter by price range
        if ($request->filled('harga_min')) {
            $query->where('harga_per_malam', '>=', (float) $request->harga_min);
        }
        if ($request->filled('harga_max')) {
            $query->where('harga_per_malam', '<=', (float) $request->harga_max);
        }

        // Filter by guests
        if ($request->filled('tamu')) {
            $query->where('tamu_dewasa', '>=', (int) $request->tamu);
        }

        // Filter availability based on selected dates.
        // If user doesn't choose dates, default to today & tomorrow.
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
                // Overlap rule: existing.check_in < requested.check_out AND existing.check_out > requested.check_in
                $conflictingApartmentIds = Booking::whereIn('status', ['pending', 'confirmed'])
                    ->where(function ($q) use ($checkIn, $checkOut) {
                        $q->where('check_in', '<', $checkOut->toDateString())
                            ->where('check_out', '>', $checkIn->toDateString());
                    })
                    ->pluck('apartment_id')
                    ->unique()
                    ->toArray();

                if (!empty($conflictingApartmentIds)) {
                    $query->whereNotIn('id', $conflictingApartmentIds);
                }
            }
        } catch (\Exception $e) {
            // ignore invalid dates and continue without date filtering
        }


        // Sort
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

        $apartments = $query->paginate(12)->appends(request()->query());

        return view('list-apartments', compact('apartments', 'towers', 'tipes'));
    }

    public function create()
    {
        return view('admin.apartments.create');
    }

    public function ownerCreate()
    {
        return view('admin.apartments.owner_create');
    }

    private function uploadImages(Request $request): ?string
    {
        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            return $image->store('apartments', 'public');
        }

        return null;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'alamat' => 'required|string',
            'google_maps_embed' => 'required|string',
        ]);

        $image = $this->uploadImages($request);
        if ($image) {
            $validated['gambar'] = $image;
        }

        Apartment::create($validated);

        return redirect()->route('admin.apartments.index')->with('success', 'Apartemen berhasil ditambahkan!');
    }

    public function ownerStore(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'alamat' => 'required|string',
            'google_maps_embed' => 'required|string',
        ]);

        $image = $this->uploadImages($request);
        if ($image) {
            $validated['gambar'] = $image;
        }

        Apartment::create($validated);

        return redirect()->route('admin.apartments.owner.create')->with('success', 'Pendaftaran apartemen berhasil dikirim! Tim kami akan meninjau data Anda.');
    }

    public function show(Apartment $apartment)
    {
        return view('admin.apartments.show', compact('apartment'));
    }

    public function edit(Apartment $apartment)
    {
        return view('admin.apartments.edit', compact('apartment'));
    }

    public function update(Request $request, Apartment $apartment)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'alamat' => 'required|string',
            'google_maps_embed' => 'required|string',
        ]);

        $image = $this->uploadImages($request);
        if ($image) {
            // Delete old image
            if ($apartment->gambar && Storage::disk('public')->exists($apartment->gambar)) {
                Storage::disk('public')->delete($apartment->gambar);
            }
            $validated['gambar'] = $image;
        }

        $apartment->update($validated);

        return redirect()->route('admin.apartments.index')->with('success', 'Apartemen berhasil diperbarui!');
    }

    public function destroy(Apartment $apartment)
    {
        if ($apartment->gambar && Storage::disk('public')->exists($apartment->gambar)) {
            Storage::disk('public')->delete($apartment->gambar);
        }
        $apartment->delete();

        return redirect()->route('admin.apartments.index')->with('success', 'Apartemen berhasil dihapus!');
    }
}
