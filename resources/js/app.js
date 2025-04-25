import './bootstrap';

import Alpine from 'alpinejs'
import { createIcons, icons } from 'lucide'
import {Chart, registerables} from 'chart.js/auto'

window.Alpine = Alpine;
Alpine.start();

Chart.register(...registerables);
window.Chart = Chart;

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

    createIcons({ icons });

    document.getElementById("userMenuButton")?.addEventListener("click", function (e) {
        e.stopPropagation();
        const menu = document.getElementById("userMenu");
        menu.classList.toggle("hidden");
    });

    document.addEventListener("click", function (e) {
        const menu = document.getElementById("userMenu");
        const button = document.getElementById("userMenuButton");
        if (!button?.contains(e.target)) {
            menu?.classList.add("hidden");
        }
    });

    window.toggleDarkMode = () => {
        const html = document.documentElement;
        const icon = document.getElementById("themeIcon");

        const isDark = html.classList.toggle("dark");
        localStorage.setItem("theme", isDark ? "dark" : "light");
        icon.dataset.lucide = isDark ? "sun" : "moon";
        createIcons( { icons });
    };

    window.toggleSidebar = () => {
        const app = document.getElementById('app');
        app.classList.toggle('sidebar-collapsed');

        const icon = document.getElementById('sidebar-toggle-icon');
        icon.dataset.lucide = app.classList.contains('sidebar-collapsed') ? "chevron-right" : "chevron-left";
        createIcons({ icons });
    };

    window.toggleSubmenu = function (id, button) {
        const submenu = document.getElementById(id);
        if (!submenu || !button) return;

        const iconDown = button.querySelector('.icon-down');
        const iconUp = button.querySelector('.icon-up');

        // Tutup submenu lain
        document.querySelectorAll('.submenu').forEach((el) => {
            if (el.id !== id) {
            el.classList.add('hidden');
            el.style.maxHeight = null;
            }
        });

        // Reset semua ikon ke default
        document.querySelectorAll('.icon-down').forEach((el) => el.classList.remove('hidden'));
        document.querySelectorAll('.icon-up').forEach((el) => el.classList.add('hidden'));

        const isHidden = submenu.classList.contains('hidden');

        if (isHidden) {
            submenu.classList.remove('hidden');
            submenu.style.maxHeight = submenu.scrollHeight + 'px';

            iconDown.classList.add('hidden');
            iconUp.classList.remove('hidden');
        } else {
            submenu.style.maxHeight = null;
            submenu.classList.add('hidden');

            iconDown.classList.remove('hidden');
            iconUp.classList.add('hidden');
        }
    }


    window.openMobileSidebar = () => {
        document.getElementById('sidebar')?.classList.remove('-translate-x-full');
        document.getElementById('overlay')?.classList.remove('hidden');
    };

    window.closeMobileSidebar = () => {
        document.getElementById('sidebar')?.classList.add('-translate-x-full');
        document.getElementById('overlay')?.classList.add('hidden');
    };
});