@extends('layouts.app')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Daftar Pemasukan</h2>
        <a href="{{ route('incomes.create') }}" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800">
            <i data-lucide="plus" class="inline w-4 h-4 mr-1"></i> Tambah Pemasukan
        </a>
    </div>

    <form method="GET" action="{{ route('incomes.index') }}" class="flex flex-col md:flex-row md:items-end gap-4 mb-6">
        <div class="flex flex-col">
            <label for="start_date" class="text-sm text-gray-700 dark:text-gray-200 mb-1">Tanggal Mulai</label>
            <input type="date" name="from" value="{{ old('from') ?? $from }}" class="rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-4 py-2">
        </div>
        <div class="flex flex-col">
            <label for="end_date" class="text-sm text-gray-700 dark:text-gray-200 mb-1">Tanggal Akhir</label>
            <input type="date" name="to" value="{{ old('to') ?? $to }}" class="rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-4 py-2">
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
