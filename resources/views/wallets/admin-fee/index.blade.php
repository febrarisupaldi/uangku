@extends('layouts.app')

@section('content')
<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Daftar Bank</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-200">
            <thead class="bg-gray-100 dark:bg-gray-700 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Nama Bank</th>
                    <th class="px-4 py-2">Biaya Admin</th>
                    <th class="px-4 py-2">Tanggal Pemotongan</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($wallets as $index => $wallet)
                <tr>
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">{{ $wallet->name }}</td>
                    <td class="px-4 py-2">
                        @if($wallet->admin_fee === null)
                            -
                        @elseif($wallet->admin_fee === 0)
                            Free
                        @else
                            Rp.{{ number_format($wallet->nominal_admin_fee, 0, ',', '.') }}
                        @endif
                    </td>
                    <td class="px-4 py-2">{{ $wallet->date_admin_fee }}</td>
                    <td class="px-4 py-2">
                        @if($wallet->admin_fee === null)
                        <a href="{{ route('wallets.admin_fee.create', $wallet->id) }}" class="bg-green-700 text-white px-2 py-1 rounded hover:bg-green-800">
                            <i data-lucide="plus" class="inline w-4 h-4"></i>
                        </a>
                        @else 
                            <button onclick="showFormModal('{{ $wallet->id }}')" class="text-sm text-blue-600 hover:text-blue-800">Edit</button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                        <i data-lucide="info" class="inline w-5 h-5 mr-1"></i> Belum ada data.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="formModal" 
    class="fixed inset-0 hidden z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm transition-all">
    
    <div id="formModalContent"
        class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border border-white/20 
               rounded-2xl shadow-2xl w-full max-w-2xl p-6 relative transform scale-95 transition-transform duration-200">
        
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">
            Update Biaya Admin Bank
        </h2>

        <form method="POST" id="adminFeeForm" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            @method('PUT')
            {{-- Nama Bank --}}
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Bank</label>
                <select name="bank_name" id="bank_name" required
                    class="pl-3 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 
                           bg-white/70 dark:bg-gray-700/70 text-gray-900 dark:text-white">
                    <option value="" disabled selected>Pilih Bank</option>
                </select>
            </div>

            {{-- Nominal --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nominal</label>
                <input type="number" name="nominal_admin_fee" required min="0"
                    class="pl-3 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 
                           bg-white/70 dark:bg-gray-700/70 text-gray-900 dark:text-white"
                    placeholder="Jumlah biaya admin">
            </div>

            {{-- Tanggal Mulai --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Pemotongan</label>
                <input type="number" name="date_admin_fee" required
                    class="pl-3 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 
                           bg-white/70 dark:bg-gray-700/70 text-gray-900 dark:text-white">
            </div>

            {{-- Tombol --}}
            <div class="col-span-2 text-right mt-4">
                <button type="submit"
                    class="px-5 py-2 bg-green-700 hover:bg-green-800 text-white rounded-lg shadow">
                    Simpan
                </button>
            </div>
        </form>

        <!-- Tombol Close -->
        <button onclick="closeFormModal()" 
            class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 dark:hover:text-gray-100">
            ✕
        </button>
    </div>
</div>

<script>
    function showFormModal(id) {
        const modal = document.getElementById('formModal');
        const content = document.getElementById('formModalContent');
        const bankName = document.getElementById('bank_name');
        document.getElementById('adminFeeForm').action = `/wallets/admin-fee/${id}/edit`;
        modal.classList.remove('hidden');
        setTimeout(() => content.classList.remove('scale-95'), 50);
        document.body.classList.add('overflow-hidden');

        fetch(`/wallets/admin-fee/${id}`)
            .then(response => response.json())
            .then(data => {
                // Isi form dengan data yang diambil
                bankName.removeChild(bankName.firstChild); // Hapus opsi default
                bankName.appendChild(new Option(data.name, data.id, true, true));
                document.querySelector('input[name="nominal_admin_fee"]').value = Math.trunc(data.nominal_admin_fee);
                document.querySelector('input[name="date_admin_fee"]').value = data.date_admin_fee;
            })
            .catch(error => {
                console.error('Error fetching wallet data:', error);
            });
    }
        // Implement
    function closeFormModal() {
        const modal = document.getElementById('formModal');
        const content = document.getElementById('formModalContent');
        content.classList.add('scale-95');
        setTimeout(() => modal.classList.add('hidden'), 150);
        document.body.classList.remove('overflow-hidden');
    }
</script>
@endsection
