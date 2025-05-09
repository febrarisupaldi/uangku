@extends('layouts.app')

@section('content')
<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Daftar Hutang</h2>
        <a href="{{ route('debts.create') }}" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800">
            <i data-lucide="plus" class="inline w-4 h-4 mr-1"></i> Tambah Hutang
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-200">
            <thead class="bg-gray-100 dark:bg-gray-700 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Nama Hutang</th>
                    <th class="px-4 py-2">Jumlah</th>
                    <th class="px-4 py-2">Sisa</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($debts as $index => $debt)
                <tr>
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">{{ $debt->name }}</td>
                    <td class="px-4 py-2">Rp {{ number_format($debt->total_amount, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">Rp {{ number_format($debt->remaining_amount, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">{{ $debt->status_name }}</td>

                    <td class="px-4 py-2 flex gap-2">
                        <form action="" method="POST" onsubmit="return confirm('Yakin hapus?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">
                                <i data-lucide="trash-2" class="w-4 h-4 inline"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                        <i data-lucide="info" class="inline w-5 h-5 mr-1"></i> Belum ada Hutang.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
