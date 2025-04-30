@extends('layouts.app')

@section('title', 'Tambah Kartu Kredit')

@section('content')
<div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Tambah Kartu Kredit</h2>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 dark:bg-red-500/10 border border-red-400 dark:border-red-500 text-red-700 dark:text-red-300 px-4 py-3 rounded">
            <ul class="list-disc list-inside text-base">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('credit.cards.store')}}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @csrf

        {{-- Nama User --}}
        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih User</label>
            <div class="relative">
                <i data-lucide="users" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <select name="user_id" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="" disabled selected>-- Pilih User --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Nama Kartu Kredit --}}
        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Dompet</label>
            <div class="relative">
                <i data-lucide="save" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <input type="text" name="name" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                    placeholder="Nama Kartu Kredit">
            </div>
        </div>

            
        {{-- Limit --}}
        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Limit</label>
            <div class="relative">
                <i data-lucide="arrow-up-0-1" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <input type="number" name="limit" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                    placeholder="Limit Kartu Kredit">
            </div>
        </div>

            
        {{-- Tanggal Terbit Tagihan--}}
        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Terbit Tagihan</label>
            <div class="relative">
                <i data-lucide="calendar" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <input type="number" name="billing_day" required min="1" max="31"
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                    placeholder="Tanggal Terbit Kartu Kredit">
            </div>
        </div>

        {{-- Sisa Limit --}}
        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sisa Limit</label>
            <div class="relative">
                <i data-lucide="arrow-down-1-0" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <input type="number" name="outstanding_balance" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                    placeholder="Sisa Limit">
            </div>
        </div>

        {{-- Tombol --}}
        <div class="col-span-1 md:col-span-2 text-right pt-4">
            <a href=""
                class="inline-block text-lg bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-800 dark:text-white px-5 py-3 rounded mr-2">
                Batal
            </a>
            <button type="submit"
                class="inline-block text-lg bg-green-700 hover:bg-green-800 text-white px-6 py-3 rounded shadow">
                Simpan Kartu Kredit
            </button>
        </div>
    </form>
</div>
@endsection
