<!-- JavaScript Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

<script src=" {{ asset('lib/wow/wow.min.js') }} "></script>
<script src=" {{ asset('lib/owlcarousel/owl.carousel.min.js') }} "></script>


<!-- Template Javascript -->
<script src=" {{ asset('js/main.js') }} "></script>
<script>
    (function () {
        var nav = document.getElementById('mainNav');
        var navTop = document.getElementById('navBarTop');
        if (!nav || !navTop) return;

        function setInitialHeight() {
            navTop.style.setProperty('--nav-top-height', navTop.scrollHeight + 'px');
        }
        setInitialHeight();
        window.addEventListener('resize', setInitialHeight);

        var ticking = false;

        function update() {
            if (!nav.classList.contains('scrolled') && window.scrollY > 80) {
                nav.classList.add('scrolled');
            } else if (nav.classList.contains('scrolled') && window.scrollY < 20) {
                nav.classList.remove('scrolled');
            }
            ticking = false;
        }

        function onScroll() {
            if (!ticking) {
                requestAnimationFrame(update);
                ticking = true;
            }
        }

        window.addEventListener('scroll', onScroll);
        update();
    })();
</script>
