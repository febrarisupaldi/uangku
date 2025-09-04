@extends('layouts.app')

@section('title', 'Tambah Hutang')

@section('content')
<div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Tambah Hutang</h2>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 dark:bg-red-500/10 border border-red-400 dark:border-red-500 text-red-700 dark:text-red-300 px-4 py-3 rounded">
            <ul class="list-disc list-inside text-base">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('debts.store')}}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @csrf

        {{-- Nama User --}}
        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih User</label>
            <div class="relative">
                <i data-lucide="users" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <select name="user_id" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Tipe Dompet --}}
        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Tipe Dompet</label>
            <div class="relative">
                <i data-lucide="wallet-minimal" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <select name="wallet_type_id" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    @foreach ($wallet_types as $wallet_type)
                        <option value="{{ $wallet_type->id }}">{{ $wallet_type->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Nama Hutang --}}
        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Hutang</label>
            <div class="relative">
                <i data-lucide="save" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <input type="text" name="debt_name" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                    placeholder="Nama Hutang">
            </div>
        </div>

        {{-- Jumlah --}}
        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah Hutang</label>
            <div class="relative">
                <i data-lucide="coins" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <input type="number" name="debt_amount" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                    placeholder="Jumlah Hutang">
            </div>
        </div>

        {{-- Jumlah Bayar --}}
        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah Bayar</label>
            <div class="relative">
                <i data-lucide="coins" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <input type="number" name="debt_amount" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                    placeholder="Jumlah Bayar">
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

        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Kartu Kredit
            </label>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="is_credit_card" value="1" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none 
                            peer-focus:ring-2 peer-focus:ring-green-500 
                            dark:peer-focus:ring-green-700 rounded-full 
                            peer dark:bg-gray-600
                            peer-checked:bg-green-600 after:content-[''] 
                            after:absolute after:top-[2px] after:left-[2px] 
                            after:bg-white after:border-gray-300 after:border 
                            after:rounded-full after:h-5 after:w-5 after:transition-all 
                            peer-checked:after:translate-x-full peer-checked:after:border-white">
                </div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Ya
                </span>
            </label>
        </div>

        {{-- Tombol --}}
        <div class="col-span-1 md:col-span-2 text-right pt-4">
            <a href="{{ route('debts.index') }}"
                class="inline-block text-lg bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-800 dark:text-white px-5 py-3 rounded mr-2">
                Batal
            </a>
            <button type="submit"
                class="inline-block text-lg bg-green-700 hover:bg-green-800 text-white px-6 py-3 rounded shadow">
                Simpan Hutang
            </button>
        </div>
    </form>
</div>
@endsection
