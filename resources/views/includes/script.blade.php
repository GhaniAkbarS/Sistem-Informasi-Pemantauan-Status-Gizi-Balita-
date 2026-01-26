    <!-- Script app layout -->
    <script>
        function toggleMenu() {
            const menu = document.getElementById('navbarMenu');
            menu.classList.toggle('active');
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('navbarMenu');
            const toggle = document.querySelector('.navbar-toggle');

            if (!menu.contains(event.target) && !toggle.contains(event.target)) {
                menu.classList.remove('active');
            }
        });
    </script>
    
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <!-- Perubahan dari ././  -->
    <script src="{{ asset('tabler/js/tabler.min.js?1692870487') }}" defer></script>
    <script src="{{ asset('tabler/js/demo.min.js?1692870487') }}" defer></script>
    <!-- 