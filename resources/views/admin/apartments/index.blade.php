@extends('admin.layout')

@section('content')
    <section class="py-8 md:py-10 min-h-screen">
        <div class="max-w-7xl mx-auto md:px-4">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-brand">Daftar Apartemen</h1>
                    <p class="text-slate-500 mt-1">Kelola data apartemen Anda</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.help') }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-100 text-slate-600 text-sm font-medium rounded-xl hover:bg-slate-200 transition-colors">
                        <i data-lucide="help-circle" class="w-4 h-4"></i>
                        Panduan
                    </a>
                    <a href="{{ route('admin.apartments.create') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand text-white text-sm font-medium rounded-xl hover:bg-brand-light transition-colors shadow-lg shadow-brand/20">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Tambah Apartemen
                    </a>
                </div>
            </div>

            <!-- Alert -->
            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3 text-green-700 animate-fadeIn">
                    <i data-lucide="check-circle" class="w-5 h-5 shrink-0"></i>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif


            <!-- Table -->
            @if ($apartments->count() > 0)
                <div class="bg-white rounded-lg border border-slate-100 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto -mx-4 sm:mx-0">
                        <table class="min-w-[760px] w-full text-left table-auto">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-100">
                                    <th
                                        class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider whitespace-nowrap">
                                        Gambar</th>
                                    <th
                                        class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider whitespace-nowrap">
                                        Apartemen</th>
                                    <th
                                        class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider whitespace-nowrap">
                                        Alamat</th>
                                    <th
                                        class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider whitespace-nowrap">
                                        Jumlah Room</th>
                                    <th
                                        class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right whitespace-nowrap">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($apartments as $apartment)
                                    <tr class="hover:bg-slate-50/50 transition-colors group">
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="w-16 h-12 rounded-lg overflow-hidden bg-slate-100">
                                                @php
                                                    $imgs = $apartment->gambar ? $apartment->gambar : '-';
                                                @endphp
                                                @if (!empty($imgs))
                                                    <img src="{{ asset('storage/' . $imgs) }}"
                                                        alt="{{ $apartment->nama ?? ($apartment->judul ?? '') }}"
                                                        class="w-full h-full object-cover" />
                                                @else
                                                    <div
                                                        class="w-full h-full flex items-center justify-center text-slate-300">
                                                        <i data-lucide="image-off" class="w-4 h-4"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="font-medium text-slate-800 text-sm">
                                                {{ $apartment->nama ?? $apartment->judul }}</div>
                                        </td>

                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="text-sm text-slate-700">{{ $apartment->alamat }}</div>
                                        </td>

                                        <td class="px-5 py-4 whitespace-nowrap">
                                            @php
                                                $total_room = $apartment->rooms->count();
                                            @endphp
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 {{ $total_room > 0 ? 'text-emerald-700 bg-emerald-50' : 'text-slate-500 bg-red-100' }}">
                                                {{ $total_room }} Room
                                            </span>
                                        </td>

                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="flex items-center justify-end gap-1.5">
                                                <a href="{{ route('admin.apartments.rooms.index', $apartment) }}"
                                                    class="p-2 text-brand bg-brand/5 hover:bg-brand/10 rounded-lg transition-colors"
                                                    title="Detail">
                                                    <i data-lucide="building" class="w-4 h-4"></i>
                                                </a>
                                                <a href="{{ route('admin.apartments.edit', $apartment) }}"
                                                    class="p-2 text-amber-700 bg-amber-50 hover:bg-amber-100 rounded-lg transition-colors"
                                                    title="Edit">
                                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                                </a>
                                                <form action="{{ route('admin.apartments.destroy', $apartment) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus apartemen ini?')">
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
