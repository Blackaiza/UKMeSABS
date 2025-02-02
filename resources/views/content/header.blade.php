<nav id="navbar" class="bg-white dark:bg-gray-900 border-gray-200 px-4 lg:px-6 py-2.5 sticky-navbar">
    <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
        <!-- Logo Section -->
        <a href="#home" class="flex items-center" id="logo-container">
            <img src="{{ asset('images/ukmesportlogo.png') }}" class="mr-3 h-6 sm:h-9" alt="UKMEsport Logo" id="navbar-logo" />
            <span class="self-center text-xl font-semibold whitespace-nowrap text-black dark:text-white" id="navbar-text">UKM Esport</span>
        </a>

        <!-- Right-side buttons and Mobile Menu Button -->
        <div class="flex items-center lg:order-2">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Log in
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Register
                        </a>
                    @endif
                @endauth
            @endif
            <button data-collapse-toggle="mobile-menu-2" type="button" class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="mobile-menu-2" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
        </div>

        <!-- Navbar Links -->
        <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
            <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                {{-- <li><a href="#home" class="block py-2 pr-4 pl-3 text-white rounded bg-primary-700 lg:bg-transparent lg:text-primary-700 lg:p-0 dark:text-white" aria-current="page">Home</a></li> --}}
                <li><a href="#home" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Main</a></li>
                <li><a href="#galeri" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Gallery</a></li>
                <li><a href="#staff" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Staff</a></li>
                <li><a href="#contact" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

{{-- <!-- Content Sections for smooth scrolling -->
<div id="home" class="h-screen bg-gray-100">Home Section</div>
<div id="galeri" class="h-screen bg-gray-200">Gallery Section</div>
<div id="contact" class="h-screen bg-gray-300">Contact Section</div> --}}

<script>
window.onscroll = function() { changeNavbarAppearance() };

function changeNavbarAppearance() {
    const navbar = document.getElementById("navbar");
    const logo = document.getElementById("navbar-logo");
    const text = document.getElementById("navbar-text");

    if (window.scrollY > 50) {
        navbar.classList.add('scroll-down');
        logo.style.opacity = 1;
        text.style.visibility = 'hidden'; // Hide text on scroll
    } else {
        navbar.classList.remove('scroll-down');
        logo.style.opacity = 1;
        text.style.visibility = 'visible'; // Show text when not scrolling
    }
}

// Smooth scroll for internal links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});
</script>

<style>
/* Sticky navbar */
.sticky-navbar {
    position: sticky;
    top: 0;
    z-index: 1000;
    transition: opacity 0.3s ease, background-color 0.3s ease, backdrop-filter 0.3s ease;
}

/* Opacity and blur effect when scrolling */
.sticky-navbar.scroll-down {
    opacity: 0.8; /* Adjust opacity as desired */
    background-color: rgba(0, 0, 0, 0.5); /* Optional: change background when scrolling */
    backdrop-filter: blur(5px); /* Add blur effect */
}

/* Logo visibility on scroll */
#navbar-logo {
    transition: opacity 0.3s ease;
}

/* When scrolling down, logo becomes visible */
.sticky-navbar.scroll-down #navbar-logo {
    opacity: 1;
}

/* Text color change based on mode */
#navbar-text {
    color: #000000;  /* Dark text for light mode */
}

/* Text color for dark mode */
@media (prefers-color-scheme: dark) {
    #navbar-text {
        color: #ffffff;  /* White text for dark mode */
    }
}

/* Text color for light mode when in dark mode */
@media (prefers-color-scheme: light) {
    #navbar-text {
        color: #000000;  /* Dark text for light mode */
    }
}

/* When scrolling down, text color changes */
.sticky-navbar.scroll-down #navbar-text {
    color: #fff;
}

/* Hover effect for navbar links */
/* a:hover {
    background-color: #12f206; /* Hover background green */
    color: white; /* Change text color to white on hover */
} */
</style>
