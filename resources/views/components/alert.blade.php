@props(['type' => 'success'])

@php
    $baseClasses = 'px-4 py-3 rounded shadow-md text-white fixed top-4 right-4 z-50';
    $types = [
        'success' => 'bg-green-600',
        'error' => 'bg-red-600',
        'warning' => 'bg-yellow-500 text-black',
    ];
@endphp

<div
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 4000)"
    x-show="show"
    class="{{ $baseClasses }} {{ $types[$type] ?? $types['success'] }}"
>
    {{ $slot }}
</div>
