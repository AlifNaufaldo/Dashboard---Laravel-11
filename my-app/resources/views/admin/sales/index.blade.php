@extends('layouts.admin')

@section('title', 'Daftar Transaksi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Transaksi</h1>

    <!-- Notifikasi -->
    @if (session('success'))
        <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Transaksi -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full border border-gray-200">
            <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                <tr>
                    <th class="px-4 py-3 text-left border-b">#</th>
                    <th class="px-4 py-3 text-left border-b">Kasir</th>
                    <th class="px-4 py-3 text-left border-b">Total</th>
                    <th class="px-4 py-3 text-left border-b">Tanggal</th>
                    <th class="px-4 py-3 text-center border-b">Status</th>
                    <th class="px-4 py-3 text-center border-b">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach ($sales as $sale)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3">{{ $sale->user->name }}</td>
                        <td class="px-4 py-3 font-semibold">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-3">{{ $sale->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                {{ $sale->status === 'pending' ? 'bg-yellow-100 text-yellow-600' : 
                                ($sale->status === 'completed' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600') }}">
                                {{ ucfirst($sale->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center space-x-2">
                            <button onclick="showDetail({{ $sale->id }})" 
                                class="bg-blue-500 text-white px-3 py-1 text-sm rounded-md hover:bg-blue-600 transition">
                                Detail
                            </button>
                            <button onclick="showEditModal({{ $sale->id }})" 
                                class="bg-yellow-500 text-white px-3 py-1 text-sm rounded-md hover:bg-yellow-600 transition">
                                Update
                            </button>
                            <form action="{{ route('admin.sales.destroy', $sale->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 text-sm rounded-md hover:bg-red-600 transition"
                                    onclick="return confirm('Hapus transaksi ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<!-- Modal Detail -->
<div id="modalDetail" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center z-50 transition-opacity">
    <div class="bg-white p-6 rounded-lg w-full max-w-md shadow-lg transform scale-95 transition-transform">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2">Detail Transaksi</h2>
        
        <div class="space-y-2 text-gray-700">
            <p><strong>Kasir:</strong> <span id="detailUser" class="font-medium"></span></p>
            <p><strong>Nama Pembeli:</strong> <span id="detailCustomer" class="font-medium"></span></p>
            <p><strong>Nomor HP:</strong> <span id="detailPhone" class="font-medium"></span></p>
            <p><strong>Total:</strong> Rp <span id="detailTotal" class="font-medium text-blue-600"></span></p>
            <p><strong>Tanggal:</strong> <span id="detailDate" class="font-medium"></span></p>
            <p><strong>Status:</strong> 
                <span id="detailStatus" class="font-medium px-2 py-1 text-sm rounded-md"></span>
            </p>
        </div>

        <button id="closeModalDetail" class="mt-4 w-full bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition"
            onclick="closeModal('modalDetail')">
            Tutup
        </button>
    </div>
</div>

<script>
    function showDetailModal(user, customer, phone, total, date, status) {
        document.getElementById("detailUser").innerText = user;
        document.getElementById("detailCustomer").innerText = customer;
        document.getElementById("detailPhone").innerText = phone;
        document.getElementById("detailTotal").innerText = new Intl.NumberFormat('id-ID').format(total);
        document.getElementById("detailDate").innerText = date;

        // Warna status berdasarkan kondisi
        const statusElement = document.getElementById("detailStatus");
        statusElement.innerText = status.charAt(0).toUpperCase() + status.slice(1);
        statusElement.className = "font-medium px-2 py-1 text-sm rounded-md " + 
            (status === 'pending' ? 'bg-yellow-100 text-yellow-600' : 
            (status === 'completed' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600'));

        // Tampilkan modal dengan animasi
        const modal = document.getElementById("modalDetail");
        modal.classList.remove("hidden");
        modal.children[0].classList.remove("scale-95");
        modal.children[0].classList.add("scale-100");
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.children[0].classList.remove("scale-100");
        modal.children[0].classList.add("scale-95");
        setTimeout(() => modal.classList.add("hidden"), 200);
    }
</script>



<!-- Modal Edit -->
<div id="modalEdit" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg w-96">
        <h2 class="text-lg font-bold mb-2">Edit Transaksi</h2>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Nama Pembeli:</label>
                <input type="text" id="editCustomerName" name="customer_name" class="w-full border rounded px-3 py-2">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Nomor HP:</label>
                <input type="text" id="editPhone" name="phone" class="w-full border rounded px-3 py-2">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Total Pembelian:</label>
                <input type="number" id="editTotalAmount" name="total_amount" class="w-full border rounded px-3 py-2">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Metode Pembayaran:</label>
                <select id="editPaymentMethod" name="payment_method" class="w-full border rounded px-3 py-2">
                    <option value="cash">Cash</option>
                    <option value="credit">Credit</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Status:</label>
                <select id="editStatus" name="status" class="w-full border rounded px-3 py-2">
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                    <option value="canceled">Canceled</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Catatan:</label>
                <textarea id="editNotes" name="notes" class="w-full border rounded px-3 py-2"></textarea>
            </div>

            <div class="mt-6">
                <button type="button" onclick="updateTransaction()" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Simpan</button>
                <button type="button" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded" onclick="closeModal('modalEdit')">Tutup</button>
            </div>
        </form>
    </div>
</div>

<script>
    function showDetail(id) {
        fetch(`/admin/sales/${id}`)
            .then(response => response.json())
            .then(data => {
                if (!data.user || !data.customer) {
                    alert("Data transaksi tidak valid!");
                    return;
                }

                document.getElementById('detailUser').textContent = data.user.name;
                document.getElementById('detailCustomer').textContent = data.customer.name || 'Tidak Ada';
                document.getElementById('detailPhone').textContent = data.customer.phone || 'Tidak Ada';
                document.getElementById('detailTotal').textContent = new Intl.NumberFormat('id-ID').format(data.total_amount);
                document.getElementById('detailDate').textContent = new Date(data.created_at).toLocaleString();
                document.getElementById('detailStatus').textContent = data.status;

                openModal('modalDetail'); 
            })
            .catch(error => console.error("Error fetching details:", error));
    }

    let currentSaleId = null;
    
    function showEditModal(id) {
        currentSaleId = id;
        
        fetch(`/admin/sales/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                console.log("Data untuk diedit:", data); 

                if (!data || !data.customer) {
                    console.error("Invalid response data");
                    return;
                }

                document.getElementById('editCustomerName').value = data.customer.name || '';
                document.getElementById('editPhone').value = data.customer.phone || '';
                document.getElementById('editTotalAmount').value = data.total_amount;
                document.getElementById('editPaymentMethod').value = data.payment_method;
                document.getElementById('editStatus').value = data.status;
                document.getElementById('editNotes').value = data.notes || '';

                openModal('modalEdit'); 
            })
            .catch(error => console.error("Error fetching transaction details:", error));
    }

    function fetchTransactions() {
        fetch('/admin/sales')
            .then(response => response.json())
            .then(data => {
                let tableBody = document.querySelector("tbody");
                tableBody.innerHTML = ""; // Kosongkan tabel sebelum mengisi ulang

                data.forEach((sale, index) => {
                    let row = `
                        <tr class="border-b">
                            <td class="px-4 py-2">${index + 1}</td>
                            <td class="px-4 py-2">${sale.user.name}</td>
                            <td class="px-4 py-2">Rp ${new Intl.NumberFormat('id-ID').format(sale.total_amount)}</td>
                            <td class="px-4 py-2">${new Date(sale.created_at).toLocaleString()}</td>
                            <td class="px-4 py-2 text-status">
                                <span class="font-semibold ${sale.status === 'pending' ? 'text-yellow-600' : (sale.status === 'completed' ? 'text-green-600' : 'text-red-600')}">
                                    ${sale.status.charAt(0).toUpperCase() + sale.status.slice(1)}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <button onclick="showDetail(${sale.id})" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Detail</button>
                                <button onclick="showEditModal(${sale.id})" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Update</button>
                                <form action="/admin/sales/${sale.id}" method="POST" class="inline">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600" onclick="return confirm('Hapus transaksi ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });
            })
            .catch(error => console.error("Error fetching transactions:", error));
    }

    function updateTransaction() {
        if (!currentSaleId) {
            console.error("No sale ID set");
            return;
        }

        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('_token', document.querySelector('input[name="_token"]').value);
        formData.append('customer_name', document.getElementById('editCustomerName').value);
        formData.append('phone', document.getElementById('editPhone').value);
        formData.append('total_amount', document.getElementById('editTotalAmount').value);
        formData.append('payment_method', document.getElementById('editPaymentMethod').value);
        formData.append('status', document.getElementById('editStatus').value);
        formData.append('notes', document.getElementById('editNotes').value);

        fetch(`/admin/sales/${currentSaleId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest' 
            }
        })
        .then(response => {
            if (response.redirected) {
                window.location.href = response.url;
                return;
            }
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            return response.json();
        })
        .then(data => {
            if (data) {
                console.log("Update Success:", data);
                alert("Transaksi berhasil diperbarui!");
                closeModal('modalEdit');
                fetchTransactions()
                location.reload();
            }
        })
        .catch(error => {
            console.error("Error updating transaction:", error);
            alert("Gagal memperbarui transaksi. Silakan coba lagi.");
        });
    }

    function openModal(id) {
        let modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => modal.style.opacity = '1', 100); 
        }
    }

    function closeModal(id) {
        let modal = document.getElementById(id);
        if (modal) {
            modal.style.opacity = '0';
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Add CSRF token to all fetch requests
        const originalFetch = window.fetch;
        window.fetch = function(url, options = {}) {
            if (!options.headers) {
                options.headers = {};
            }
            
            if (!(options.headers instanceof Headers)) {
                options.headers = new Headers(options.headers);
            }
            
            if (!options.headers.has('X-CSRF-TOKEN') && !options.headers.has('Content-Type')) {
                options.headers.append('X-CSRF-TOKEN', csrfToken);
            }
            
            return originalFetch(url, options);
        };
    });
</script>
@endsection