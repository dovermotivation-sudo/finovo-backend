<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XPO Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .kyc-banner {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #8b5cf6 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="gradient-bg text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="bg-white bg-opacity-20 rounded-lg p-2">
                        <span class="text-2xl font-bold">XxxxxPO</span>
                    </div>
                </div>
                
                <!-- Right side -->
                <div class="flex items-center space-x-4">
                    <!-- Language Dropdown -->
                    <div class="relative">
                        <button id="languageDropdown" class="flex items-center space-x-2 bg-white bg-opacity-20 rounded-lg px-3 py-2 hover:bg-opacity-30 transition-colors">
                            <i class="fas fa-globe text-lg"></i>
                            <img src="https://flagcdn.com/w20/gb.png" alt="EN" class="w-5 h-3">
                            <span class="text-sm font-medium">EN</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="languageMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 hidden z-50">
                            <div class="py-2">
                                <a href="#" class="flex items-center space-x-3 px-4 py-2 hover:bg-gray-100 transition-colors" data-lang="en">
                                    <img src="https://flagcdn.com/w20/gb.png" alt="English" class="w-5 h-3">
                                    <span class="text-gray-700">English</span>
                                    <i class="fas fa-check text-blue-600 ml-auto"></i>
                                </a>
                                <a href="#" class="flex items-center space-x-3 px-4 py-2 hover:bg-gray-100 transition-colors" data-lang="es">
                                    <img src="https://flagcdn.com/w20/es.png" alt="Spanish" class="w-5 h-3">
                                    <span class="text-gray-700">Español</span>
                                </a>
                                <a href="#" class="flex items-center space-x-3 px-4 py-2 hover:bg-gray-100 transition-colors" data-lang="fr">
                                    <img src="https://flagcdn.com/w20/fr.png" alt="French" class="w-5 h-3">
                                    <span class="text-gray-700">Français</span>
                                </a>
                                <a href="#" class="flex items-center space-x-3 px-4 py-2 hover:bg-gray-100 transition-colors" data-lang="de">
                                    <img src="https://flagcdn.com/w20/de.png" alt="German" class="w-5 h-3">
                                    <span class="text-gray-700">Deutsch</span>
                                </a>
                                <a href="#" class="flex items-center space-x-3 px-4 py-2 hover:bg-gray-100 transition-colors" data-lang="zh">
                                    <img src="https://flagcdn.com/w20/cn.png" alt="Chinese" class="w-5 h-3">
                                    <span class="text-gray-700">中文</span>
                                </a>
                                <a href="#" class="flex items-center space-x-3 px-4 py-2 hover:bg-gray-100 transition-colors" data-lang="ja">
                                    <img src="https://flagcdn.com/w20/jp.png" alt="Japanese" class="w-5 h-3">
                                    <span class="text-gray-700">日本語</span>
                                </a>
                                <a href="#" class="flex items-center space-x-3 px-4 py-2 hover:bg-gray-100 transition-colors" data-lang="hi">
                                    <img src="https://flagcdn.com/w20/in.png" alt="Hindi" class="w-5 h-3">
                                    <span class="text-gray-700">हिन्दी</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Other Icons -->
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-bell text-lg hover:text-blue-200 cursor-pointer transition-colors"></i>
                        <i class="fas fa-cog text-lg hover:text-blue-200 cursor-pointer transition-colors"></i>
                        <i class="fas fa-chart-bar text-lg hover:text-blue-200 cursor-pointer transition-colors"></i>
                    </div>
                    
                    <!-- User Profile -->
                    <div class="flex items-center space-x-2 bg-white bg-opacity-20 rounded-full px-3 py-2">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <span class="text-sm font-semibold">{{ substr(auth()->user()->name ?? 'N', 0, 1) }}</span>
                        </div>
                        <span class="text-sm">{{ auth()->user()->name ?? 'Nirmal' }}</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation Tabs -->
    <nav class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex space-x-8">
                <a href="{{ route('dashboard') }}" class="border-b-2 border-blue-500 text-blue-600 py-4 px-1 text-sm font-medium flex items-center space-x-2">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('user.dashboard') }}" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 text-sm font-medium flex items-center space-x-2">
                    <i class="fas fa-user-circle"></i>
                    <span>User Dashboard</span>
                </a>
                <a href="{{ route('crypto') }}" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 text-sm font-medium flex items-center space-x-2">
                    <i class="fab fa-bitcoin"></i>
                    <span>Crypto</span>
                </a>
                <a href="{{ route('derivative') }}" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 text-sm font-medium flex items-center space-x-2">
                    <i class="fas fa-chart-area"></i>
                    <span>Derivative</span>
                </a>
                <a href="{{ route('fix-flex') }}" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 text-sm font-medium flex items-center space-x-2">
                    <i class="fas fa-coins"></i>
                    <span>Fix Flex</span>
                </a>
                <a href="{{ route('compare') }}" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 text-sm font-medium flex items-center space-x-2">
                    <i class="fas fa-balance-scale"></i>
                    <span>Compare</span>
                </a>
                <div class="ml-auto">
                    <a href="{{ route('kyc.application') }}" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 text-sm font-medium flex items-center space-x-2">
                        <i class="fas fa-user-check"></i>
                        <span>KYC Application</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Welcome</h1>
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Your dashboard</h2>
            <p class="text-gray-600">At a glance summary of your investment account.</p>
            <p class="text-gray-600">Have fun!</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-8">
                <!-- KYC Banner -->
                <div class="kyc-banner rounded-xl p-6 text-white relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold mb-2">Complete KYC Now</h3>
                        <p class="text-blue-100 mb-4">Verify your identity to secure your account and unlock full services. Log in and complete your KYC today!</p>
                        <button class="bg-white text-blue-600 px-6 py-2 rounded-lg font-semibold hover:bg-blue-50 transition-colors">
                            Start KYC
                        </button>
                    </div>
                    <!-- Decorative illustration -->
                    <div class="absolute right-4 top-4 opacity-20">
                        <div class="w-32 h-32 bg-white rounded-full flex items-center justify-center">
                            <i class="fas fa-user-shield text-6xl text-blue-600"></i>
                        </div>
                    </div>
                </div>

                <!-- Investment Overview -->
                <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Investment Overview</h3>
                    <p class="text-gray-600 text-sm mb-4">The investment overview of your platform. All Investment</p>
                    
                    <div class="flex space-x-4 mb-6">
                        <button class="px-4 py-2 bg-blue-100 text-blue-600 rounded-lg text-sm font-medium">Overview</button>
                        <button class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm font-medium">Six Months</button>
                        <button class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm font-medium">One Year</button>
                    </div>
                    
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-chart-line text-4xl mb-4"></i>
                        <p>No investment data available</p>
                    </div>
                </div>

                <!-- My Investment -->
                <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">My Investment</h3>
                    <p class="text-gray-600 text-sm mb-4">Your recent 5 purchased portfolio returns.</p>
                    
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-folder-open text-4xl mb-4"></i>
                        <p>No record Found.</p>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-8">
                <!-- User Profile Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-blue-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <i class="fas fa-user text-white text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ auth()->user()->name ?? 'nirmal kumar' }}</h3>
                        <p class="text-gray-600 text-sm">{{ auth()->user()->email ?? 'nk50173@gmail.com' }}</p>
                    </div>
                    
                    <!-- <div class="flex space-x-3">
                        <button class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                            Deposit
                        </button>
                        <button class="flex-1 bg-green-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-green-700 transition-colors">
                            Withdraw
                        </button>
                    </div> -->
                </div>

                <!-- Wallet Section -->
                <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Your wallet</h3>
                    
                    
                </div>

                <!-- Top Portfolio -->
                <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Top Portfolio</h3>
                    <p class="text-gray-600 text-sm mb-4">In last 30 days top portfolio plans.</p>
                    
                    <div class="space-y-3">
                        <!-- Sample portfolio item -->
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                            <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold text-sm">F</span>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">FUNIX</h4>
                                <p class="text-gray-600 text-xs">Apr 7 Indian Rupee</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-900">In-flux</p>
                                <p class="text-green-600 text-xs">+49.20%</p>
                            </div>
                        </div>
                        
                        <div class="text-center py-4 text-gray-500">
                            <p class="text-sm">More portfolio data coming soon...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Add any interactive functionality here
        document.addEventListener('DOMContentLoaded', function() {
            // Animate cards on load
            const cards = document.querySelectorAll('.card-hover');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Language dropdown functionality
            const languageDropdown = document.getElementById('languageDropdown');
            const languageMenu = document.getElementById('languageMenu');
            const languageOptions = document.querySelectorAll('[data-lang]');

            // Toggle dropdown
            languageDropdown.addEventListener('click', function(e) {
                e.preventDefault();
                languageMenu.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!languageDropdown.contains(e.target) && !languageMenu.contains(e.target)) {
                    languageMenu.classList.add('hidden');
                }
            });

            // Language selection
            languageOptions.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const selectedLang = this.getAttribute('data-lang');
                    const selectedFlag = this.querySelector('img').src;
                    const selectedText = this.querySelector('span').textContent;
                    
                    // Update button display
                    const buttonFlag = languageDropdown.querySelector('img');
                    const buttonText = languageDropdown.querySelector('span');
                    
                    buttonFlag.src = selectedFlag;
                    buttonText.textContent = getLanguageCode(selectedLang);
                    
                    // Update check marks
                    document.querySelectorAll('[data-lang] .fa-check').forEach(check => {
                        check.style.display = 'none';
                    });
                    this.querySelector('.fa-check').style.display = 'inline';
                    
                    // Close dropdown
                    languageMenu.classList.add('hidden');
                    
                    // Store selection in localStorage
                    localStorage.setItem('selectedLanguage', selectedLang);
                    
                    // Here you can add actual language switching logic
                    console.log('Language changed to:', selectedLang);
                });
            });

            // Helper function to get language codes
            function getLanguageCode(lang) {
                const codes = {
                    'en': 'EN',
                    'es': 'ES',
                    'fr': 'FR',
                    'de': 'DE',
                    'zh': 'ZH',
                    'ja': 'JP',
                    'hi': 'HI'
                };
                return codes[lang] || 'EN';
            }

            // Load saved language preference
            const savedLanguage = localStorage.getItem('selectedLanguage');
            if (savedLanguage) {
                const savedOption = document.querySelector(`[data-lang="${savedLanguage}"]`);
                if (savedOption) {
                    savedOption.click();
                }
            }
        });
    </script>
</body>
</html>
