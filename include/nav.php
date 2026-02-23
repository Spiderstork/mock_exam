<?php
include "head.html";
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<nav class="sticky top-0 z-50 bg-gray-800/50 after:pointer-events-none after:absolute after:inset-x-0 after:bottom-0 after:h-px after:bg-white/10">
  <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
    <div class="relative flex h-16 items-center justify-between">
      <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
        <!-- Mobile menu button-->
        <button type="button" command="--toggle" commandfor="mobile-menu" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-white/5 hover:text-white focus:outline-2 focus:-outline-offset-1 focus:outline-indigo-500">
          <span class="absolute -inset-0.5"></span>
          <span class="sr-only">Open main menu</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 in-aria-expanded:hidden">
            <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 not-in-aria-expanded:hidden">
            <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>
      </div>
      <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
        <div class="flex shrink-0 items-center">
          <img src="assets/logo.jpg" class="size-12 rounded-full bg-gray-800 outline -outline-offset-1 outline-white/10" alt="Epicurean Themes" />
        </div>
        <div class="hidden sm:ml-6 sm:block">
          <div class="flex space-x-4">
            <!-- Current: "bg-gray-950/50 text-white", Default: "text-gray-300 hover:bg-white/5 hover:text-white" -->
             <a href="index.php"
                class="block rounded-md px-3 py-2 text-base font-medium
                <?= ($currentPage == 'index.php') 
                ? 'bg-gray-950/50 text-white' 
                : 'text-gray-300 hover:bg-white/5 hover:text-white' ?>">
                home
            </a>
            <a href="about.php"
                class="block rounded-md px-3 py-2 text-base font-medium
                <?= ($currentPage == 'about.php') 
                ? 'bg-gray-950/50 text-white' 
                : 'text-gray-300 hover:bg-white/5 hover:text-white' ?>">
                about
            </a>
            <a href="menu.php"
                class="block rounded-md px-3 py-2 text-base font-medium
                <?= ($currentPage == 'menu.php') 
                ? 'bg-gray-950/50 text-white' 
                : 'text-gray-300 hover:bg-white/5 hover:text-white' ?>">
            menu
            </a>
          </div>
        </div>
      </div>
      <a href="booking.php"
        class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">

            <span class="relative ml-3 flex rounded-full focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                <span class="absolute -inset-1.5"></span>
                <span class="sr-only">BOOK NOW</span>
                <span class="rounded-full bg-blue-600 px-3 py-1 text-white font-semibold text-lg btn btn-primary ">
                    BOOK NOW
                </span>
            </span>

        </a>
    </div>
  </div>

  <div id="mobile-menu" class="hidden sm:hidden">
    <div class="space-y-1 px-2 pt-2 pb-3">
      <!-- Current: "bg-gray-950/50 text-white", Default: "text-gray-300 hover:bg-white/5 hover:text-white" -->
       <a href="index.php"
                class="block rounded-md px-3 py-2 text-base font-medium
                <?= ($currentPage == 'index.php') 
                ? 'bg-gray-950/50 text-white' 
                : 'text-gray-300 hover:bg-white/5 hover:text-white' ?>">
                home
            </a>
            <a href="about.php"
                class="block rounded-md px-3 py-2 text-base font-medium
                <?= ($currentPage == 'about.php') 
                ? 'bg-gray-950/50 text-white' 
                : 'text-gray-300 hover:bg-white/5 hover:text-white' ?>">
                about
            </a>
            <a href="menu.php"
                class="block rounded-md px-3 py-2 text-base font-medium
                <?= ($currentPage == 'menu.php') 
                ? 'bg-gray-950/50 text-white' 
                : 'text-gray-300 hover:bg-white/5 hover:text-white' ?>">
            menu
            </a>
    </div>
</div>
</nav>
<script>
document.addEventListener("DOMContentLoaded", () => {

  const buttons = document.querySelectorAll('[command="--toggle"]');

  buttons.forEach(button => {

    const targetId = button.getAttribute("commandfor");
    const menu = document.getElementById(targetId);

    const icons = button.querySelectorAll("svg");
    const openIcon = icons[0];
    const closeIcon = icons[1];

    closeIcon.classList.add("hidden");

    button.addEventListener("click", () => {

      menu.classList.toggle("hidden");

      const isOpen = !menu.classList.contains("hidden");

      button.setAttribute("aria-expanded", isOpen);

      openIcon.classList.toggle("hidden", isOpen);
      closeIcon.classList.toggle("hidden", !isOpen);

    });

  });

});
</script>