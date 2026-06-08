@extends('admin.layout')

@section('content')
    <section class="pt-24 pb-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <div class="mb-6">
                <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-slate-800">Pengaturan Admin</h1>
                <p class="text-slate-500 mt-1">Atur informasi pembayaran dan kontak admin yang digunakan di notifikasi.</p>
            </div>

            @if (session('success'))
                <div class="mb-4 p-3 bg-emerald-100 text-emerald-800 rounded">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm">
                <form action="{{ route('admin.info.update') }}" method="post">
                    @csrf

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Nama Bank</label>
                            <input type="text" name="bank_name" value="{{ old('bank_name', $info->bank_name ?? '') }}"
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                                placeholder="Contoh: BCA" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Nomor Rekening</label>
                            <input type="text" name="account_number"
                                value="{{ old('account_number', $info->account_number ?? '') }}"
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                                placeholder="1234567890" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Nama Pemilik Rekening</label>
                            <input type="text" name="account_holder"
                                value="{{ old('account_holder', $info->account_holder ?? '') }}"
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                                placeholder="Nama pemilik" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">WhatsApp Admin</label>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp', $info->whatsapp ?? '') }}"
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                                placeholder="+6281234567890" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Email Admin</label>
                            <input type="email" name="email" value="{{ old('email', $info->email ?? '') }}"
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                                placeholder="admin@indoapart.com" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">PPN (%)</label>
                            <input type="number" name="ppn" value="{{ old('ppn', $info->ppn ?? '') }}"
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                                placeholder="10" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Admin Fee (%)</label>
                            <input type="number" name="admin_fee" value="{{ old('admin_fee', $info->admin_fee ?? '') }}"
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                                placeholder="5" />
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="px-4 py-2 bg-brand text-white rounded-lg">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
