<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
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
        $query = Apartment::where('status', 'Tersedia'); // Only show available apartments

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

        $apartments = $query->paginate(12)->withQueryString();

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

    private function uploadImages(Request $request): ?array
    {
        $uploadedImages = [];
        if ($request->hasFile('gambar')) {
            $images = $request->file('gambar');
            // Ensure it's an array
            if (!is_array($images)) {
                $images = [$images];
            }
            foreach ($images as $image) {
                $uploadedImages[] = $image->store('apartments', 'public');
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
            'alamat' => 'required|string',
            'alamat_google' => 'nullable|string',
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

        Apartment::create($validated);

        return redirect()->route('admin.apartments.index')->with('success', 'Apartemen berhasil ditambahkan!');
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
            'alamat' => 'required|string',
            'alamat_google' => 'nullable|string',
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
            'judul' => 'required|string|max:255',
            'luas' => 'required|numeric|min:0',
            'tipe' => 'required|string|max:100',
            'harga_per_malam' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|array|max:5',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'string|max:100',
            'alamat' => 'required|string',
            'alamat_google' => 'nullable|string',
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
            // Delete old images
            if ($apartment->gambar && is_array($apartment->gambar)) {
                foreach ($apartment->gambar as $oldImage) {
                    if (Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
            }
            $validated['gambar'] = $images;
        }

        $apartment->update($validated);

        return redirect()->route('admin.apartments.index')->with('success', 'Apartemen berhasil diperbarui!');
    }

    public function destroy(Apartment $apartment)
    {
        if ($apartment->gambar && is_array($apartment->gambar)) {
            foreach ($apartment->gambar as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }
        }
        $apartment->delete();

        return redirect()->route('admin.apartments.index')->with('success', 'Apartemen berhasil dihapus!');
    }
}
