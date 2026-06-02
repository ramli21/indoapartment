@extends('admin.layout')

@section('content')
    <section class="pt-24 pb-12 min-h-screen">
        <div class="max-w-4xl px-4 sm:px-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-brand">Daftar Ruangan</h1>
                    <p class="text-slate-500 mt-1">Apartment : {{ $apartment->nama }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.help') }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-100 text-slate-600 text-sm font-medium rounded-xl hover:bg-slate-200 transition-colors">
                        <i data-lucide="help-circle" class="w-4 h-4"></i>
                        Panduan
                    </a>
                    <a href="{{ route('admin.apartments.rooms.create', $apartment) }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand text-white text-sm font-medium rounded-xl hover:bg-brand-light transition-colors shadow-lg shadow-brand/20">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Tambah Room
                    </a>
                </div>
            </div>

            <!-- Alert -->
            @if (session('error'))
                <div
                    class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3 text-red-700 animate-fadeIn">
                    <i data-lucide="x-circle" class="w-5 h-5 shrink-0"></i>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Alert -->
            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3 text-green-700 animate-fadeIn">
                    <i data-lucide="check-circle" class="w-5 h-5 shrink-0"></i>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Status Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-brand/10 flex items-center justify-center">
                            <i data-lucide="building-2" class="w-5 h-5 text-brand"></i>
                        </div>
                        <span class="text-xs font-medium text-slate-400">Total</span>
                    </div>
                    <div class="text-2xl font-bold text-slate-800">{{ $total }}</div>
                    <div class="text-xs text-slate-500 mt-1">Semua apartemen</div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                            <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600"></i>
                        </div>
                        <span class="text-xs font-medium text-emerald-600">Tersedia</span>
                    </div>
                    <div class="text-2xl font-bold text-slate-800">{{ $tersedia }}</div>
                    <div class="text-xs text-slate-500 mt-1">Siap dihuni</div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                            <i data-lucide="user-check" class="w-5 h-5 text-amber-600"></i>
                        </div>
                        <span class="text-xs font-medium text-amber-600">Terisi</span>
                    </div>
                    <div class="text-2xl font-bold text-slate-800">{{ $terisi }}</div>
                    <div class="text-xs text-slate-500 mt-1">Sedang ditempati</div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center">
                            <i data-lucide="wrench" class="w-5 h-5 text-red-600"></i>
                        </div>
                        <span class="text-xs font-medium text-red-600">Perawatan</span>
                    </div>
                    <div class="text-2xl font-bold text-slate-800">{{ $perawatan }}</div>
                    <div class="text-xs text-slate-500 mt-1">Dalam perbaikan</div>
                </div>
            </div>

            <!-- Table -->
            @if ($rooms->count() > 0)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-100">
                                    <th class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Gambar</th>
                                    <th class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Room</th>
                                    <th class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tipe
                                    </th>
                                    <th class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Harga/Malam</th>
                                    <th class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Status</th>
                                    <th class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Tower / Lantai</th>
                                    <th class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Kamar</th>
                                    <th class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tamu
                                    </th>
                                    <th class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Owner</th>
                                    <th
                                        class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($rooms as $room)
                                    <tr class="hover:bg-slate-50/50 transition-colors group">
                                        <!-- Gambar -->
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="w-16 h-12 rounded-lg overflow-hidden bg-slate-100">
                                                @if ($room->gambar && is_array($room->gambar) && count($room->gambar) > 0)
                                                    <img src="{{ asset('storage/' . $room->gambar[0]) }}"
                                                        alt="{{ $room->judul }}" class="w-full h-full object-cover">
                                                @else
                                                    <div
                                                        class="w-full h-full flex items-center justify-center text-slate-300">
                                                        <i data-lucide="image-off" class="w-4 h-4"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Apartemen -->
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="font-medium text-slate-800 text-sm">{{ $room->judul }}
                                                </div>
                                                <div class="text-xs text-slate-400 mt-0.5 line-clamp-1">
                                                    {{ Str::limit($room->apartment->alamat, 40) }}</div>
                                            </div>
                                        </td>

                                        <!-- Tipe -->
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <span class="px-2.5 py-1 bg-brand/10 text-brand text-xs font-medium rounded-lg">
                                                {{ $room->tipe }}
                                            </span>
                                        </td>

                                        <!-- Harga -->
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="text-sm font-semibold text-slate-800">
                                                Rp {{ number_format($room->harga_per_malam, 0, ',', '.') }}
                                            </div>
                                        </td>

                                        <!-- Status -->
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            @php
                                                $statusConfig = [
                                                    'Tersedia' => [
                                                        'bg' => 'bg-emerald-50',
                                                        'text' => 'text-emerald-700',
                                                        'dot' => 'bg-emerald-500',
                                                    ],
                                                    'Terisi' => [
                                                        'bg' => 'bg-amber-50',
                                                        'text' => 'text-amber-700',
                                                        'dot' => 'bg-amber-500',
                                                    ],
                                                    'Perawatan' => [
                                                        'bg' => 'bg-red-50',
                                                        'text' => 'text-red-700',
                                                        'dot' => 'bg-red-500',
                                                    ],
                                                ];
                                                $config = $statusConfig[$room->status] ?? $statusConfig['Tersedia'];
                                            @endphp
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $config['bg'] }} {{ $config['text'] }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $config['dot'] }}"></span>
                                                {{ $room->status }}
                                            </span>
                                        </td>

                                        <!-- Tower / Lantai -->
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="text-sm text-slate-700">{{ $room->nama_tower }}</div>
                                            <div class="text-xs text-slate-400">Lantai {{ $room->lantai }} • No.
                                                {{ $room->nomor_kamar }}</div>
                                        </td>

                                        <!-- Kamar -->
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="text-sm text-slate-700">{{ $room->jumlah_kamar }} KT</div>
                                            <div class="text-xs text-slate-400">{{ $room->jumlah_kamar_mandi }} KM •
                                                {{ $room->luas }} m²</div>
                                        </td>

                                        <!-- Tamu -->
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="text-sm text-slate-700">
                                                {{ $room->tamu_dewasa + $room->tamu_anak }} orang</div>
                                            <div class="text-xs text-slate-400">{{ $room->tamu_dewasa }} dewasa •
                                                {{ $room->tamu_anak }} anak</div>
                                        </td>

                                        <!-- Owner -->
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="text-sm text-slate-700">{{ $room->owner_nama }}</div>
                                            <div class="text-xs text-slate-400">{{ $room->owner_wa }}</div>
                                        </td>

                                        <!-- Aksi -->
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="flex items-center justify-end gap-1.5">
                                                <a href="{{ route('admin.apartments.rooms.edit', [$room->id]) }}"
                                                    class="p-2 text-amber-700 bg-amber-50 hover:bg-amber-100 rounded-lg transition-colors"
                                                    title="Edit">
                                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                                </a>
                                                <form action="{{ route('admin.apartments.rooms.destroy', [$room->id]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus room ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-2 text-red-700 bg-red-50 hover:bg-red-100 rounded-lg transition-colors"
                                                        title="Hapus">
                                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-20">
                    <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="building-2" class="w-8 h-8 text-slate-300"></i>
                    </div>
                    <h3 class="text-lg font-medium text-slate-700 mb-1">Belum ada apartemen</h3>
                    <p class="text-sm text-slate-500 mb-6">Mulai tambahkan data apartemen pertama Anda</p>
                    <a href="{{ route('admin.apartments.create') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand text-white text-sm font-medium rounded-xl hover:bg-brand-light transition-colors">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Tambah Apartemen
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection
