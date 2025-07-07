<header class="bg-white shadow sticky top-0 z-50">
    <div class="container mx-auto px-4 py-4 flex flex-row items-center justify-between md:flex-row md:items-center md:space-x-6">
        <div class="flex items-center space-x-4">
            <a href="/" class="transition hover:opacity-80">
                <img src="https://i.imgur.com/eP2y6gB.jpeg" alt="Logo FDS" class="h-12 w-auto">
            </a>
            <span class="text-2xl font-bold text-black tracking-tight">FDS Logística e Terceirização</span>
        </div>
        <nav class="hidden md:block">
            <ul class="flex space-x-6 text-base font-semibold text-green-700">
                <li><a href="/" class="transition {{ request()->is('/') ? 'border-b-2 border-green-700' : '' }}">Home</a></li>
                <li><a href="/company" class="transition {{ request()->is('company') ? 'border-b-2 border-green-700' : '' }}">A Empresa</a></li>
                <li><a href="/service" class="transition {{ request()->is('service') ? 'border-b-2 border-green-700' : '' }}">Serviços</a></li>
                <li><a href="/quote" class="transition {{ request()->is('quote') ? 'border-b-2 border-green-700' : '' }}">Orçamento</a></li>
                <li><a href="/contact" class="transition {{ request()->is('contact') ? 'border-b-2 border-green-700' : '' }}">Contato</a></li>
            </ul>
        </nav>
        <button id="menu-toggle" class="md:hidden text-green-700 focus:outline-none" aria-label="Abrir menu" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>
    <div id="menu-overlay" class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 hidden z-40" onclick="closeMenu()" aria-hidden="true"></div>
    <nav id="menu" class="md:hidden fixed top-0 right-0 w-2/5 h-full bg-white transform translate-x-full transition-transform duration-300 z-50 rounded-l-lg" aria-label="Menu de navegação">
        <ul class="flex flex-col space-y-6 text-base font-semibold text-green-700 p-8">
            <li><a href="/" class="transition {{ request()->is('/') ? 'border-b-2 border-green-700' : '' }}">Home</a></li>
            <li><a href="/company" class="transition {{ request()->is('company') ? 'border-b-2 border-green-700' : '' }}">A Empresa</a></li>
            <li><a href="/service" class="transition {{ request()->is('service') ? 'border-b-2 border-green-700' : '' }}">Serviços</a></li>
            <li><a href="/quote" class="transition {{ request()->is('quote') ? 'border-b-2 border-green-700' : '' }}">Orçamento</a></li>
            <li><a href="/contact" class="transition {{ request()->is('contact') ? 'border-b-2 border-green-700' : '' }}">Contato</a></li>
        </ul>
    </nav>
</header>
<script>
    const menu = document.getElementById('menu');
    const menuToggle = document.getElementById('menu-toggle');
    const menuOverlay = document.getElementById('menu-overlay');

    menuToggle.addEventListener('click', function() {
        const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
        menu.style.transform = isExpanded ? 'translateX(100%)' : 'translateX(0)';
        menuOverlay.style.display = isExpanded ? 'none' : 'block';
        menuToggle.setAttribute('aria-expanded', !isExpanded);
    });

    function closeMenu() {
        menu.style.transform = 'translateX(100%)';
        menuOverlay.style.display = 'none';
        menuToggle.setAttribute('aria-expanded', 'false');
    }
</script>