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
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                        <i data-lucide="info" class="inline w-5 h-5 mr-1"></i> Belum ada anggota yang terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
