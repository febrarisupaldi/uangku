@extends('layouts.app')

@section('title', 'Tambah Hutang')

@section('content')
<div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Mutasi Kas</h2>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 dark:bg-red-500/10 border border-red-400 dark:border-red-500 text-red-700 dark:text-red-300 px-4 py-3 rounded">
            <ul class="list-disc list-inside text-base">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('transfers.store')}}" method="POST" class="grid grid-cols-2 md:grid-cols-2 gap-6">
        @csrf

        {{-- Nama User --}}
        <div class="col-span-2 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih User</label>
            <div class="relative">
                <i data-lucide="users" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <select name="user_id" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="">Pilih</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Asal Dompet --}}
        <div class="col-span-1 md:col-span-1">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Asal Dompet</label>
            <div class="relative">
                <i data-lucide="wallet-minimal" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <select name="from_wallet_id" id="wallet_id_from" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="">Pilih</option>
                    @foreach ($wallets as $wallet)
                        <option value="{{ $wallet->id }}" data-balance="{{round($wallet->balance,0)}}">{{ $wallet->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        
        {{-- Saldo Wallet Dari --}}
        <div class="col-span-1 md:col-span-1">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah Saldo</label>
            <div class="relative">
                <i data-lucide="coins" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <input type="text" name="wallet_from_balance" id="wallet_from_balance" readonly
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                    placeholder="Jumlah Saldo">
            </div>
        </div>

        {{-- Nama Transaksi --}}
        <div class="col-span-2 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Keterangan</label>
            <div class="relative">
                <i data-lucide="save" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <input type="text" name="description" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                    placeholder="Keterangan">
            </div>
        </div>

        {{-- Jumlah --}}
        <div class="col-span-2 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah</label>
            <div class="relative">
                <i data-lucide="coins" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <input type="number" name="transfer_amount" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                    placeholder="Jumlah">
            </div>
        </div>        

        

        {{-- Tujuan Dompet --}}
        <div class="col-span-1 md:col-span-1">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Asal Dompet</label>
            <div class="relative">
                <i data-lucide="wallet-minimal" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <select name="to_wallet_id" id="wallet_id_to" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="">Pilih</option>
                    @foreach ($wallets as $wallet)
                        <option value="{{ $wallet->id }}" data-balance="{{ round($wallet->balance,0) }}">{{ $wallet->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

            
        {{-- Saldo Wallet Tujuan --}}
        <div class="col-span-1 md:col-span-1">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah</label>
            <div class="relative">
                <i data-lucide="coins" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <input type="text" name="wallet_to_balance" id="wallet_to_balance" readonly
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                    placeholder="Jumlah">
            </div>
        </div>  

        {{-- Tanggal --}}
        <div class="col-span-2 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Terhitung</label>
            <div class="relative">
                <i data-lucide="calendar" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <input type="date" name="transfer_date" required value="{{ date('Y-m-d') }}"
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>
        </div>

        

        {{-- Tombol --}}
        <div class="col-span-2 md:col-span-2 text-right pt-4">
            <a href="{{ route('debts.index') }}"
                class="inline-block text-lg bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-800 dark:text-white px-5 py-3 rounded mr-2">
                Batal
            </a>
            <button type="submit"
                class="inline-block text-lg bg-green-700 hover:bg-green-800 text-white px-6 py-3 rounded shadow">
                Simpan Mutasi
            </button>
        </div>
    </form>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const walletFromSelect = document.getElementById('wallet_id_from');
        const walletToSelect = document.getElementById('wallet_id_to');
        const walletFromBalanceInput = document.getElementById('wallet_from_balance');
        const walletToBalanceInput = document.getElementById('wallet_to_balance');

        // Update the balance input when the wallet is changed
        function updateBalanceInput(select, balanceInput) {
            const selectedOption = select.options[select.selectedIndex];
            const balance = selectedOption.getAttribute('data-balance');
            balanceInput.value = balance;
        }

        // Initialize the balance inputs on page load
        updateBalanceInput(walletFromSelect, walletFromBalanceInput);
        updateBalanceInput(walletToSelect, walletToBalanceInput);

        // Add event listeners to update the balance inputs when the selection changes
        walletFromSelect.addEventListener('change', function () {
            updateBalanceInput(walletFromSelect, walletFromBalanceInput);
        });

        walletToSelect.addEventListener('change', function () {
            updateBalanceInput(walletToSelect, walletToBalanceInput);
        });
    });
</script>
