@extends('admin.layout')

@section('content')
    <section class="pt-24 pb-12 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-brand">Manajemen Users (Admin)</h1>
                    <p class="text-slate-500 mt-1">Buat, update, ganti password, dan hapus akun admin</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.users.create') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand text-white text-sm font-medium rounded-xl hover:bg-brand-light transition-colors shadow-lg shadow-brand/20">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Tambah Admin
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3 text-green-700 animate-fadeIn">
                    <i data-lucide="check-circle" class="w-5 h-5 shrink-0"></i>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div
                    class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3 text-red-700 animate-fadeIn">
                    <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm mb-6">
                <form method="GET" class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-6 gap-4 items-end">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-medium text-slate-500 mb-1">Cari</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau email"
                            class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm">
                    </div>
                    <div>
                        <button type="submit"
                            class="w-full bg-brand text-white px-4 py-2 rounded-lg font-medium hover:bg-brand-light transition-colors text-sm">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-xl border border-slate-100 overflow-hidden shadow-sm">
                @if ($users->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50 border-b border-slate-100">
                                <tr>
                                    <th class="px-4 py-3 text-xs font-medium text-slate-500 uppercase">Nama</th>
                                    <th class="px-4 py-3 text-xs font-medium text-slate-500 uppercase">Email</th>
                                    <th class="px-4 py-3 text-xs font-medium text-slate-500 uppercase">Dibuat</th>
                                    <th class="px-4 py-3 text-xs font-medium text-slate-500 uppercase text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach ($users as $user)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-4 py-3">
                                            <div class="text-sm font-medium text-slate-800">{{ $user->name }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="text-sm text-slate-700">{{ $user->email }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="text-sm text-slate-600">
                                                {{ optional($user->created_at)->format('d M Y') }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                                    class="p-2 text-amber-700 bg-amber-50 hover:bg-amber-100 rounded-lg transition-colors"
                                                    title="Edit">
                                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                                </a>

                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus admin ini?')">
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

                    @if ($users->hasPages())
                        <div class="px-4 py-3 border-t border-slate-100">
                            {{ $users->links('pagination::tailwind') }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="users" class="w-8 h-8 text-slate-300"></i>
                        </div>
                        <h3 class="text-lg font-medium text-slate-700 mb-1">Belum ada admin</h3>
                        <p class="text-sm text-slate-500 mb-6">Mulai tambahkan akun admin pertama Anda</p>
                        <a href="{{ route('admin.users.create') }}"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand text-white text-sm font-medium rounded-xl hover:bg-brand-light transition-colors">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            Tambah Admin
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
