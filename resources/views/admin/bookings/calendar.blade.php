@extends('admin.layout')

@section('content')
    <section class="pt-24 pb-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <!-- Header -->
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-slate-800">Jadwal Booking</h1>
                        <p class="text-slate-500 mt-1">Kalender pemesanan apartemen</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.bookings.index') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors text-sm">
                            <i data-lucide="list" class="w-4 h-4"></i>
                            Daftar
                        </a>
                        <button onclick="openNewBookingModal()"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-brand text-white rounded-lg hover:bg-brand-light transition-colors text-sm">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            Booking Baru
                        </button>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm mb-6">
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Filter Apartemen</label>
                        <select id="apartmentFilter"
                            class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm">
                            <option value="">Semua Apartemen</option>
                            @foreach ($apartments as $apt)
                                <option value="{{ $apt->id }}">{{ $apt->judul }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Filter Status</label>
                        <select id="statusFilter"
                            class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2 flex items-end gap-2">
                        <button onclick="filterCalendar()"
                            class="flex-1 bg-brand text-white px-4 py-2 rounded-lg font-medium hover:bg-brand-light transition-colors text-sm">
                            Terapkan Filter
                        </button>
                        <button onclick="resetFilter()"
                            class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg font-medium hover:bg-slate-200 transition-colors text-sm">
                            Reset
                        </button>
                    </div>
                </div>
            </div>

            <!-- Legend -->
            <div class="flex flex-wrap gap-4 mb-4 text-sm">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                    <span class="text-slate-600">Pending</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                    <span class="text-slate-600">Confirmed</span>
                </div>
            </div>

            <!-- Calendar -->
            <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-4">
                <div id="calendar"></div>
            </div>
        </div>
    </section>

    <!-- Booking Detail Modal -->
    <div id="bookingModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/50" onclick="closeModal()"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-xl shadow-xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-4 border-b border-slate-100">
                    <h3 class="text-lg font-semibold text-slate-800">Detail Booking</h3>
                    <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div id="modalContent" class="p-4">
                    <!-- Content will be dynamically inserted -->
                </div>

                <!-- Modal Footer -->
                <div class="flex gap-2 p-4 border-t border-slate-100">
                    <a id="modalDetailLink" href="#"
                        class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-brand text-white rounded-lg hover:bg-brand-light transition-colors text-sm">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                        Lihat Detail
                    </a>
                    <button id="modalStatusBtn" onclick="updateStatusFromModal()"
                        class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors text-sm">
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                        Update Status
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div id="statusModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/50" onclick="closeStatusModal()"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-xl shadow-xl max-w-md w-full">
                <div class="flex items-center justify-between p-4 border-b border-slate-100">
                    <h3 class="text-lg font-semibold text-slate-800">Update Status Booking</h3>
                    <button onclick="closeStatusModal()" class="text-slate-400 hover:text-slate-600">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                <form id="statusForm" class="p-4">
                    @csrf
                    <input type="hidden" id="bookingId" name="booking_id" value="">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Status Baru</label>
                        <select id="newStatus" name="status"
                            class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm">
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="flex gap-2 mt-4">
                        <button type="submit"
                            class="flex-1 bg-brand text-white px-4 py-2 rounded-lg font-medium hover:bg-brand-light transition-colors text-sm">
                            Simpan
                        </button>
                        <button type="button" onclick="closeStatusModal()"
                            class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg font-medium hover:bg-slate-200 transition-colors text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- New Booking Modal -->
    <div id="newBookingModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/50" onclick="closeNewBookingModal()"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between p-4 border-b border-slate-100 sticky top-0 bg-white">
                    <h3 class="text-lg font-semibold text-slate-800">Booking Baru</h3>
                    <button onclick="closeNewBookingModal()" class="text-slate-400 hover:text-slate-600">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                <form id="newBookingForm" class="p-4">
                    @csrf
                    <input type="hidden" name="apartment_id" id="selectedApartmentId" value="">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Apartemen <span
                                    class="text-red-500">*</span></label>
                            <select name="apartment_id_select" id="apartmentSelect" required
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm">
                                <option value="">Pilih Apartemen</option>
                                @foreach ($apartments as $apt)
                                    <option value="{{ $apt->id }}" data-harga="{{ $apt->harga_per_malam }}"
                                        data-kapasitas="{{ $apt->tamu_dewasa + $apt->tamu_anak }}">
                                        {{ $apt->judul }} ({{ $apt->nama_tower }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Status Awal</label>
                            <select name="status" id="initialStatus"
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm">
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Nama Tamu <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama_tamu" required
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                                placeholder="Nama lengkap">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Email <span
                                    class="text-red-500">*</span></label>
                            <input type="email" name="email_tamu" required
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                                placeholder="email@example.com">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">No. WhatsApp <span
                                    class="text-red-500">*</span></label>
                            <input type="tel" name="no_hp" required
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                                placeholder="0812 3456 7890">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Check-in <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="check_in" id="adminCheckIn" required
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Check-out <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="check_out" id="adminCheckOut" required
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Jumlah Tamu <span
                                    class="text-red-500">*</span></label>
                            <select name="jumlah_tamu" id="guestCount" required
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm">
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Catatan</label>
                        <textarea name="catatan" rows="2"
                            class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm resize-none"
                            placeholder="Permintaan khusus..."></textarea>
                    </div>

                    <!-- Price Summary -->
                    <div class="mb-4 p-4 bg-brand/5 rounded-xl border border-brand/10">
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-slate-600">Harga per malam</span>
                            <span class="text-slate-800" id="adminHargaPerMalam">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-slate-600">Jumlah malam</span>
                            <span class="text-slate-800" id="adminJumlahMalam">0 malam</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600 font-medium">Total</span>
                            <span class="text-brand font-semibold" id="adminTotalHarga">Rp 0</span>
                        </div>
                    </div>

                    <!-- Availability Check Result -->
                    <div id="availabilityResult" class="mb-4 hidden">
                        <div class="p-3 rounded-lg text-sm"></div>
                    </div>

                    <div class="flex gap-2">
                        <button type="button" onclick="checkAvailability()"
                            class="px-4 py-2 bg-amber-500 text-white rounded-lg font-medium hover:bg-amber-600 transition-colors text-sm">
                            Cek Ketersediaan
                        </button>
                        <button type="submit" id="submitBooking"
                            class="flex-1 bg-brand text-white px-4 py-2 rounded-lg font-medium hover:bg-brand-light transition-colors text-sm disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled>
                            Simpan Booking
                        </button>
                        <button type="button" onclick="closeNewBookingModal()"
                            class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg font-medium hover:bg-slate-200 transition-colors text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css' rel='stylesheet' />
@endpush

@push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/locales/id.js'></script>
    <script>
        let calendar;
        let currentBooking = null;

        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');

            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                events: function(info, successCallback, failureCallback) {
                    fetch('{{ route('api.bookings.schedule') }}?start=' + info.startStr + '&end=' + info
                            .endStr)
                        .then(response => {
                            if (!response.ok) return response.text().then(t => {
                                throw new Error(t || response.statusText);
                            });
                            return response.json();
                        })
                        .then(data => successCallback(data))
                        .catch(error => {
                            console.error('Failed to load bookings schedule:', error);
                            failureCallback(error);
                        });
                },
                eventClick: function(info) {
                    const props = Object.assign({
                        id: info.event.id,
                        title: info.event.title
                    }, info.event.extendedProps || {});
                    showBookingModal(props);
                },
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: 'short'
                },
                height: 'auto',
                dateClick: function(info) {
                    // Optional: handle date click for creating new booking
                    console.log('Clicked on: ' + info.dateStr);
                }
            });

            calendar.render();
            lucide.createIcons();
        });

        function showBookingModal(props) {
            currentBooking = props;
            const modal = document.getElementById('bookingModal');
            const content = document.getElementById('modalContent');
            const detailLink = document.getElementById('modalDetailLink');

            const statusLabels = {
                'pending': {
                    text: 'Pending',
                    class: 'bg-amber-100 text-amber-700'
                },
                'confirmed': {
                    text: 'Confirmed',
                    class: 'bg-emerald-100 text-emerald-700'
                },
                'completed': {
                    text: 'Completed',
                    class: 'bg-indigo-100 text-indigo-700'
                },
                'cancelled': {
                    text: 'Cancelled',
                    class: 'bg-slate-100 text-slate-600'
                }
            };

            const statusBadge = statusLabels[props.status] || statusLabels['pending'];

            content.innerHTML = `
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-500">Apartemen</span>
                        <span class="font-medium text-slate-800">${props.apartment_name}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-500">Tower</span>
                        <span class="text-slate-800">${props.tower_name || '-'}</span>
                    </div>
                    <div class="border-t border-slate-100 pt-4">
                        <span class="text-sm text-slate-500">Tamu</span>
                        <div class="font-medium text-slate-800">${props.guest_name}</div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-sm text-slate-500">Check-in</span>
                            <div class="text-slate-800">${formatDate(props.check_in)}</div>
                        </div>
                        <div>
                            <span class="text-sm text-slate-500">Check-out</span>
                            <div class="text-slate-800">${formatDate(props.check_out)}</div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-sm text-slate-500">Jumlah Tamu</span>
                            <div class="text-slate-800">${props.guest_count} orang</div>
                        </div>
                        <div>
                            <span class="text-sm text-slate-500">Lama Menginap</span>
                            <div class="text-slate-800">${props.nights} malam</div>
                        </div>
                    </div>
                    <div class="border-t border-slate-100 pt-4">
                        <span class="text-sm text-slate-500">Total Harga</span>
                        <div class="text-lg font-semibold text-brand">Rp ${formatNumber(props.total_price)}</div>
                    </div>
                    <div>
                        <span class="text-sm text-slate-500">Status</span>
                        <div>
                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full capitalize ${statusBadge.class}">
                                ${statusBadge.text}
                            </span>
                        </div>
                    </div>
                    ${props.notes ? `
                                                            <div>
                                                                <span class="text-sm text-slate-500">Catatan</span>
                                                                <div class="text-slate-800 text-sm">${props.notes}</div>
                                                            </div>
                                                            ` : ''}
                </div>
            `;

            detailLink.href = '/admin/bookings/' + props.id;
            modal.classList.remove('hidden');
            lucide.createIcons();
        }

        function closeModal() {
            document.getElementById('bookingModal').classList.add('hidden');
        }

        function updateStatusFromModal() {
            if (currentBooking) {
                document.getElementById('bookingId').value = currentBooking.id;
                document.getElementById('newStatus').value = currentBooking.status;
                document.getElementById('statusModal').classList.remove('hidden');
            }
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
        }

        document.getElementById('statusForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const bookingId = document.getElementById('bookingId').value;
            const newStatus = document.getElementById('newStatus').value;

            fetch('/admin/bookings/' + bookingId + '/status', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        closeStatusModal();
                        closeModal();
                        calendar.refetchEvents();
                        alert('Status berhasil diperbarui!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                });
        });

        function filterCalendar() {
            const apartmentId = document.getElementById('apartmentFilter').value;
            const status = document.getElementById('statusFilter').value;

            calendar.destroy();

            calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                initialView: 'dayGridMonth',
                locale: 'id',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                events: function(info, successCallback, failureCallback) {
                    let url = '{{ route('api.bookings.schedule') }}?start=' + info.startStr + '&end=' + info
                        .endStr;
                    if (apartmentId) url += '&apartment_id=' + apartmentId;
                    if (status) url += '&status=' + status;

                    fetch(url)
                        .then(response => {
                            if (!response.ok) return response.text().then(t => {
                                throw new Error(t || response.statusText);
                            });
                            return response.json();
                        })
                        .then(data => successCallback(data))
                        .catch(error => {
                            console.error('Failed to load filtered bookings schedule:', error);
                            failureCallback(error);
                        });
                },
                eventClick: function(info) {
                    const props = Object.assign({
                        id: info.event.id,
                        title: info.event.title
                    }, info.event.extendedProps || {});
                    showBookingModal(props);
                },
                height: 'auto'
            });

            calendar.render();
            lucide.createIcons();
        }

        function resetFilter() {
            document.getElementById('apartmentFilter').value = '';
            document.getElementById('statusFilter').value = '';
            filterCalendar();
        }

        function formatDate(dateStr) {
            const date = new Date(dateStr);
            return date.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        }

        function formatNumber(num) {
            return new Intl.NumberFormat('id-ID').format(num);
        }

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
                closeStatusModal();
                closeNewBookingModal();
            }
        });

        // New Booking Modal Functions
        function openNewBookingModal() {
            // Reset form
            document.getElementById('newBookingForm').reset();
            document.getElementById('selectedApartmentId').value = '';
            document.getElementById('adminHargaPerMalam').textContent = 'Rp 0';
            document.getElementById('adminJumlahMalam').textContent = '0 malam';
            document.getElementById('adminTotalHarga').textContent = 'Rp 0';
            document.getElementById('guestCount').innerHTML = '';
            document.getElementById('availabilityResult').classList.add('hidden');
            document.getElementById('submitBooking').disabled = true;

            // Set minimum date to today
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('adminCheckIn').min = today;
            document.getElementById('adminCheckOut').min = today;

            document.getElementById('newBookingModal').classList.remove('hidden');
        }

        function closeNewBookingModal() {
            document.getElementById('newBookingModal').classList.add('hidden');
        }

        // Apartment selection - update guest count dropdown
        document.getElementById('apartmentSelect').addEventListener('change', function() {
            const option = this.options[this.selectedIndex];
            const kapasitas = option.dataset.kapasitas || 0;
            const harga = option.dataset.harga || 0;

            document.getElementById('selectedApartmentId').value = this.value;
            document.getElementById('adminHargaPerMalam').textContent = 'Rp ' + formatNumber(harga);

            // Update guest count options
            const guestSelect = document.getElementById('guestCount');
            guestSelect.innerHTML = '';
            for (let i = 1; i <= kapasitas; i++) {
                const opt = document.createElement('option');
                opt.value = i;
                opt.textContent = i + ' Tamu';
                guestSelect.appendChild(opt);
            }

            calculateAdminPrice();
        });

        // Date change handlers
        document.getElementById('adminCheckIn').addEventListener('change', function() {
            const checkInDate = new Date(this.value);
            document.getElementById('adminCheckOut').min = checkInDate.toISOString().split('T')[0];
            calculateAdminPrice();
        });

        document.getElementById('adminCheckOut').addEventListener('change', calculateAdminPrice);

        function calculateAdminPrice() {
            const checkIn = new Date(document.getElementById('adminCheckIn').value);
            const checkOut = new Date(document.getElementById('adminCheckOut').value);
            const option = document.getElementById('apartmentSelect').options[document.getElementById('apartmentSelect')
                .selectedIndex];
            const harga = parseFloat(option.dataset.harga) || 0;

            if (checkIn && checkOut && checkOut > checkIn) {
                const diffDays = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));
                const total = diffDays * harga;

                document.getElementById('adminJumlahMalam').textContent = diffDays + ' malam';
                document.getElementById('adminTotalHarga').textContent = 'Rp ' + formatNumber(total);
            } else {
                document.getElementById('adminJumlahMalam').textContent = '0 malam';
                document.getElementById('adminTotalHarga').textContent = 'Rp 0';
            }
        }

        // Check availability
        function checkAvailability() {
            const apartmentId = document.getElementById('selectedApartmentId').value;
            const checkIn = document.getElementById('adminCheckIn').value;
            const checkOut = document.getElementById('adminCheckOut').value;

            if (!apartmentId || !checkIn || !checkOut) {
                alert('Silakan pilih apartemen dan tanggal terlebih dahulu.');
                return;
            }

            fetch('/api/bookings/availability?apartment_id=' + apartmentId + '&check_in=' + checkIn + '&check_out=' +
                    checkOut)
                .then(response => response.json())
                .then(data => {
                    const resultDiv = document.getElementById('availabilityResult');
                    resultDiv.classList.remove('hidden');

                    if (data.available) {
                        resultDiv.querySelector('div').className =
                            'p-3 rounded-lg text-sm bg-emerald-100 text-emerald-700';
                        resultDiv.querySelector('div').textContent = 'Apartemen tersedia untuk periode tersebut!';
                        document.getElementById('submitBooking').disabled = false;
                    } else {
                        resultDiv.querySelector('div').className = 'p-3 rounded-lg text-sm bg-red-100 text-red-700';
                        resultDiv.querySelector('div').textContent =
                            'Apartemen tidak tersedia! Ada booking yang bentrok: ' +
                            data.conflicts.map(c => c.guest_name + ' (' + c.check_in + ' - ' + c.check_out + ')').join(
                                ', ');
                        document.getElementById('submitBooking').disabled = true;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat pengecekan.');
                });
        }

        // New booking form submission
        document.getElementById('newBookingForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const data = {
                apartment_id: formData.get('apartment_id_select'),
                nama_tamu: formData.get('nama_tamu'),
                email_tamu: formData.get('email_tamu'),
                no_hp: formData.get('no_hp'),
                check_in: formData.get('check_in'),
                check_out: formData.get('check_out'),
                jumlah_tamu: formData.get('jumlah_tamu'),
                catatan: formData.get('catatan'),
                status: formData.get('status'),
            };

            fetch('{{ route('api.bookings.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        alert('Booking berhasil dibuat!');
                        closeNewBookingModal();
                        calendar.refetchEvents();
                        // Optionally redirect to booking detail
                        // window.location.href = '/admin/bookings/' + result.booking_id;
                    } else {
                        alert(result.message || 'Terjadi kesalahan!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                });
        });
    </script>
@endpush
