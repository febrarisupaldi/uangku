@extends('layouts.app')

@section('title','Dashboard Uangku')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow rounded-lg p-6">
        <h2 class="text-sm text-gray-500 dark:text-gray-300">Total Uang</h2>
        <p class="text-2xl font-bold text-green-700 dark:text-green-400">Rp.{{ number_format($total_moneys,0,',','.') }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow rounded-lg p-6">
        <h2 class="text-sm text-gray-500 dark:text-gray-300">Total Hutang</h2>
        <p class="text-2xl font-bold text-green-700 dark:text-green-400">Rp.{{ number_format($total_debts,0,',','.') }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow rounded-lg p-6">
        <h2 class="text-sm text-gray-500 dark:text-gray-300">Total Piutang</h2>
        <p class="text-2xl font-bold text-green-700 dark:text-green-400">Rp.{{ number_format($total_receivables,0,',','.') }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow rounded-lg p-6">
        <h2 class="text-sm text-gray-500 dark:text-gray-300">Total Investasi</h2>
        <p class="text-2xl font-bold text-green-700 dark:text-green-400">Rp40.000.000</p>
    </div>
</div>

<div class="mt-8 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow rounded-lg p-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Grafik Simpanan vs Pinjaman</h3>
    <div class="aspect-[6/2]">
        <canvas id="grafikKeuangan"></canvas>
    </div>
</div>
@endsection

@push('head')
<script>
  var months =  "{{ implode(',', $months) }}";
  var incomeData = "{{ implode(',', $total_income_six_months) }}";
  document.addEventListener("DOMContentLoaded", () => {
    const ctx = document.getElementById('grafikKeuangan').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: months.split(','),
        datasets: [
          {
            label: 'Pendapatan',
            data: incomeData.split(','),
            backgroundColor: 'rgba(34,197,94,0.7)',
            borderColor: 'rgba(34,197,94,1)',
            borderWidth: 1
          },
          {
            label: 'Pengeluaran',
            data: [20000000, 25000000, 28000000, 30000000, 31000000, 32000000],
            backgroundColor: 'rgba(239,68,68,0.7)',
            borderColor: 'rgba(239,68,68,1)',
            borderWidth: 1
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: value => 'Rp ' + value.toLocaleString('id-ID')
            }
          }
        }
      }
    });
  });
</script>
@endpush