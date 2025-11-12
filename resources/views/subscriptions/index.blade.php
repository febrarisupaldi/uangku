@extends('layouts.app')

@section('content')
<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Daftar Subscription</h2>
        <a href="{{ route('subscriptions.create') }}" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800">
            <i data-lucide="plus" class="inline w-4 h-4 mr-1"></i> Tambah Subscription
        </a>
    </div>

    <form method="GET" action="{{ route('subscriptions.index') }}" class="flex flex-col md:flex-row md:items-end gap-4 mb-6">
        <div class="flex flex-col">
            <label for="start_date" class="text-sm text-gray-700 dark:text-gray-200 mb-1">Tanggal Mulai</label>
            <input type="date" name="from" value="{{  request('from') ?? date('Y-m-01') }}" class="rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-4 py-2">
        </div>
        <div class="flex flex-col">
            <label for="end_date" class="text-sm text-gray-700 dark:text-gray-200 mb-1">Tanggal Akhir</label>
            <input type="date" name="to" value="{{ request('to') ?? date('Y-m-d') }}" class="rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-4 py-2">
        </div>
        <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded mt-2 md:mt-0">
            <i data-lucide="filter" class="w-4 h-4 inline-block mr-1"></i> Filter
        </button>
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-200">
            <thead class="bg-gray-100 dark:bg-gray-700 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Tanggal</th>
                    <th class="px-4 py-2">Deskripsi</th>
                    <th class="px-4 py-2">Biaya</th>
                    <th class="px-4 py-2">Sumber Dana</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">#</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($subscriptions as $subscription)
                    <tr>
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($subscription->subscription_date)->format('d M Y') }}</td>
                        <td class="px-4 py-2">{{ $subscription->subscription_description }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($subscription->amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">{{ $subscription->credit_card_name }}</td>
                        @if ($subscription->subscription_status == 1)
                            <td class="px-4 py-2 text-green-600 font-semibold">Aktif</td>
                        @else
                            <td class="px-4 py-2 text-red-600 font-semibold">Tidak Aktif</td>
                        @endif
                        
                        <td class="px-4 py-2">
                            <button onclick="showHistory('{{ $subscription->id }}', '{{ $subscription->subscription_description }}')" class="text-sm text-blue-600 hover:text-blue-800">Lihat History</button>
                            <form action="" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:cursor-pointer">Nonaktifkan</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- Modal -->
<div id="historyModal" class="fixed inset-0 hidden items-center justify-center z-50 backdrop-blur-sm bg-black/40">
    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl shadow-2xl w-full max-w-2xl p-6 relative border border-white/20">
        <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100" id="modalTitle">Riwayat Langganan</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                <tr>
                    <th class="px-3 py-2">Tanggal</th>
                    <th class="px-3 py-2">Deskripsi</th>
                    <th class="px-3 py-2 text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody id="historyTable" class="divide-y dark:divide-gray-700">
                <!-- Isi via JS -->
            </tbody>
        </table>

            <div class="mt-4 flex justify-end">
                <button onclick="closeModal()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function format_rupiah(nStr) {
		if (nStr === null) {
			return 'Rp. 0';
		}
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? ',' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + '.' + '$2');
		}
		return 'Rp. ' + x1 + x2;
    }

    function showHistory(id, name) {
        const modal = document.getElementById('historyModal');
        const tableBody = document.getElementById('historyTable');
        const title = document.getElementById('modalTitle');
    
        // Update modal title
        title.textContent = `Riwayat Langganan: ${name}`;

        tableBody.innerHTML = '<tr><td colspan="3" class="text-center py-3 text-gray-400">Memuat...</td></tr>';
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        fetch(`/subscriptions/${id}/history`)
        .then(response => response.json())
        .then(data => {
            tableBody.innerHTML = '';
            if (data.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="3" class="text-center py-3 text-gray-400">Tidak ada riwayat.</td></tr>';
            }

            tableBody.innerHTML = '';
            data.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-3 py-2">${new Date(item.expense_date).toLocaleDateString()}</td>
                    <td class="px-3 py-2">${item.expense_title}</td>
                    <td class="px-3 py-2 text-right">${format_rupiah(item.expense_amount)}</td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => {
            tableBody.innerHTML = '<tr><td colspan="3" class="text-center py-3 text-red-600">Gagal memuat riwayat.</td></tr>';
            console.error('Error fetching subscription history:', error);
        });
    }

    function closeModal() {
        const modal = document.getElementById('historyModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>
@endsection
