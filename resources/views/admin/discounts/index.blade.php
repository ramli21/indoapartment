@extends('admin.layout')

@section('content')
<div class="py-6" x-data="{ activeTab: 'global' }">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 font-serif">Kelola Diskon & Voucher</h1>
            <p class="text-sm text-slate-500">Atur program diskon global, diskon unit kamar, dan kode voucher belanja.</p>
        </div>
    </div>

    <!-- Alert Success / Error -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-3">
            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600 shrink-0"></i>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl">
            <div class="flex items-center gap-3 mb-2">
                <i data-lucide="alert-circle" class="w-5 h-5 text-rose-600 shrink-0"></i>
                <span class="text-sm font-semibold">Terjadi kesalahan validasi:</span>
            </div>
            <ul class="list-disc list-inside text-xs space-y-1 ml-8">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Navigation Tabs -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-2 flex gap-2 mb-6">
        <button onclick="switchTab('global')" id="tab-global-btn"
            class="flex-1 py-3 px-4 rounded-xl text-sm font-semibold transition-all flex items-center justify-center gap-2 bg-brand text-white shadow-sm">
            <i data-lucide="globe" class="w-4 h-4"></i>
            Diskon Global
        </button>
        <button onclick="switchTab('unit')" id="tab-unit-btn"
            class="flex-1 py-3 px-4 rounded-xl text-sm font-semibold transition-all flex items-center justify-center gap-2 text-slate-600 hover:bg-slate-50">
            <i data-lucide="building" class="w-4 h-4"></i>
            Diskon Per Unit
        </button>
        <button onclick="switchTab('voucher')" id="tab-voucher-btn"
            class="flex-1 py-3 px-4 rounded-xl text-sm font-semibold transition-all flex items-center justify-center gap-2 text-slate-600 hover:bg-slate-50">
            <i data-lucide="ticket" class="w-4 h-4"></i>
            Voucher Belanja
        </button>
    </div>

    <!-- ==================== TAB 1: DISKON GLOBAL ==================== -->
    <div id="tab-global" class="tab-content block">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-800">Daftar Diskon Global</h3>
                <button onclick="openDiscountModal(null, 'global')" 
                    class="bg-brand text-white hover:bg-brand-light py-2 px-4 rounded-xl text-sm font-semibold inline-flex items-center gap-2 transition-colors">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Tambah Diskon Global
                </button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase border-b border-slate-100">
                            <th class="py-4 px-6">Nama Promo</th>
                            <th class="py-4 px-6">Potongan</th>
                            <th class="py-4 px-6">Masa Berlaku</th>
                            <th class="py-4 px-6">Status</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse($globalDiscounts as $discount)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="font-semibold text-slate-800">{{ $discount->name }}</div>
                                    <div class="text-xs text-slate-400">ID: #{{ $discount->id }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    @if($discount->type === 'percentage')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                            {{ floatval($discount->value) }}%
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                            Rp {{ number_format($discount->value, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <div class="text-slate-600 text-xs">Mulai: {{ $discount->start_date->format('d M Y H:i') }}</div>
                                    <div class="text-slate-600 text-xs">Selesai: {{ $discount->end_date->format('d M Y H:i') }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    @if($discount->is_active && $discount->end_date->isFuture())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Aktif</span>
                                    @elseif(!$discount->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">Nonaktif</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800">Kadaluwarsa</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick="openDiscountModal({{ json_encode($discount) }}, 'global')"
                                            class="p-2 text-slate-500 hover:text-brand hover:bg-slate-100 rounded-lg transition-colors" title="Edit">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </button>
                                        <form action="{{ route('admin.discounts.destroyDiscount', $discount->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus diskon global ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-500 hover:text-rose-600 hover:bg-slate-100 rounded-lg transition-colors" title="Hapus">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400">Belum ada data diskon global.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ==================== TAB 2: DISKON PER UNIT ==================== -->
    <div id="tab-unit" class="tab-content hidden">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-800">Daftar Diskon Per Unit Kamar</h3>
                <button onclick="openDiscountModal(null, 'unit')" 
                    class="bg-brand text-white hover:bg-brand-light py-2 px-4 rounded-xl text-sm font-semibold inline-flex items-center gap-2 transition-colors">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Tambah Diskon Unit
                </button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase border-b border-slate-100">
                            <th class="py-4 px-6">Kamar / Unit</th>
                            <th class="py-4 px-6">Nama Promo</th>
                            <th class="py-4 px-6">Potongan</th>
                            <th class="py-4 px-6">Masa Berlaku</th>
                            <th class="py-4 px-6">Status</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse($unitDiscounts as $discount)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 px-6">
                                    @if($discount->room)
                                        <div class="font-semibold text-slate-800">{{ $discount->room->judul }}</div>
                                        <div class="text-xs text-slate-400">Harga: Rp {{ number_format($discount->room->harga_per_malam, 0, ',', '.') }}/malam</div>
                                    @else
                                        <div class="text-rose-500 italic">Kamar Terhapus</div>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-medium text-slate-700">{{ $discount->name }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    @if($discount->type === 'percentage')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                            {{ floatval($discount->value) }}%
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                            Rp {{ number_format($discount->value, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <div class="text-slate-600 text-xs">Mulai: {{ $discount->start_date->format('d M Y H:i') }}</div>
                                    <div class="text-slate-600 text-xs">Selesai: {{ $discount->end_date->format('d M Y H:i') }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    @if($discount->is_active && $discount->end_date->isFuture())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Aktif</span>
                                    @elseif(!$discount->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">Nonaktif</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800">Kadaluwarsa</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick="openDiscountModal({{ json_encode($discount) }}, 'unit')"
                                            class="p-2 text-slate-500 hover:text-brand hover:bg-slate-100 rounded-lg transition-colors" title="Edit">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </button>
                                        <form action="{{ route('admin.discounts.destroyDiscount', $discount->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus diskon unit ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-500 hover:text-rose-600 hover:bg-slate-100 rounded-lg transition-colors" title="Hapus">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400">Belum ada data diskon per unit.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ==================== TAB 3: VOUCHER BELANJA ==================== -->
    <div id="tab-voucher" class="tab-content hidden">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-800">Daftar Voucher Belanja</h3>
                <button onclick="openVoucherModal(null)" 
                    class="bg-brand text-white hover:bg-brand-light py-2 px-4 rounded-xl text-sm font-semibold inline-flex items-center gap-2 transition-colors">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Buat Voucher Baru
                </button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase border-b border-slate-100">
                            <th class="py-4 px-6">Kode Voucher</th>
                            <th class="py-4 px-6">Potongan</th>
                            <th class="py-4 px-6">Syarat & Batasan</th>
                            <th class="py-4 px-6">Penggunaan</th>
                            <th class="py-4 px-6">Status</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse($vouchers as $voucher)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="font-mono text-base font-bold text-slate-800 bg-slate-100 border border-slate-200 py-1 px-3 rounded-lg inline-block select-all">{{ $voucher->code }}</div>
                                    <div class="text-xs text-slate-500 mt-1 font-medium">{{ $voucher->name }}</div>
                                </td>
                                <td class="py-4 px-6 font-semibold">
                                    @if($voucher->type === 'percentage')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                            {{ floatval($voucher->value) }}%
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                            Rp {{ number_format($voucher->value, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-xs space-y-1">
                                    <div>Min. Transaksi: <span class="font-semibold text-slate-800">Rp {{ number_format($voucher->min_booking_amount, 0, ',', '.') }}</span></div>
                                    <div>Berlaku Mulai: {{ $voucher->start_date->format('d M Y H:i') }}</div>
                                    <div>Berlaku Selesai: {{ $voucher->end_date->format('d M Y H:i') }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="text-sm font-semibold text-slate-800">{{ $voucher->used_count }} / {{ $voucher->max_uses ?? '∞' }}</div>
                                    <div class="w-20 bg-slate-100 rounded-full h-1.5 mt-1 overflow-hidden">
                                        @if($voucher->max_uses)
                                            @php $percentage = min(100, ($voucher->used_count / $voucher->max_uses) * 100); @endphp
                                            <div class="bg-brand h-full rounded-full" style="width: {{ $percentage }}%"></div>
                                        @else
                                            <div class="bg-brand h-full rounded-full" style="width: 10%"></div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    @if($voucher->is_active && $voucher->end_date->isFuture() && ($voucher->max_uses === null || $voucher->used_count < $voucher->max_uses))
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Aktif</span>
                                    @elseif(!$voucher->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">Nonaktif</span>
                                    @elseif($voucher->max_uses !== null && $voucher->used_count >= $voucher->max_uses)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">Kuota Habis</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800">Kadaluwarsa</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick="openVoucherModal({{ json_encode($voucher) }})"
                                            class="p-2 text-slate-500 hover:text-brand hover:bg-slate-100 rounded-lg transition-colors" title="Edit">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </button>
                                        <form action="{{ route('admin.vouchers.destroyVoucher', $voucher->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus voucher ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-500 hover:text-rose-600 hover:bg-slate-100 rounded-lg transition-colors" title="Hapus">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400">Belum ada data voucher belanja.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ==================== MODAL DISKON (GLOBAL & UNIT) ==================== -->
<div id="discountModal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl relative overflow-hidden transform scale-95 opacity-0 transition-all duration-200" id="discountModalContent">
        <div class="p-6 bg-brand text-white flex items-center justify-between">
            <h3 class="font-bold text-lg font-serif" id="discountModalTitle">Tambah Diskon</h3>
            <button onclick="closeDiscountModal()" class="p-1 hover:bg-white/10 rounded-full transition-colors">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        
        <form id="discountForm" method="POST" action="" class="p-6 space-y-4">
            @csrf
            <input type="hidden" name="_method" id="discountFormMethod" value="POST">
            <input type="hidden" name="room_id" id="discountFormRoomId" value="">

            <!-- Nama Diskon -->
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Program Diskon</label>
                <input type="text" name="name" id="discount_name" required placeholder="Contoh: Promo Weekend, Diskon Awal Tahun"
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand focus:bg-white transition-colors">
            </div>

            <!-- Unit Kamar (Jika diskon unit) -->
            <div id="discountRoomSelectGroup" class="hidden">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Kamar / Unit</label>
                <select name="room_id_select" id="discount_room_id" onchange="syncRoomId(this.value)"
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand focus:bg-white transition-colors">
                    <option value="">-- Pilih Kamar --</option>
                    @foreach($rooms as $r)
                        <option value="{{ $r->id }}">
                            {{ $r->judul }} (Rp {{ number_format($r->harga_per_malam, 0, ',', '.') }}/malam)
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tipe Diskon & Nilai -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tipe Potongan</label>
                    <select name="type" id="discount_type" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand focus:bg-white transition-colors">
                        <option value="percentage">Persentase (%)</option>
                        <option value="fixed">Nominal Tetap (Rupiah)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nilai Potongan</label>
                    <input type="number" step="any" name="value" id="discount_value" required placeholder="Contoh: 10 atau 100000"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand focus:bg-white transition-colors">
                </div>
            </div>

            <!-- Masa Berlaku -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Mulai</label>
                    <input type="datetime-local" name="start_date" id="discount_start_date" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand focus:bg-white transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Selesai</label>
                    <input type="datetime-local" name="end_date" id="discount_end_date" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand focus:bg-white transition-colors">
                </div>
            </div>

            <!-- Status Aktif -->
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status Keaktifan</label>
                <select name="is_active" id="discount_is_active" required
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand focus:bg-white transition-colors">
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeDiscountModal()"
                    class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors">
                    Batal
                </button>
                <button type="submit"
                    class="bg-brand hover:bg-brand-light text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-sm transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ==================== MODAL VOUCHER ==================== -->
<div id="voucherModal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl relative overflow-hidden transform scale-95 opacity-0 transition-all duration-200" id="voucherModalContent">
        <div class="p-6 bg-brand text-white flex items-center justify-between">
            <h3 class="font-bold text-lg font-serif" id="voucherModalTitle">Tambah Voucher</h3>
            <button onclick="closeVoucherModal()" class="p-1 hover:bg-white/10 rounded-full transition-colors">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        
        <form id="voucherForm" method="POST" action="" class="p-6 space-y-4">
            @csrf
            <input type="hidden" name="_method" id="voucherFormMethod" value="POST">

            <!-- Kode Voucher & Nama -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kode Voucher</label>
                    <input type="text" name="code" id="voucher_code" required placeholder="Contoh: PROMOHEBAT"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-mono focus:outline-none focus:border-brand focus:bg-white transition-colors uppercase">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Voucher</label>
                    <input type="text" name="name" id="voucher_name" required placeholder="Contoh: Diskon 20k, Hemat 5%"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand focus:bg-white transition-colors">
                </div>
            </div>

            <!-- Tipe Diskon & Nilai -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tipe Potongan</label>
                    <select name="type" id="voucher_type" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand focus:bg-white transition-colors">
                        <option value="percentage">Persentase (%)</option>
                        <option value="fixed">Nominal Tetap (Rupiah)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nilai Potongan</label>
                    <input type="number" step="any" name="value" id="voucher_value" required placeholder="Contoh: 10 atau 50000"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand focus:bg-white transition-colors">
                </div>
            </div>

            <!-- Syarat & Kuota -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Min. Transaksi (Rp)</label>
                    <input type="number" step="any" name="min_booking_amount" id="voucher_min_booking_amount" required placeholder="0"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand focus:bg-white transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kuota Penggunaan</label>
                    <input type="number" name="max_uses" id="voucher_max_uses" placeholder="Kosongkan jika unlimited"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand focus:bg-white transition-colors">
                </div>
            </div>

            <!-- Masa Berlaku -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Mulai</label>
                    <input type="datetime-local" name="start_date" id="voucher_start_date" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand focus:bg-white transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Selesai</label>
                    <input type="datetime-local" name="end_date" id="voucher_end_date" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand focus:bg-white transition-colors">
                </div>
            </div>

            <!-- Status Aktif -->
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status Keaktifan</label>
                <select name="is_active" id="voucher_is_active" required
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand focus:bg-white transition-colors">
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeVoucherModal()"
                    class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors">
                    Batal
                </button>
                <button type="submit"
                    class="bg-brand hover:bg-brand-light text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-sm transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Tab switching logic
    function switchTab(tabId) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.replace('block', 'hidden'));
        document.getElementById('tab-' + tabId).classList.replace('hidden', 'block');

        // Button styles
        ['global', 'unit', 'voucher'].forEach(id => {
            const btn = document.getElementById('tab-' + id + '-btn');
            if (id === tabId) {
                btn.className = "flex-1 py-3 px-4 rounded-xl text-sm font-semibold transition-all flex items-center justify-center gap-2 bg-brand text-white shadow-sm";
            } else {
                btn.className = "flex-1 py-3 px-4 rounded-xl text-sm font-semibold transition-all flex items-center justify-center gap-2 text-slate-600 hover:bg-slate-50";
            }
        });
    }

    // sync helper for room_id input
    function syncRoomId(val) {
        document.getElementById('discountFormRoomId').value = val;
    }

    // Format Date helper to populate datetime-local input fields (YYYY-MM-DDTHH:MM)
    function formatDateToInput(dateString) {
        if (!dateString) return '';
        const d = new Date(dateString);
        const pad = (n) => n.toString().padStart(2, '0');
        const yyyy = d.getFullYear();
        const mm = pad(d.getMonth() + 1);
        const dd = pad(d.getDate());
        const hh = pad(d.getHours());
        const min = pad(d.getMinutes());
        return `${yyyy}-${mm}-${dd}T${hh}:${min}`;
    }

    // Modal Discount opening/closing logic
    function openDiscountModal(discountData = null, context = 'global') {
        const modal = document.getElementById('discountModal');
        const content = document.getElementById('discountModalContent');
        
        modal.classList.replace('hidden', 'flex');
        setTimeout(() => {
            content.classList.replace('scale-95', 'scale-100');
            content.classList.replace('opacity-0', 'opacity-100');
        }, 10);

        const form = document.getElementById('discountForm');
        const formMethod = document.getElementById('discountFormMethod');
        const titleEl = document.getElementById('discountModalTitle');
        const roomSelectGroup = document.getElementById('discountRoomSelectGroup');
        const roomIdInput = document.getElementById('discountFormRoomId');
        
        if (context === 'unit') {
            roomSelectGroup.classList.remove('hidden');
            document.getElementById('discount_room_id').setAttribute('required', 'true');
        } else {
            roomSelectGroup.classList.add('hidden');
            document.getElementById('discount_room_id').removeAttribute('required');
            roomIdInput.value = '';
        }

        if (discountData) {
            // Edit mode
            titleEl.textContent = context === 'unit' ? 'Edit Diskon Unit' : 'Edit Diskon Global';
            form.action = `/admin/discounts/${discountData.id}`;
            formMethod.value = 'PUT';
            
            document.getElementById('discount_name').value = discountData.name;
            document.getElementById('discount_type').value = discountData.type;
            document.getElementById('discount_value').value = parseFloat(discountData.value);
            document.getElementById('discount_start_date').value = formatDateToInput(discountData.start_date);
            document.getElementById('discount_end_date').value = formatDateToInput(discountData.end_date);
            document.getElementById('discount_is_active').value = discountData.is_active ? "1" : "0";

            if (context === 'unit' && discountData.room_id) {
                document.getElementById('discount_room_id').value = discountData.room_id;
                roomIdInput.value = discountData.room_id;
            }
        } else {
            // Create mode
            titleEl.textContent = context === 'unit' ? 'Tambah Diskon Unit' : 'Tambah Diskon Global';
            form.action = "{{ route('admin.discounts.storeDiscount') }}";
            formMethod.value = 'POST';
            
            form.reset();
            roomIdInput.value = '';
            document.getElementById('discount_is_active').value = "1";
            document.getElementById('discount_type').value = "percentage";
        }
        
        // Reinitialize Lucide icons in modal
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    function closeDiscountModal() {
        const modal = document.getElementById('discountModal');
        const content = document.getElementById('discountModalContent');
        
        content.classList.replace('scale-100', 'scale-95');
        content.classList.replace('opacity-100', 'opacity-0');
        setTimeout(() => {
            modal.classList.replace('flex', 'hidden');
        }, 150);
    }

    // Modal Voucher opening/closing logic
    function openVoucherModal(voucherData = null) {
        const modal = document.getElementById('voucherModal');
        const content = document.getElementById('voucherModalContent');
        
        modal.classList.replace('hidden', 'flex');
        setTimeout(() => {
            content.classList.replace('scale-95', 'scale-100');
            content.classList.replace('opacity-0', 'opacity-100');
        }, 10);

        const form = document.getElementById('voucherForm');
        const formMethod = document.getElementById('voucherFormMethod');
        const titleEl = document.getElementById('voucherModalTitle');

        if (voucherData) {
            // Edit mode
            titleEl.textContent = 'Edit Voucher';
            form.action = `/admin/vouchers/${voucherData.id}`;
            formMethod.value = 'PUT';
            
            document.getElementById('voucher_code').value = voucherData.code;
            document.getElementById('voucher_name').value = voucherData.name;
            document.getElementById('voucher_type').value = voucherData.type;
            document.getElementById('voucher_value').value = parseFloat(voucherData.value);
            document.getElementById('voucher_min_booking_amount').value = parseFloat(voucherData.min_booking_amount);
            document.getElementById('voucher_max_uses').value = voucherData.max_uses || '';
            document.getElementById('voucher_start_date').value = formatDateToInput(voucherData.start_date);
            document.getElementById('voucher_end_date').value = formatDateToInput(voucherData.end_date);
            document.getElementById('voucher_is_active').value = voucherData.is_active ? "1" : "0";
        } else {
            // Create mode
            titleEl.textContent = 'Tambah Voucher Baru';
            form.action = "{{ route('admin.vouchers.storeVoucher') }}";
            formMethod.value = 'POST';
            
            form.reset();
            document.getElementById('voucher_is_active').value = "1";
            document.getElementById('voucher_type').value = "percentage";
        }
        
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    function closeVoucherModal() {
        const modal = document.getElementById('voucherModal');
        const content = document.getElementById('voucherModalContent');
        
        content.classList.replace('scale-100', 'scale-95');
        content.classList.replace('opacity-100', 'opacity-0');
        setTimeout(() => {
            modal.classList.replace('flex', 'hidden');
        }, 150);
    }
</script>
@endsection
