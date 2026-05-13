<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
// Pastikan direktori rooms ada
        Storage::disk('public')->makeDirectory('rooms');
        Storage::disk('public')->makeDirectory('rooms/demo_rooms');



        // Data dummy 10 room
        $rooms = [
            [
                'judul' => 'Apartemen Sudirman Park',
                'luas' => 45.00,
                'tipe' => '2 BR',
                'harga_per_malam' => 750000,
                'deskripsi' => 'Apartemen nyaman di pusat kota dengan view city light yang menakjubkan. Dekat dengan pusat perbelanjaan dan transportasi umum.',
                'nama_tower' => 'Tower A',
                'lantai' => 15,
                'nomor_kamar' => '1502',
                'tamu_dewasa' => 4,
                'tamu_anak' => 2,
                'jumlah_kamar' => 2,
                'jumlah_kamar_mandi' => 1,
                'check_in' => '14:00',
                'check_out' => '12:00',
                'status' => 'Tersedia',
                'tata_tertib' => "- Dilarang merokok di dalam unit\n- Check-in pukul 14:00, Check-out pukul 12:00\n- Tidak boleh membawa hewan peliharaan\n- Maksimal 6 tamu",
                'owner_nama' => 'Budi Santoso',
                'owner_wa' => '081234567890',
                'owner_rekening' => '1234567890 (BCA a.n. Budi Santoso)',
            ],
            [
                'judul' => 'Studio Apartment Thamrin',
                'luas' => 28.50,
                'tipe' => 'Studio',
                'harga_per_malam' => 450000,
                'deskripsi' => 'Studio cozy untuk solo traveler atau pasangan. Lokasi strategis di Thamrin dengan akses mudah ke mall dan restoran.',
                'nama_tower' => 'Tower B',
                'lantai' => 8,
                'nomor_kamar' => '805',
                'tamu_dewasa' => 2,
                'tamu_anak' => 0,
                'jumlah_kamar' => 1,
                'jumlah_kamar_mandi' => 1,
                'check_in' => '15:00',
                'check_out' => '11:00',
                'status' => 'Terisi',
                'tata_tertib' => "- Dilarang merokok\n- Check-in 15:00, Check-out 11:00\n- No party\n- Quiet hours 22:00 - 07:00",
                'owner_nama' => 'Siti Aminah',
                'owner_wa' => '082345678901',
                'owner_rekening' => '2345678901 (Mandiri a.n. Siti Aminah)',
            ],
            [
                'judul' => 'Luxury Penthouse Kemang',
                'luas' => 120.00,
                'tipe' => 'Penthouse',
                'harga_per_malam' => 2500000,
                'deskripsi' => 'Penthouse mewah dengan rooftop private pool dan view kota 360 derajat. Furnitur premium dan smart home system.',
                'nama_tower' => 'Tower Premium',
                'lantai' => 25,
                'nomor_kamar' => 'PH01',
                'tamu_dewasa' => 6,
                'tamu_anak' => 4,
                'jumlah_kamar' => 3,
                'jumlah_kamar_mandi' => 3,
                'check_in' => '14:00',
                'check_out' => '12:00',
                'status' => 'Tersedia',
                'tata_tertib' => "- Deposit Rp 2.000.000\n- Dilarang merokok\n- No pets allowed\n- Maksimal 10 tamu",
                'owner_nama' => 'Ahmad Rizki',
                'owner_wa' => '083456789012',
                'owner_rekening' => '3456789012 (BNI a.n. Ahmad Rizki)',
            ],
            [
                'judul' => 'Apartemen Taman Anggrek 3BR',
                'luas' => 65.00,
                'tipe' => '3 BR',
                'harga_per_malam' => 950000,
                'deskripsi' => 'Apartemen keluarga luas dengan 3 kamar tidur. Dekat Mall Taman Anggrek dan Universitas Indonesia.',
                'nama_tower' => 'Tower C',
                'lantai' => 12,
                'nomor_kamar' => '1208',
                'tamu_dewasa' => 6,
                'tamu_anak' => 3,
                'jumlah_kamar' => 3,
                'jumlah_kamar_mandi' => 2,
                'check_in' => '14:00',
                'check_out' => '12:00',
                'status' => 'Perawatan',
                'tata_tertib' => "- Sedang dalam renovasi\n- Tidak tersedia sementara\n- Estimasi selesai 1 Juni 2025",
                'owner_nama' => 'Dewi Lestari',
                'owner_wa' => '084567890123',
                'owner_rekening' => '4567890123 (BRI a.n. Dewi Lestari)',
            ],
            [
                'judul' => 'Cozy 1BR Apartemen BSD',
                'luas' => 36.00,
                'tipe' => '1 BR',
                'harga_per_malam' => 350000,
                'deskripsi' => 'Apartemen 1BR modern di BSD City dengan fasilitas lengkap. Cocok untuk working professional.',
                'nama_tower' => 'Tower D',
                'lantai' => 5,
                'nomor_kamar' => '512',
                'tamu_dewasa' => 2,
                'tamu_anak' => 1,
                'jumlah_kamar' => 1,
                'jumlah_kamar_mandi' => 1,
                'check_in' => '14:00',
                'check_out' => '12:00',
                'status' => 'Tersedia',
                'tata_tertib' => "- Dilarang merokok di dalam unit\n- Check-in 14:00, Check-out 12:00\n- Free WiFi 50Mbps\n- Gym dan pool access",
                'owner_nama' => 'Rudi Hartono',
                'owner_wa' => '085678901234',
                'owner_rekening' => '5678901234 (BCA a.n. Rudi Hartono)',
            ],
            [
                'judul' => 'Duplex Apartment SCBD',
                'luas' => 85.00,
                'tipe' => 'Duplex',
                'harga_per_malam' => 1800000,
                'deskripsi' => 'Duplex eksklusif di SCBD dengan desain modern minimalis. 2 lantai dengan living room yang luas.',
                'nama_tower' => 'Tower Executive',
                'lantai' => 18,
                'nomor_kamar' => '1801',
                'tamu_dewasa' => 4,
                'tamu_anak' => 2,
                'jumlah_kamar' => 2,
                'jumlah_kamar_mandi' => 2,
                'check_in' => '14:00',
                'check_out' => '12:00',
                'status' => 'Tersedia',
                'tata_tertib' => "- Deposit Rp 1.000.000\n- No smoking\n- No pets\n- Maksimal 6 tamu",
                'owner_nama' => 'Nina Wijaya',
                'owner_wa' => '086789012345',
                'owner_rekening' => '6789012345 (Mandiri a.n. Nina Wijaya)',
            ],
            [
                'judul' => 'Studio Premium PIK',
                'luas' => 32.00,
                'tipe' => 'Studio',
                'harga_per_malam' => 550000,
                'deskripsi' => 'Studio premium di Pantai Indah Kapuk dengan view laut. Dekat dengan restoran seafood dan wahana rekreasi.',
                'nama_tower' => 'Tower E',
                'lantai' => 10,
                'nomor_kamar' => '1005',
                'tamu_dewasa' => 2,
                'tamu_anak' => 0,
                'jumlah_kamar' => 1,
                'jumlah_kamar_mandi' => 1,
                'check_in' => '15:00',
                'check_out' => '11:00',
                'status' => 'Terisi',
                'tata_tertib' => "- Check-in 15:00, Check-out 11:00\n- No smoking\n- Free parking 1 mobil\n- Pool access included",
                'owner_nama' => 'Yoga Pratama',
                'owner_wa' => '087890123456',
                'owner_rekening' => '7890123456 (BCA a.n. Yoga Pratama)',
            ],
            [
                'judul' => 'Family Apartment Kelapa Gading',
                'luas' => 72.00,
                'tipe' => '3 BR',
                'harga_per_malam' => 850000,
                'deskripsi' => 'Apartemen keluarga di Kelapa Gading dengan taman bermain anak. Dekat dengan sekolah internasional.',
                'nama_tower' => 'Tower F',
                'lantai' => 7,
                'nomor_kamar' => '711',
                'tamu_dewasa' => 6,
                'tamu_anak' => 4,
                'jumlah_kamar' => 3,
                'jumlah_kamar_mandi' => 2,
                'check_in' => '14:00',
                'check_out' => '12:00',
                'status' => 'Tersedia',
                'tata_tertib' => "- Family friendly\n- Dilarang merokok di dalam\n- Playground access\n- Maksimal 10 tamu",
                'owner_nama' => 'Maya Sari',
                'owner_wa' => '088901234567',
                'owner_rekening' => '8901234567 (BNI a.n. Maya Sari)',
            ],
            [
                'judul' => 'Modern 2BR Apartemen Tebet',
                'luas' => 52.00,
                'tipe' => '2 BR',
                'harga_per_malam' => 600000,
                'deskripsi' => 'Apartemen modern 2BR di Tebet dengan kitchen set lengkap. Dekat stasiun Tebet dan pusat kuliner.',
                'nama_tower' => 'Tower G',
                'lantai' => 9,
                'nomor_kamar' => '918',
                'tamu_dewasa' => 4,
                'tamu_anak' => 2,
                'jumlah_kamar' => 2,
                'jumlah_kamar_mandi' => 1,
                'check_in' => '14:00',
                'check_out' => '12:00',
                'status' => 'Tersedia',
                'tata_tertib' => "- Dilarang merokok\n- Check-in 14:00, Check-out 12:00\n- Full kitchen set\n- Netflix ready",
                'owner_nama' => 'Fajar Nugroho',
                'owner_wa' => '089012345678',
                'owner_rekening' => '9012345678 (BRI a.n. Fajar Nugroho)',
            ],
            [
                'judul' => 'Budget Studio Cibubur',
                'luas' => 24.00,
                'tipe' => 'Studio',
                'harga_per_malam' => 250000,
                'deskripsi' => 'Studio budget-friendly di Cibubur dengan fasilitas dasar yang lengkap. Cocok untuk staycation hemat.',
                'nama_tower' => 'Tower H',
                'lantai' => 3,
                'nomor_kamar' => '302',
                'tamu_dewasa' => 2,
                'tamu_anak' => 1,
                'jumlah_kamar' => 1,
                'jumlah_kamar_mandi' => 1,
                'check_in' => '14:00',
                'check_out' => '12:00',
                'status' => 'Tersedia',
                'tata_tertib' => "- Budget stay\n- Dilarang merokok\n- Check-in 14:00, Check-out 12:00\n- WiFi included",
                'owner_nama' => 'Lina Kusuma',
                'owner_wa' => '081098765432',
                'owner_rekening' => '1098765432 (Mandiri a.n. Lina Kusuma)',
            ],
        ];

        $fasilitasOptions = [
            'WiFi', 'AC', 'TV', 'Kulkas', 'Microwave', 'Water Heater',
            'Kitchen', 'Balkon', 'Laundry', 'Gym', 'Kolam Renang', 'Parkir',
            'Keamanan 24 Jam', 'CCTV', 'Elevator', 'Rooftop', 'Lounge', 'BBQ Area',
        ];

        foreach ($rooms as $index => $data) {
            // Copy 5 demo images for this room
            $demoImages = Storage::disk('public')->files('demo');
            $startIndex = $index * 4;
            $images = [];

            // Relasikan room ke apartment kategori
            // default: set setelah ApartmentSeeder dijalankan (minimal-drift untuk demo)
            // Agar tidak error saat seeder dijalankan tanpa apartment data, tetap gunakan null.
            $data['apartment_id'] = null;

            // Catatan: relasi yang benar akan dibuat oleh ApartmentSeeder.



            for ($i = 0; $i < 4; $i++) {
                $demoImageIndex = $startIndex + $i;
                if (isset($demoImages[$demoImageIndex])) {
                    $originalPath = $demoImages[$demoImageIndex];
                    $extension = pathinfo($originalPath, PATHINFO_EXTENSION);
                    $newFilename = "rooms/demo_room_{$index}_{$i}.{$extension}";
                    Storage::disk('public')->copy($originalPath, $newFilename);
                    $images[] = $newFilename;
                }
            }

            // Random fasilitas (5-10 item)
            $randomFasilitas = array_slice($fasilitasOptions, 0, rand(5, 10));
            shuffle($randomFasilitas);
            $data['fasilitas'] = array_slice($randomFasilitas, 0, rand(5, 10));
            $data['gambar'] = $images;

            // Cegah duplicate slug saat seeder dijalankan lebih dari sekali
            // slug akan diset otomatis oleh model via boot() jika tidak ada di $data
            // sehingga kita gunakan updateOrCreate berdasarkan judul/slug turunan.
            $slug = \Str::slug($data['judul'] ?? '');

            Room::updateOrCreate(
                ['slug' => $slug],
                $data
            );


        }
    }
}

