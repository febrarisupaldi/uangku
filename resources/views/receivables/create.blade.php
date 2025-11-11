@extends('layouts.app')

@section('title', 'Tambah Hutang')

@section('content')
<div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Tambah Piutang</h2>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 dark:bg-red-500/10 border border-red-400 dark:border-red-500 text-red-700 dark:text-red-300 px-4 py-3 rounded">
            <ul class="list-disc list-inside text-base">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('receivables.store')}}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @csrf


        {{-- Nama Piutang --}}
        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Piutang</label>
            <div class="relative">
                <i data-lucide="save" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <input type="text" name="receivable_name" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                    placeholder="Nama Piutang">
            </div>
        </div>

        {{-- Jumlah --}}
        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah Piutang</label>
            <div class="relative">
                <i data-lucide="coins" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <input type="number" name="receivable_amount" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                    placeholder="Jumlah Piutang">
            </div>
        </div>

        {{-- Tanggal --}}
        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Terhitung</label>
            <div class="relative">
                <i data-lucide="calendar" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <input type="date" name="start_date" required value="{{ date('Y-m-d') }}"
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>
        </div>

        {{-- Keterangan --}}
        <div class="col-span-1 md:col-span-2">
            <label for="description" class="block text-sm font-medium">Keterangan</label>
            <textarea name="description" id="description" rows="3"
                class="w-full border-gray-300 rounded-lg px-4 py-3 dark:bg-gray-700 dark:text-white"
                placeholder="Keterangan tambahan..."></textarea>
        </div>

        {{-- Tombol --}}
        <div class="col-span-1 md:col-span-2 text-right pt-4">
            <a href="{{ route('receivables.index') }}"
                class="inline-block text-lg bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-800 dark:text-white px-5 py-3 rounded mr-2">
                Batal
            </a>
            <button type="submit"
                class="inline-block text-lg bg-green-700 hover:bg-green-800 text-white px-6 py-3 rounded shadow">
                Simpan Piutang
            </button>
        </div>
    </form>
</div>
@endsection
