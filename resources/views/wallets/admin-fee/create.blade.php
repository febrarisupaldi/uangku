@extends('layouts.app')

@section('title', 'Tambah Biaya Admin')

@section('content')
<div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Biaya Admin</h2>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 dark:bg-red-500/10 border border-red-400 dark:border-red-500 text-red-700 dark:text-red-300 px-4 py-3 rounded">
            <ul class="list-disc list-inside text-base">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('wallets.admin_fee.store', $wallet->id)}}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @csrf
        @method('PUT')
        {{-- Bank --}}
        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bank</label>
            <div class="relative">
                <i data-lucide="wallet-minimal" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <select name="wallet_id" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="{{ $wallet->id }}">{{ $wallet->name }}</option>
                </select>
            </div>
        </div>

        {{-- Nominal --}}
        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Biaya Admin</label>
            <div class="relative">
                <i data-lucide="coins" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <input type="number" name="nominal_admin_fee" id="wallet_balance" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                    placeholder="Nominal Biaya Admin (Isi 0 jika gratis biaya admin)" value="0">
            </div>
        </div>

        {{-- Tanggal --}}
        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Pemotongan</label>
            <div class="relative">
                <i data-lucide="calendar" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <input type="number" name="date_admin_fee" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                    placeholder="Tanggal Pemotongan (contoh: 5 untuk tanggal 5 setiap bulan)"
                    min="1" max="28">
            </div>
        </div>

        {{-- Tombol --}}
        <div class="col-span-1 md:col-span-2 text-right pt-4">
            <a href="{{ route('wallets.admin_fee.index') }}"
                class="inline-block text-lg bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-800 dark:text-white px-5 py-3 rounded mr-2">
                Batal
            </a>
            <button type="submit"
                class="inline-block text-lg bg-green-700 hover:bg-green-800 text-white px-6 py-3 rounded shadow">
                Simpan
            </button>
        </div>
    </form>
</div>

@endsection
