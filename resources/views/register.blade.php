<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Daftar - Uangku</title>
  <link rel="icon" href="{{ asset('assets/img/logo3.png') }}" type="image/png">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen flex items-center justify-center transition-colors duration-300">
  <div class="w-full max-w-md p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">

	<div class="flex justify-center">
      <img src="{{ asset('assets/img/logo3.png')}}" alt="Logo Uangku" class="" />
    </div>
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold">Daftar</h2>
      <button onclick="toggleDarkMode()" class="text-gray-500 dark:text-gray-300 hover:text-black dark:hover:text-white">
        <i id="themeIcon" data-lucide="moon" class="w-5 h-5"></i>
      </button>
    </div>
    <form action="{{ route('users.register') }}" method="POST" class="space-y-4">
      @csrf
      <div>
        <label for="username" class="block mb-1 text-sm font-medium">Username</label>
        <input type="email" id="username" name="username" required
          class="w-full px-4 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring focus:ring-green-400" />
      </div>
      <div>
        <label for="fullname" class="block mb-1 text-sm font-medium">Nama Lengkap</label>
        <input type="text" id="fullname" name="fullname" required
          class="w-full px-4 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring focus:ring-green-400" />
      </div>
      <div>
        <label for="password" class="block mb-1 text-sm font-medium">Kata Sandi</label>
        <input type="password" id="password" name="password" required
          class="w-full px-4 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring focus:ring-green-400" />
      </div>
      <div>
        <label for="password_confirmation" class="block mb-1 text-sm font-medium">Konfirmasi Kata Sandi</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required
          class="w-full px-4 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring focus:ring-green-400" />
      </div>
      <button type="submit"
        class="w-full py-2 px-4 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
        Register
      </button>
      @if($errors->any())    
        <div class="mb-4 text-red-500">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </div>
      @endif
    </form>

	<p class="text-center text-xs text-gray-400 py-2">
      © 2025 Uangku
    </p>
  </div>
</body>
</html>
