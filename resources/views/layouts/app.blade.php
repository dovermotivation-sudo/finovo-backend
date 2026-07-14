<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <script>
            // Language dropdown functionality
            document.addEventListener('DOMContentLoaded', function() {
                const languageDropdown = document.getElementById('languageDropdown');
                const languageMenu = document.getElementById('languageMenu');
                
                if (languageDropdown && languageMenu) {
                    languageDropdown.addEventListener('click', function(e) {
                        e.preventDefault();
                        languageMenu.classList.toggle('hidden');
                    });

                    // Close dropdown when clicking outside
                    document.addEventListener('click', function(e) {
                        if (!languageDropdown.contains(e.target)) {
                            languageMenu.classList.add('hidden');
                        }
                    });

                    // Handle language selection
                    const languageOptions = languageMenu.querySelectorAll('.language-option');
                    languageOptions.forEach(option => {
                        option.addEventListener('click', function(e) {
                            e.preventDefault();
                            const selectedLang = this.getAttribute('data-lang');
                            const selectedFlag = this.getAttribute('data-flag');
                            const selectedText = this.getAttribute('data-text');
                            
                            // Update dropdown button
                            const dropdownImg = languageDropdown.querySelector('img');
                            const dropdownSpan = languageDropdown.querySelector('span');
                            
                            if (dropdownImg && dropdownSpan) {
                                dropdownImg.src = selectedFlag;
                                dropdownSpan.textContent = selectedLang.toUpperCase();
                            }
                            
                            // Update check marks
                            document.querySelectorAll('.language-check').forEach(check => {
                                check.classList.add('hidden');
                            });
                            this.querySelector('.language-check').classList.remove('hidden');
                            
                            // Store in localStorage
                            localStorage.setItem('selectedLanguage', selectedLang);
                            localStorage.setItem('selectedFlag', selectedFlag);
                            localStorage.setItem('selectedText', selectedText);
                            
                            // Close dropdown
                            languageMenu.classList.add('hidden');
                            
                            // Switch language via AJAX
                            fetch(`/language/${selectedLang}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Reload page to apply new language
                                    window.location.reload();
                                }
                            })
                            .catch(error => {
                                console.error('Language switch error:', error);
                            });
                        });
                    });

                    // Load saved language on page load
                    const savedLang = localStorage.getItem('selectedLanguage');
                    const savedFlag = localStorage.getItem('selectedFlag');
                    
                    if (savedLang && savedFlag) {
                        const dropdownImg = languageDropdown.querySelector('img');
                        const dropdownSpan = languageDropdown.querySelector('span');
                        
                        if (dropdownImg && dropdownSpan) {
                            dropdownImg.src = savedFlag;
                            dropdownSpan.textContent = savedLang.toUpperCase();
                        }
                        
                        // Update check marks
                        document.querySelectorAll('.language-check').forEach(check => {
                            check.classList.add('hidden');
                        });
                        const currentOption = document.querySelector(`[data-lang="${savedLang}"]`);
                        if (currentOption) {
                            currentOption.querySelector('.language-check').classList.remove('hidden');
                        }
                    }
                }
            });

            // Slider functionality
            let slideIndex = {};

            function plusSlides(n, sliderId) {
                showSlides(slideIndex[sliderId] += n, sliderId);
            }

            function currentSlide(n, sliderId) {
                showSlides(slideIndex[sliderId] = n, sliderId);
            }

            function showSlides(n, sliderId) {
                const slider = document.getElementById(sliderId);
                if (!slider) return;
                
                const slides = slider.getElementsByClassName("slide");
                const dots = slider.parentElement.getElementsByClassName("dot");
                
                if (n > slides.length) {slideIndex[sliderId] = 1}
                if (n < 1) {slideIndex[sliderId] = slides.length}
                
                // Remove all classes first
                for (let i = 0; i < slides.length; i++) {
                    slides[i].classList.remove("active", "prev", "next");
                }
                
                // Set current slide as active
                if (slides[slideIndex[sliderId] - 1]) {
                    slides[slideIndex[sliderId] - 1].classList.add("active");
                }
                
                // Set previous slides
                for (let i = 0; i < slideIndex[sliderId] - 1; i++) {
                    slides[i].classList.add("prev");
                }
                
                // Set next slides
                for (let i = slideIndex[sliderId]; i < slides.length; i++) {
                    slides[i].classList.add("next");
                }
                
                // Update dots
                for (let i = 0; i < dots.length; i++) {
                    dots[i].classList.remove("active");
                    dots[i].style.opacity = "0.3";
                }
                
                if (dots[slideIndex[sliderId] - 1]) {
                    dots[slideIndex[sliderId] - 1].classList.add("active");
                    dots[slideIndex[sliderId] - 1].style.opacity = "0.5";
                }
            }

            // Initialize sliders
            document.addEventListener('DOMContentLoaded', function() {
                const sliders = ['userSlider', 'adminSlider'];
                sliders.forEach(sliderId => {
                    const slider = document.getElementById(sliderId);
                    if (slider) {
                        slideIndex[sliderId] = 1;
                        showSlides(slideIndex[sliderId], sliderId);
                        
                        // Auto slide every 5 seconds
                        setInterval(() => {
                            plusSlides(1, sliderId);
                        }, 5000);
                    }
                });
            });
        </script>

        <style>
            .slider-container {
                position: relative;
                overflow: hidden;
                height: 160px; /* Set fixed height for slider */
            }
            
            .slider-container .slide {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                transform: translateX(100%);
                transition: transform 0.5s ease-in-out;
                opacity: 0;
                display: block !important; /* Force display */
            }
            
            .slider-container .slide.active {
                transform: translateX(0);
                opacity: 1;
                z-index: 2;
            }
            
            .slider-container .slide.prev {
                transform: translateX(-100%);
                opacity: 0;
                z-index: 1;
            }
            
            .slider-container .slide.next {
                transform: translateX(100%);
                opacity: 0;
                z-index: 1;
            }
            
            .dot.active {
                opacity: 0.5 !important;
            }
        </style>
    </body>
</html>
