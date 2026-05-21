@extends('admin.layout')

@section('content')
    <section class="pt-24 pb-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <!-- Back -->
            <div class="mb-6">
                <a href="{{ route('admin.inquiries.index') }}"
                    class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-brand transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Kembali ke daftar inquiry
                </a>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm">
                <div class="p-6 border-b border-slate-100">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-mono text-lg text-slate-400">Inquiry</span>
                                <span class="text-xs font-medium text-slate-500">#{{ $inquiry->id }}</span>
                            </div>
                            <h1 class="text-2xl font-serif font-semibold text-slate-800 mt-2">{{ $inquiry->subjek }}</h1>
                            <p class="text-sm text-slate-500 mt-1">
                                {{ $inquiry->apartment->judul ?? 'Tidak ada apartemen dipilih' }}
                        </div>

                        <div class="text-right">
                            @php
                                $statusClasses = [
                                    'baru' => 'bg-amber-100 text-amber-700',
                                    'dibaca' => 'bg-slate-100 text-slate-600',
                                    'dijawab' => 'bg-brand/10 text-brand',
                                    'selesai' => 'bg-emerald-100 text-emerald-700',
                                ];
                            @endphp
                            <span
                                class="inline-flex px-3 py-1 text-xs font-medium rounded-full {{ $statusClasses[$inquiry->status] ?? 'bg-slate-100 text-slate-600' }}">
                                {{ $inquiry->status }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-sm font-medium text-slate-700 mb-4 flex items-center gap-2">
                                <i data-lucide="user" class="w-4 h-4 text-brand"></i>
                                Informasi Pengirim
                            </h3>
                            <div class="space-y-3 text-sm">
                                <div>
                                    <div class="text-xs text-slate-500">Nama</div>
                                    <div class="text-slate-800 font-medium">{{ $inquiry->nama }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-slate-500">Email</div>
                                    <div class="text-slate-800 font-medium">{{ $inquiry->email }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-slate-500">No. HP</div>
                                    <div class="text-slate-800 font-medium">{{ $inquiry->no_hp }}</div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-slate-700 mb-4 flex items-center gap-2">
                                <i data-lucide="message-square" class="w-4 h-4 text-brand"></i>
                                Isi Pesan
                            </h3>
                            <div class="bg-slate-50 rounded-xl border border-slate-100 p-4">
                                <div class="text-sm text-slate-700 whitespace-pre-wrap">{{ $inquiry->pesan }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-sm font-medium text-slate-700 mb-3 flex items-center gap-2">
                            <i data-lucide="settings" class="w-4 h-4 text-brand"></i>
                            Update Status
                        </h3>

                        <form method="POST" action="{{ route('admin.inquiries.updateStatus', $inquiry->id) }}"
                            class="flex flex-wrap gap-3">
                            @csrf
                            @method('PATCH')

                            <button type="submit" name="status" value="baru"
                                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $inquiry->status === 'baru' ? 'bg-amber-500 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                Baru
                            </button>
                            <button type="submit" name="status" value="dibaca"
                                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $inquiry->status === 'dibaca' ? 'bg-slate-500 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                Dibaca
                            </button>
                            <button type="submit" name="status" value="dijawab"
                                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $inquiry->status === 'dijawab' ? 'bg-brand text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                Dijawab
                            </button>
                            <button type="submit" name="status" value="selesai"
                                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $inquiry->status === 'selesai' ? 'bg-emerald-500 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                Selesai
                            </button>
                        </form>

                        <div class="mt-6 pt-6 border-t border-slate-100">
                            <form method="POST" action="{{ route('admin.inquiries.destroy', $inquiry->id) }}"
                                onsubmit="return confirm('Yakin ingin menghapus inquiry ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 rounded-lg text-sm font-medium bg-red-500 text-white hover:bg-red-600 transition-colors flex items-center gap-2">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    Hapus Inquiry
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
