@extends('layouts.app')

@section('title', 'Input Pengeluaran Langganan')

@section('content')
<div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Tambah Pengeluaran Langganan</h2>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 dark:bg-red-500/10 border border-red-400 dark:border-red-500 text-red-700 dark:text-red-300 px-4 py-3 rounded">
            <ul class="list-disc list-inside text-base">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('subscriptions.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @csrf

        {{-- Credit Card --}}
        <div class="col-span-1 md:col-span-2 grid grid-cols-12 gap-4">
            <div class="col-span-12">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Pembayaran</label>
                <div class="relative">
                    <i data-lucide="wallet-minimal" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                    <select id="paymentSelect" name="credit_card" required
                        class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="" disabled selected>Pilih Pembayaran</option>
                        
                            @foreach ($credit_cards as $credit_card)
                                <option value="{{ $credit_card->id }}" data-balance="{{ $credit_card->remaining_amount }}">
                                    {{ $credit_card->name }}
                                </option>
                            @endforeach
                        
                    </select>
                </div>
            </div>
        </div>

        

        {{-- Categories --}}
        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori</label>
            <div class="relative">
                <i data-lucide="briefcase-business" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <select name="expense_category" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="" disabled selected>Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Jenis Langganan --}}
        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Langganan</label>
            <div class="relative">
                <i data-lucide="briefcase-business" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <select name="subscription_type" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="" disabled selected>Pilih Periode Langganan</option>
                    @foreach ($subs_types as $subs_type)
                        <option value="{{ $subs_type->id }}">{{ $subs_type->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Deskripsi --}}
        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi</label>
            <div class="relative">
                <i data-lucide="notebook-pen" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <input type="text" name="subscriptions_description" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                    placeholder="Deskripsi">
            </div>
        </div>

        {{-- Jumlah --}}
        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah</label>
            <div class="relative">
                <i data-lucide="coins" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <input type="number" name="subscription_amount" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                    placeholder="Jumlah">
            </div>
        </div>

        {{-- Tanggal --}}
        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Transaksi</label>
            <div class="relative">
                <i data-lucide="calendar" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <input type="date" min="{{ date('Y-01-01') }}" name="subscription_date" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>
        </div>


        {{-- Tombol --}}
        <div class="col-span-1 md:col-span-2 text-right pt-4">
            <a href="{{ route('receivables.index') }}"
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
@pushOnce('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const paymentSelect = document.getElementById("paymentSelect");
        const paymentBalance = document.getElementById("paymentBalance");

        function updateBalance() {
            const selectedOption = paymentSelect.options[paymentSelect.selectedIndex];
            const balance = selectedOption ? selectedOption.getAttribute("data-balance") : null;
            paymentBalance.value = balance
                ? "Rp " + new Intl.NumberFormat('id-ID').format(balance)
                : "-";
        }

        // Default saat load
        updateBalance();

        // Update ketika berubah
        paymentSelect.addEventListener("change", updateBalance);
    });
</script>
@endPushOnce