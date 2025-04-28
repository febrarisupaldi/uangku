<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Koperasi</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
    };
  </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen flex items-center justify-center transition-colors duration-300">
  <div class="w-full max-w-md p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">

	<div class="flex justify-center">
      <img src="{{ asset('assets/img/logo3.png')}}" alt="Logo Uangku" class="" />
    </div>
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold">Login</h2>
      <button onclick="toggleDarkMode()" class="text-gray-500 dark:text-gray-300 hover:text-black dark:hover:text-white">
        <i id="themeIcon" data-lucide="moon" class="w-5 h-5"></i>
      </button>
    </div>
    <form action="/login" method="POST" class="space-y-4">
      <div>
        <label for="username" class="block mb-1 text-sm font-medium">Username</label>
        <input type="text" id="username" name="username" required
          class="w-full px-4 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring focus:ring-green-400" />
      </div>
      <div>
        <label for="password" class="block mb-1 text-sm font-medium">Password</label>
        <input type="password" id="password" name="password" required
          class="w-full px-4 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring focus:ring-green-400" />
      </div>
      <button type="submit"
        class="w-full py-2 px-4 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
        Login
      </button>
    </form>

	<p class="text-center text-xs text-gray-400 py-2">
      © 2025 Koperasi Karyawan
    </p>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const icon = document.getElementById("themeIcon");
      const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
      const storedTheme = localStorage.getItem("theme");

      const shouldUseDark = storedTheme === "dark" || (!storedTheme && prefersDark);
      if (shouldUseDark) {
        document.documentElement.classList.add("dark");
        icon.dataset.lucide = "sun";
      } else {
        document.documentElement.classList.remove("dark");
        icon.dataset.lucide = "moon";
      }

      lucide.createIcons();
    });

    function toggleDarkMode() {
      const html = document.documentElement;
      const icon = document.getElementById("themeIcon");

      const isDark = html.classList.toggle("dark");
      localStorage.setItem("theme", isDark ? "dark" : "light");
      icon.dataset.lucide = isDark ? "sun" : "moon";

      lucide.createIcons();
    }
  </script>
</body>
</html>
<!--
  This code is a simple login page using Tailwind CSS and Lucide icons.
  It includes a logo, a form for username and password, and a dark mode toggle button.
  The dark mode preference is stored in local storage. -->
