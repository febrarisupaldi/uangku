@extends('layouts.app')

@section('content')
<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Daftar Mutasi</h2>
        <a href="{{ route('transfers.create') }}" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800">
            <i data-lucide="plus" class="inline w-4 h-4 mr-1"></i> Tambah Mutasi
        </a>
    </div>

    <form method="GET" action="{{ route('transfers.index') }}" class="flex flex-col md:flex-row md:items-end gap-4 mb-6">
        <div class="flex flex-col">
            <label for="start_date" class="text-sm text-gray-700 dark:text-gray-200 mb-1">Tanggal Mulai</label>
            <input type="date" name="from" value="{{ $from }}" class="rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-4 py-2">
        </div>
        <div class="flex flex-col">
            <label for="end_date" class="text-sm text-gray-700 dark:text-gray-200 mb-1">Tanggal Akhir</label>
            <input type="date" name="to" value="{{ $to }}" class="rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-4 py-2">
        </div>
        <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded mt-2 md:mt-0">
            <i data-lucide="filter" class="w-4 h-4 inline-block mr-1"></i> Filter
        </button>
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-200">
            <thead class="bg-gray-100 dark:bg-gray-700 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Dari Dompet</th>
                    <th class="px-4 py-2">Ke Dompet</th>
                    <th class="px-4 py-2">Jumlah Mutasi</th>
                    <th class="px-4 py-2">Keterangan</th>
                    <th class="px-4 py-2">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($transfers as $index => $transfer)
                <tr>
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">{{ $transfer->from_wallet_name }}</td>
                    <td class="px-4 py-2">{{ $transfer->to_wallet_name }}</td>
                    <td class="px-4 py-2">Rp {{ number_format($transfer->transfer_amount, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">{{ $transfer->description }}</td>
                    <td class="px-4 py-2">{{ $transfer->transfer_date }}</td>

                    <!-- <td class="px-4 py-2 flex gap-2">
                        <form action="" method="POST" onsubmit="return confirm('Yakin hapus?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">
                                <i data-lucide="trash-2" class="w-4 h-4 inline"></i> Hapus
                            </button>
                        </form>
                    </td> -->
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                        <i data-lucide="info" class="inline w-5 h-5 mr-1"></i> Belum ada Mutasi Kas.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
