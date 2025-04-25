@extends('layouts.app')

@section('title', 'Tambah Simpanan')

@section('content')
<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow max-w-4xl mx-auto">
    <h2 class="text-2xl font-semibold mb-6 text-gray-900 dark:text-white flex items-center gap-2">
        <i data-lucide="wallet" class="w-6 h-6"></i> Tambah Simpanan Anggota
    </h2>

    <form action="{{ route('savings.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @csrf

        {{-- Anggota --}}
        <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Anggota</label>
            <div class="relative">
                <i data-lucide="users" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <select name="member_id" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
                    <option value="" disabled selected>-- Pilih Anggota --</option>
                    @foreach ($members as $member)
                        <option value="{{ $member->id }}">{{ $member->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Simpanan Pokok --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Simpanan Pokok</label>
            <div class="relative">
                <i data-lucide="dollar-sign" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <input type="number" name="mandatory_amount" value="50000" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white"
                    placeholder="Simpanan pokok">
            </div>
        </div>

        {{-- Simpanan Sukarela --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Simpanan Sukarela</label>
            <div class="relative">
                <i data-lucide="dollar-sign" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <input type="number" name="voluntry_amount" min="0" value="0" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white"
                    placeholder="Simpanan sukarela">
            </div>
        </div>

        {{-- Tanggal --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Simpan</label>
            <div class="relative">
                <i data-lucide="calendar" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <input type="date" name="date" required
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
            </div>
        </div>

        {{-- Deskripsi --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi</label>
            <div class="relative">
                <i data-lucide="save" class="absolute left-3 top-3.5 w-5 h-5 text-gray-500"></i>
                <input type="text" name="description"
                    class="pl-10 pr-4 py-3 w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white"
                    placeholder="keterangan">
            </div>
        </div>

        {{-- Tombol --}}
        <div class="col-span-2 flex justify-between pt-4">
            <a href="{{ route('savings.index') }}" class="text-sm text-gray-500 hover:underline">← Kembali</a>
            <button type="submit"
                class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection