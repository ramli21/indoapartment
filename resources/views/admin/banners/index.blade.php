@extends('admin.layout')

@section('content')
    <section class="pt-24 pb-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-slate-800">Manajemen Banner</h1>
                        <p class="text-slate-500 mt-1">Kelola banner di halaman utama</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.help') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 transition-colors text-sm">
                            <i data-lucide="help-circle" class="w-4 h-4"></i>
                            Panduan
                        </a>
                        <a href="{{ route('admin.banners.create') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-brand text-white rounded-lg hover:bg-brand-light transition-colors text-sm">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            Tambah Banner
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
                    <div class="text-2xl font-semibold text-slate-800">{{ \App\Models\Banner::count() }}</div>
                    <div class="text-xs text-slate-500">Total Banner</div>
                </div>
                <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
                    <div class="text-2xl font-semibold text-emerald-500">
                        {{ \App\Models\Banner::where('is_active', true)->count() }}</div>
                    <div class="text-xs text-slate-500">Aktif</div>
                </div>
                <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
                    <div class="text-2xl font-semibold text-amber-500">
                        {{ \App\Models\Banner::where('type', 'hero')->count() }}</div>
                    <div class="text-xs text-slate-500">Hero Banner</div>
                </div>
                <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
                    <div class="text-2xl font-semibold text-brand">{{ \App\Models\Banner::where('type', 'promo')->count() }}
                    </div>
                    <div class="text-xs text-slate-500">Promo Banner</div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm mb-6">
                <form method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Cari</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul..."
                            class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Tipe Banner</label>
                        <select name="type"
                            class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm">
                            <option value="">Semua Tipe</option>
                            <option value="hero" {{ request('type') == 'hero' ? 'selected' : '' }}>Hero Banner</option>
                            <option value="promo" {{ request('type') == 'promo' ? 'selected' : '' }}>Promo Banner</option>
                            <option value="promo_small" {{ request('type') == 'promo_small' ? 'selected' : '' }}>Promo Small
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Status</label>
                        <select name="status"
                            class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif
                            </option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                            class="w-full bg-brand text-white px-4 py-2 rounded-lg font-medium hover:bg-brand-light transition-colors text-sm">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Banners Table -->
            <div class="bg-white rounded-xl border border-slate-100 overflow-hidden shadow-sm">
                @if ($banners->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-100">
                                <tr>
                                    <th class="text-left px-4 py-3 text-xs font-medium text-slate-500 uppercase">Gambar</th>
                                    <th class="text-left px-4 py-3 text-xs font-medium text-slate-500 uppercase">Judul</th>
                                    <th class="text-left px-4 py-3 text-xs font-medium text-slate-500 uppercase">Tipe</th>
                                    <th class="text-left px-4 py-3 text-xs font-medium text-slate-500 uppercase">Urutan</th>
                                    <th class="text-left px-4 py-3 text-xs font-medium text-slate-500 uppercase">Status</th>
                                    <th class="text-left px-4 py-3 text-xs font-medium text-slate-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach ($banners as $banner)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-4 py-3">
                                            <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}"
                                                class="w-20 h-14 object-cover rounded-lg">
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="text-sm font-medium text-slate-800">
                                                {{ $banner->title ?? '-' }}</div>
                                            <div class="text-xs text-slate-400">{{ $banner->subtitle ?? '-' }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            @php
                                                $typeLabels = [
                                                    'hero' => 'Hero Banner',
                                                    'promo' => 'Promo Banner',
                                                    'promo_small' => 'Promo Small',
                                                ];
                                            @endphp
                                            <span class="text-sm text-slate-600">
                                                {{ $typeLabels[$banner->type] ?? $banner->type }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="text-sm text-slate-600">{{ $banner->order }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            @if ($banner->is_active)
                                                <span
                                                    class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700">
                                                    Aktif
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full bg-slate-100 text-slate-600">
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-1">
                                                <a href="{{ route('admin.banners.edit', $banner->id) }}"
                                                    class="p-2 text-slate-400 hover:text-brand hover:bg-brand/10 rounded-lg transition-colors">
                                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                                </a>
                                                <form method="POST"
                                                    action="{{ route('admin.banners.destroy', $banner->id) }}"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                                        onclick="return confirm('Yakin ingin menghapus banner ini?')">
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

                    <!-- Pagination -->
                    @if ($banners->hasPages())
                        <div class="px-4 py-3 border-t border-slate-100">
                            {{ $banners->links('pagination::tailwind') }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="image" class="w-8 h-8 text-slate-300"></i>
                        </div>
                        <h3 class="text-lg font-medium text-slate-700 mb-1">Belum ada banner</h3>
                        <p class="text-sm text-slate-500">Tambahkan banner pertama Anda</p>
                        <a href="{{ route('admin.banners.create') }}"
                            class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-brand text-white rounded-lg hover:bg-brand-light transition-colors text-sm">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            Tambah Banner
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
