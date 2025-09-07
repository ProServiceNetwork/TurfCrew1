<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', 'Turf Crew Alabama')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            /* Remove underlines from all links */
            a {
                text-decoration: none !important;
            }
            
            .carousel-container {
                position: relative;
                width: 100%;
                height: 24rem;
            }
            
            .carousel-slide {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                opacity: 0;
                transition: opacity 0.5s ease-in-out;
            }
            
            .carousel-slide.active {
                opacity: 1;
            }
            
            .carousel-indicator.active {
                background-color: rgba(255, 255, 255, 0.9);
            }
        </style>
        
        @stack('styles')
    </head>
    <body class="bg-green-600">
        <!-- Navigation -->
        <nav class="bg-green-600 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo/Brand -->
                    <div class="flex-shrink-0">
                        <a href="/" class="text-white text-xl font-bold">Turf Crew Alabama</a>
                    </div>
                    
                    <!-- Desktop Navigation -->
                    <div class="hidden lg:flex lg:items-center lg:space-x-8">
                        <!-- Left Navigation -->
                        <div class="flex items-center space-x-4">
                            <a href="/" class="text-white hover:text-green-200 px-3 py-2 transition-colors">Home</a>
                            <a href="#about" class="text-white hover:text-green-200 px-3 py-2 transition-colors">About</a>
                            
                            <!-- Dropdown -->
                            <div class="relative group">
                                <button type="button" class="text-white hover:text-green-200 px-3 py-2 flex items-center transition-colors" id="whyChooseUsDropdown">
                                    Why Choose Us
                                    <svg class="ml-1 h-4 w-4 transform transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20" id="dropdownArrow">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div class="absolute left-0 mt-2 w-56 bg-white rounded-md shadow-lg hidden z-50" id="dropdownMenu">
                                    <div class="py-1">
                                        <a href="/no-contracts" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">No Contracts</a>
                                        <a href="/professional-service" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Professional Service</a>
                                        <a href="/electronic-payments" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Electronic Payments</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Side Buttons -->
                        <div class="flex items-center space-x-3">
                            <!-- Request Service Button - visible at lg+ -->
                            <button class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-2 px-4 rounded transition-colors" onclick="openRequestModal()">
                                Request Service Now
                            </button>
                            
                            <!-- Authentication Buttons - only visible at xl+ -->
                            <div class="hidden xl:flex xl:items-center xl:space-x-3">
                                @if (Route::has('login'))
                                    @auth
                                        <a href="{{ url('/dashboard') }}" class="bg-transparent border border-white text-white hover:bg-white hover:text-green-600 font-semibold py-2 px-4 rounded transition-colors">Dashboard</a>
                                    @else
                                        <a href="{{ route('login') }}" class="bg-transparent border border-white text-white hover:bg-white hover:text-green-600 font-semibold py-2 px-4 rounded transition-colors">Login</a>
                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="bg-white text-green-600 hover:bg-gray-100 font-semibold py-2 px-4 rounded transition-colors">Register</a>
                                        @endif
                                    @endauth
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mobile menu button (full collapse) -->
                    <div class="lg:hidden">
                        <button type="button" class="text-white hover:text-green-200 focus:outline-none focus:text-green-200" id="mobile-menu-button">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                    
                    <!-- User menu button (auth-only collapse) -->
                    <div class="hidden lg:block xl:hidden relative">
                        <button type="button" class="text-white hover:text-green-200 focus:outline-none focus:text-green-200" id="user-menu-button">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </button>
                        <!-- User dropdown menu -->
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible user-dropdown z-50 transition-all duration-200">
                            <div class="py-1">
                                @if (Route::has('login'))
                                    @auth
                                        <a href="{{ url('/dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                        <form method="POST" action="{{ route('logout') }}" class="block">
                                            @csrf
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Login</a>
                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Register</a>
                                        @endif
                                    @endauth
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile menu -->
                <div class="lg:hidden hidden" id="mobile-menu">
                    <div class="px-2 pt-2 pb-3 space-y-1">
                        <a href="/" class="text-white hover:text-green-200 block px-3 py-2 transition-colors">Home</a>
                        <a href="#about" class="text-white hover:text-green-200 block px-3 py-2 transition-colors">About</a>
                        <a href="/no-contracts" class="text-white hover:text-green-200 block px-3 py-2 transition-colors">No Contracts</a>
                        <a href="/professional-service" class="text-white hover:text-green-200 block px-3 py-2 transition-colors">Professional Service</a>
                        <a href="/electronic-payments" class="text-white hover:text-green-200 block px-3 py-2 transition-colors">Electronic Payments</a>
                    </div>
                    <div class="pt-4 pb-3 border-t border-green-500">
                        <div class="px-2 space-y-1">
                            <button class="w-full bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-2 px-4 rounded transition-colors" onclick="openRequestModal()">
                                Request Service Now
                            </button>
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="w-full bg-transparent border border-white text-white hover:bg-white hover:text-green-600 font-semibold py-2 px-4 rounded transition-colors block text-center mt-2">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="w-full bg-transparent border border-white text-white hover:bg-white hover:text-green-600 font-semibold py-2 px-4 rounded transition-colors block text-center mt-2">Login</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="w-full bg-white text-green-600 hover:bg-gray-100 font-semibold py-2 px-4 rounded transition-colors block text-center mt-2">Register</a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Mobile Request Service Button (visible only on small screens) -->
        <div class="block lg:hidden bg-green-600 py-3">
            <div class="text-center px-4">
                <button class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold text-lg py-3 px-6 rounded transition-colors" onclick="openRequestModal()">
                    Request Service Now
                </button>
            </div>
        </div>

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        <!-- Request Service Modal -->
        <div class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" id="requestServiceModal">
            <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-2xl shadow-lg rounded-md bg-white">
                <div class="bg-green-600 text-white p-4 rounded-t-md -m-5 mb-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium" id="requestServiceModalLabel">
                            <svg class="inline w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2L3 7v11c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V7l-7-5z"/>
                            </svg>Request Service Now
                        </h3>
                        <button type="button" class="text-white hover:text-gray-300 focus:outline-none" onclick="closeModal('requestServiceModal')" aria-label="Close">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <form id="serviceRequestForm" action="/request-service" method="POST" novalidate>
                    @csrf
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- First Name -->
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" id="first_name" name="first_name" required maxlength="50" pattern="[A-Za-z\s\-'.]+" title="Only letters, spaces, hyphens, apostrophes, and periods allowed">
                                <div class="text-red-500 text-sm mt-1 hidden invalid-feedback">Please provide a valid first name.</div>
                            </div>
                            
                            <!-- Last Name -->
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" id="last_name" name="last_name" required maxlength="50" pattern="[A-Za-z\s\-'.]+" title="Only letters, spaces, hyphens, apostrophes, and periods allowed">
                                <div class="text-red-500 text-sm mt-1 hidden invalid-feedback">Please provide a valid last name.</div>
                            </div>
                        </div>
                        
                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Street Address <span class="text-red-500">*</span></label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" id="address" name="address" required maxlength="100" placeholder="123 Main Street">
                            <div class="text-red-500 text-sm mt-1 hidden invalid-feedback">Please provide a valid street address.</div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- City -->
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" id="city" name="city" required maxlength="50" pattern="[A-Za-z\s\-'.]+" title="Only letters, spaces, hyphens, apostrophes, and periods allowed">
                                <div class="text-red-500 text-sm mt-1 hidden invalid-feedback">Please provide a valid city name.</div>
                            </div>
                            
                            <!-- State -->
                            <div>
                                <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State <span class="text-red-500">*</span></label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" id="state" name="state" required>
                                    <option value="">Choose state...</option>
                                    <option value="AL">AL - Alabama</option>
                                    <option value="AK">AK - Alaska</option>
                                    <option value="AZ">AZ - Arizona</option>
                                    <option value="AR">AR - Arkansas</option>
                                    <option value="CA">CA - California</option>
                                    <option value="CO">CO - Colorado</option>
                                    <option value="CT">CT - Connecticut</option>
                                    <option value="DE">DE - Delaware</option>
                                    <option value="FL">FL - Florida</option>
                                    <option value="GA">GA - Georgia</option>
                                    <option value="HI">HI - Hawaii</option>
                                    <option value="ID">ID - Idaho</option>
                                    <option value="IL">IL - Illinois</option>
                                    <option value="IN">IN - Indiana</option>
                                    <option value="IA">IA - Iowa</option>
                                    <option value="KS">KS - Kansas</option>
                                    <option value="KY">KY - Kentucky</option>
                                    <option value="LA">LA - Louisiana</option>
                                    <option value="ME">ME - Maine</option>
                                    <option value="MD">MD - Maryland</option>
                                    <option value="MA">MA - Massachusetts</option>
                                    <option value="MI">MI - Michigan</option>
                                    <option value="MN">MN - Minnesota</option>
                                    <option value="MS">MS - Mississippi</option>
                                    <option value="MO">MO - Missouri</option>
                                    <option value="MT">MT - Montana</option>
                                    <option value="NE">NE - Nebraska</option>
                                    <option value="NV">NV - Nevada</option>
                                    <option value="NH">NH - New Hampshire</option>
                                    <option value="NJ">NJ - New Jersey</option>
                                    <option value="NM">NM - New Mexico</option>
                                    <option value="NY">NY - New York</option>
                                    <option value="NC">NC - North Carolina</option>
                                    <option value="ND">ND - North Dakota</option>
                                    <option value="OH">OH - Ohio</option>
                                    <option value="OK">OK - Oklahoma</option>
                                    <option value="OR">OR - Oregon</option>
                                    <option value="PA">PA - Pennsylvania</option>
                                    <option value="RI">RI - Rhode Island</option>
                                    <option value="SC">SC - South Carolina</option>
                                    <option value="SD">SD - South Dakota</option>
                                    <option value="TN">TN - Tennessee</option>
                                    <option value="TX">TX - Texas</option>
                                    <option value="UT">UT - Utah</option>
                                    <option value="VT">VT - Vermont</option>
                                    <option value="VA">VA - Virginia</option>
                                    <option value="WA">WA - Washington</option>
                                    <option value="WV">WV - West Virginia</option>
                                    <option value="WI">WI - Wisconsin</option>
                                    <option value="WY">WY - Wyoming</option>
                                </select>
                                <div class="text-red-500 text-sm mt-1 hidden invalid-feedback">Please select a state.</div>
                            </div>
                            
                            <!-- Zip Code -->
                            <div>
                                <label for="zip" class="block text-sm font-medium text-gray-700 mb-1">Zip Code <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" id="zip" name="zip" required pattern="[0-9]{5}(-[0-9]{4})?" maxlength="10" placeholder="12345" title="Enter 5 digit zip code or 5+4 format">
                                <div class="text-red-500 text-sm mt-1 hidden invalid-feedback">Please provide a valid 5-digit zip code.</div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Phone Number -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
                                <input type="tel" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" id="phone" name="phone" required pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" maxlength="12" placeholder="123-456-7890" title="Format: 123-456-7890">
                                <div class="text-red-500 text-sm mt-1 hidden invalid-feedback">Please provide a valid phone number (123-456-7890).</div>
                            </div>
                            
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                                <input type="email" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" id="email" name="email" required maxlength="100" placeholder="john@example.com">
                                <div class="text-red-500 text-sm mt-1 hidden invalid-feedback">Please provide a valid email address.</div>
                            </div>
                        </div>
                        
                        <!-- Privacy Notice -->
                        <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <div class="text-sm text-blue-800">
                                    <strong>Privacy Notice:</strong> Your information will only be used to contact you about lawn care services. We never share your personal information with third parties.
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 pt-6 border-t">
                        <button type="button" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" onclick="closeModal('requestServiceModal')">Cancel</button>
                        <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            Submit Request
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form validation and security
            const form = document.getElementById('serviceRequestForm');
            const phoneInput = document.getElementById('phone');
            
            // Phone number formatting
            if (phoneInput) {
                phoneInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length >= 6) {
                        value = value.substring(0,3) + '-' + value.substring(3,6) + '-' + value.substring(6,10);
                    } else if (value.length >= 3) {
                        value = value.substring(0,3) + '-' + value.substring(3,6);
                    }
                    e.target.value = value;
                });
            }
            
            // Form submission with validation
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    if (form.checkValidity()) {
                        // Additional custom validation
                        const firstName = document.getElementById('first_name').value.trim();
                        const lastName = document.getElementById('last_name').value.trim();
                        const email = document.getElementById('email').value.trim();
                        const phone = document.getElementById('phone').value.trim();
                        
                        // Basic XSS prevention - strip HTML tags
                        const stripHtml = (str) => str.replace(/<[^>]*>/g, '');
                        
                        // Validate names don't contain suspicious patterns
                        const namePattern = /^[A-Za-z\s\-'.]{1,50}$/;
                        if (!namePattern.test(firstName) || !namePattern.test(lastName)) {
                            alert('Names can only contain letters, spaces, hyphens, apostrophes, and periods.');
                            return;
                        }
                        
                        // Submit form to Laravel backend
                        const submitBtn = form.querySelector('button[type="submit"]');
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';
                        submitBtn.disabled = true;
                        
                        // Prepare form data
                        const formData = new FormData(form);
                        
                        // Submit to backend
                        fetch('/request-service', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || document.querySelector('input[name="_token"]').value
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message);
                                form.reset();
                                form.classList.remove('was-validated');
                                closeModal('requestServiceModal');
                            } else {
                                if (data.errors) {
                                    let errorMessage = 'Please correct the following errors:\n';
                                    Object.values(data.errors).forEach(error => {
                                        errorMessage += '• ' + error[0] + '\n';
                                    });
                                    alert(errorMessage);
                                } else {
                                    alert(data.message || 'An error occurred. Please try again.');
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while submitting your request. Please try again.');
                        })
                        .finally(() => {
                            submitBtn.innerHTML = '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>Submit Request';
                            submitBtn.disabled = false;
                        });
                    }
                    
                    form.classList.add('was-validated');
                });
            }
            
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
            
            // Dropdown functionality - "Why Choose Us"
            const dropdownToggle = document.getElementById('whyChooseUsDropdown');
            const dropdownMenu = document.getElementById('dropdownMenu');
            const dropdownArrow = document.getElementById('dropdownArrow');
            
            if (dropdownToggle && dropdownMenu) {
                dropdownToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const isHidden = dropdownMenu.classList.contains('hidden');
                    
                    if (isHidden) {
                        // Show dropdown
                        dropdownMenu.classList.remove('hidden');
                        if (dropdownArrow) dropdownArrow.style.transform = 'rotate(180deg)';
                    } else {
                        // Hide dropdown
                        dropdownMenu.classList.add('hidden');
                        if (dropdownArrow) dropdownArrow.style.transform = 'rotate(0deg)';
                    }
                });
            }
            
            // User menu dropdown functionality
            const userMenuButton = document.getElementById('user-menu-button');
            const userDropdown = document.querySelector('.user-dropdown');
            
            if (userMenuButton && userDropdown) {
                userMenuButton.addEventListener('click', function() {
                    userDropdown.classList.toggle('opacity-0');
                    userDropdown.classList.toggle('invisible');
                });
            }
            
            // Close dropdowns when clicking outside
            document.addEventListener('click', function(event) {
                // Close "Why Choose Us" dropdown
                if (dropdownToggle && dropdownMenu && !dropdownToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.add('hidden');
                    if (dropdownArrow) dropdownArrow.style.transform = 'rotate(0deg)';
                }
                
                // Close user dropdown
                if (userMenuButton && userDropdown && !userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
                    userDropdown.classList.add('opacity-0');
                    userDropdown.classList.add('invisible');
                }
            });
        });
        
        // Modal functions (global scope)
        function openRequestModal() {
            document.getElementById('requestServiceModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('requestServiceModal');
            if (event.target === modal) {
                closeModal('requestServiceModal');
            }
        });
        </script>
        
        @stack('scripts')
    </body>
</html>