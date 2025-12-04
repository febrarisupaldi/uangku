@extends('layouts.app')

@section('content')
<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Daftar Pembayaran Hutang</h2>
        <a href="{{ route('debts.payments.create') }}" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800">
            <i data-lucide="plus" class="inline w-4 h-4 mr-1"></i> Bayar Hutang
        </a>
    </div>

    <form method="GET" action="{{ route('debts.payments.index') }}" class="flex flex-col md:flex-row md:items-end gap-4 mb-6">
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
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Tanggal</th>
                    <th class="px-4 py-2">Title</th>
                    <th class="px-4 py-2">Dari Dompet</th>
                    <th class="px-4 py-2">Balance</th>
                    <th class="px-4 py-2">Ke Dompet</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($debts as $index => $debt)
                <tr>
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">{{ $debt->payment_date }}</td>
                    <td class="px-4 py-2">{{ $debt->title }}</td>
                    <td class="px-4 py-2">{{ $debt->wallet_name }}</td>
                    <td class="px-4 py-2">Rp {{ number_format($debt->amount_paid, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">{{ $debt->debt_name }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                        <i data-lucide="info" class="inline w-5 h-5 mr-1"></i> Belum ada Pembayaran Hutang.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
