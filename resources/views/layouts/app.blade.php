<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="{{ asset('assets/img/logo3.png') }}" type="image/x-icon" />
  <title>@yield('title','Uangku')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    .sidebar-collapsed .sidebar-label {
      display: none;
    }
    .sidebar-collapsed .sidebar {
      width: 4rem;
    }
	
    .sidebar-collapsed #title-logo{
      display: none;
    }
    .sidebar-collapsed .submenu {
      display: none !important;
    }
    .submenu {
      transition: max-height 0.3s ease;
    }
	  [x-cloak] {
      display: none !important;
    }
  </style>
  @stack('head')
</head>
<body class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 font-sans">
    @if(session('success'))
        <x-alert type="success">{{ session('success') }}</x-alert>
    @endif

    @if(session('error'))
        <x-alert type="error">{{ session('error') }}</x-alert>
    @endif

    @if(session('warning'))
        <x-alert type="warning">{{ session('warning') }}</x-alert>
    @endif
    <div class="flex h-screen overflow-hidden relative" id="app">
      <div id="overlay" class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-30 hidden" onclick="closeMobileSidebar()"></div>
      @include('partials.sidebar')
      <div class="flex-1 flex flex-col overflow-hidden">
          @include('partials.header')
          <main class="flex-1 overflow-y-auto p-4 md:p-6 space-y-8 dark:bg-gray-900 bg-gray-100">
          @yield('content')
          </main>
      </div>
    </div>
</body>
</html>