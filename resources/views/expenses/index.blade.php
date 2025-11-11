@extends('layouts.app')

@section('content')
<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Daftar Pengeluaran</h2>
        <a href="{{ route('expenses.create') }}" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800">
            <i data-lucide="plus" class="inline w-4 h-4 mr-1"></i> Tambah Pengeluaran
        </a>
    </div>

    <form method="GET" action="{{ route('expenses.index') }}" class="flex flex-col md:flex-row md:items-end gap-4 mb-6">
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
                    <th class="px-4 py-2">Tanggal</th>
                    <th class="px-4 py-2">Deskripsi</th>
                    <th class="px-4 py-2">Jumlah</th>
                    <th class="px-4 py-2">Pengguna</th>
                    <th class="px-4 py-2">Sumber Dana</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($expenses as $expense)
                    <tr>
                        <td class="px-4 py-2">{{ $expense->expense_date }}</td>
                        <td class="px-4 py-2">{{ $expense->expense_title }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($expense->expense_amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">{{ $expense->user_name }}</td>
                        <td class="px-4 py-2">{{ $expense->wallet_name }}</td>
                        <td class="px-4 py-2">
                            <a href="" class="text-blue-600 hover:underline">Edit</a>
                            <form action="" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                        <i data-lucide="info" class="inline w-5 h-5 mr-1"></i> Belum ada data pengeluaran.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
