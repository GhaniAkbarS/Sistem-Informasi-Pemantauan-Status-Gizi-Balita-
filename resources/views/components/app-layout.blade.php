<!doctype html>
<html lang="id">
<head>
    @include('includes.meta')
    @stack('before-style')
    @include('includes.style')
    @stack('after-style')
</head>
<body>
<div class="sip-shell">
    <x-nav-layout />
    <div class="sip-page">
        <header class="sip-topbar">
            <button type="button" class="sip-menu-toggle" id="sip-menu-toggle" aria-label="Buka menu" aria-controls="sip-sidebar" aria-expanded="false">
                <span data-sip-icon="menu"></span>
            </button>
            <div class="sip-topbar-title">SIP Gizi Balita</div>
            <div class="sip-topbar-user">{{ ucfirst(auth()->user()?->name ?? 'Pengguna') }}</div>
        </header>
        <main id="content" class="sip-content">
            {{ $slot }}
        </main>
    </div>
</div>
<button type="button" class="sip-sidebar-backdrop" id="sip-sidebar-backdrop" aria-label="Tutup menu" hidden></button>
@stack('before-script')
@include('includes.script')
@stack('after-script')
<script>
(() => {
    const button = document.getElementById('sip-menu-toggle');
    const backdrop = document.getElementById('sip-sidebar-backdrop');
    const sidebar = document.getElementById('sip-sidebar');
    if (!button || !backdrop || !sidebar) return;
    const setOpen = (open) => {
        document.body.classList.toggle('sip-menu-open', open);
        backdrop.hidden = !open;
        button.setAttribute('aria-expanded', String(open));
        button.setAttribute('aria-label', open ? 'Tutup menu' : 'Buka menu');
    };
    button.addEventListener('click', () => setOpen(!document.body.classList.contains('sip-menu-open')));
    backdrop.addEventListener('click', () => setOpen(false));
    sidebar.querySelectorAll('a').forEach(link => link.addEventListener('click', () => setOpen(false)));
    window.addEventListener('keydown', event => { if (event.key === 'Escape') setOpen(false); });
    window.addEventListener('resize', () => { if (window.innerWidth >= 768) setOpen(false); });
})();
</script>
</body>
</html>
