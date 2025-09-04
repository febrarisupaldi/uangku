@extends('layouts.app')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-6">
    <form method="GET" action="{{ route('incomes.index') }}" class="grid grid-cols-5 gap-4 items-end">
        {{-- Dari Tanggal (2/5) --}}
        <div class="col-span-2">
            <label for="from_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Dari Tanggal
            </label>
            <input type="date" id="from_date" name="from_date"
                value="{{ date('Y-m-01') ?? request('from_date') }}"
                class="w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white px-3 py-2">
        </div>

        {{-- Sampai Tanggal (2/5) --}}
        <div class="col-span-2">
            <label for="to_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Sampai Tanggal
            </label>
            <input type="date" id="to_date" name="to_date"
                value="{{ date('Y-m-d') ?? request('to_date') }}"
                class="w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white px-3 py-2">
        </div>

        {{-- Tombol Submit (1/5) --}}
        <div class="col-span-1">
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow">
                Filter
            </button>
        </div>
    </form>
</div>


<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Daftar Pemasukan</h2>
        
        <a href="{{ route('incomes.create') }}" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800">
            <i data-lucide="plus" class="inline w-4 h-4 mr-1"></i> Tambah Pemasukan
        </a>
        
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-200">
            <thead class="bg-gray-100 dark:bg-gray-700 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Dompet</th>
                    <th class="px-4 py-2">Kategori</th>
                    <th class="px-4 py-2">Jumlah</th>
                    <th class="px-4 py-2">Tanggal</th>
                    <th class="px-4 py-2">Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($incomes as $index => $income)
                <tr>
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">{{ $income->wallet_name }}</td>
                    <td class="px-4 py-2">{{ $income->category_name }}</td>
                    <td class="px-4 py-2">Rp {{ number_format($income->income_amount, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">{{ $income->transaction_date }}</td>
                    <td class="px-4 py-2">{{ $income->description }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                        <i data-lucide="info" class="inline w-5 h-5 mr-1"></i> Belum ada data pemasukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
