@extends('layouts.app-with-navbar')

@section('title', 'Turf Crew Alabama - Professional Lawn Care')

@push('styles')
<style>
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
@endpush

@section('content')
<!-- Hero Carousel -->
<div id="heroCarousel" class="relative overflow-hidden">
    <!-- Carousel indicators -->
    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2 z-10">
        <button type="button" class="w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-75 transition-all carousel-indicator active" data-slide="0"></button>
        <button type="button" class="w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-75 transition-all carousel-indicator" data-slide="1"></button>
        <button type="button" class="w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-75 transition-all carousel-indicator" data-slide="2"></button>
    </div>
    
    <div class="carousel-container">
        <!-- Slide 1 -->
        <div class="carousel-slide active bg-green-600 h-96 flex items-center justify-center">
            <div class="text-center text-white px-4">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Professional Lawn Care</h1>
                <p class="text-xl md:text-2xl">Transform your lawn with Turf Crew Alabama</p>
            </div>
        </div>
        <!-- Slide 2 -->
        <div class="carousel-slide bg-blue-600 h-96 flex items-center justify-center">
            <div class="text-center text-white px-4">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">No Contracts Required</h1>
                <p class="text-xl md:text-2xl">Flexible service without long-term commitments</p>
            </div>
        </div>
        <!-- Slide 3 -->
        <div class="carousel-slide bg-yellow-500 h-96 flex items-center justify-center">
            <div class="text-center text-gray-800 px-4">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Electronic Payments</h1>
                <p class="text-xl md:text-2xl">Convenient and secure payment options</p>
            </div>
        </div>
    </div>
    
    <!-- Navigation arrows -->
    <button class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-300 transition-colors z-10" id="carousel-prev">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>
    <button class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-300 transition-colors z-10" id="carousel-next">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>
</div>

<!-- Why Choose Us Cards -->
<section class="py-12 bg-green-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <!-- No Contracts Card -->
            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 h-full flex flex-col">
                <div class="p-6 flex flex-col h-full">
                    <h5 class="text-xl font-bold text-green-600 mb-4">No Contracts</h5>
                    <p class="text-gray-600 flex-grow">We believe in earning your trust through quality service, not binding contracts. You're free to choose our services based on satisfaction and results, giving you complete flexibility and peace of mind.</p>
                    <div class="mt-6">
                        <a href="/no-contracts" class="inline-block px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">Read More</a>
                    </div>
                </div>
            </div>
            
            <!-- Professional Service Card -->
            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 h-full flex flex-col">
                <div class="p-6 flex flex-col h-full">
                    <h5 class="text-xl font-bold text-green-600 mb-4">Professional Service</h5>
                    <p class="text-gray-600 flex-grow">Our trained professionals use commercial-grade equipment and proven techniques to deliver exceptional results. We take pride in treating every lawn with the attention and expertise it deserves.</p>
                    <div class="mt-6">
                        <a href="/professional-service" class="inline-block px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">Read More</a>
                    </div>
                </div>
            </div>
            
            <!-- Electronic Payments Card -->
            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 h-full flex flex-col">
                <div class="p-6 flex flex-col h-full">
                    <h5 class="text-xl font-bold text-green-600 mb-4">Electronic Payments</h5>
                    <p class="text-gray-600 flex-grow">Skip the hassle of checks and cash with our secure electronic payment system. Automatic billing and online payment options make managing your lawn care service simple and convenient.</p>
                    <div class="mt-6">
                        <a href="/electronic-payments" class="inline-block px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Carousel functionality
    let currentSlide = 0;
    const slides = document.querySelectorAll('.carousel-slide');
    const indicators = document.querySelectorAll('.carousel-indicator');
    const totalSlides = slides.length;
    
    function showSlide(index) {
        slides.forEach(slide => slide.classList.remove('active'));
        indicators.forEach(indicator => indicator.classList.remove('active'));
        
        slides[index].classList.add('active');
        indicators[index].classList.add('active');
        currentSlide = index;
    }
    
    function nextSlide() {
        const next = (currentSlide + 1) % totalSlides;
        showSlide(next);
    }
    
    function prevSlide() {
        const prev = (currentSlide - 1 + totalSlides) % totalSlides;
        showSlide(prev);
    }
    
    // Carousel controls
    document.getElementById('carousel-next').addEventListener('click', nextSlide);
    document.getElementById('carousel-prev').addEventListener('click', prevSlide);
    
    // Carousel indicators
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => showSlide(index));
    });
    
    // Auto-rotate carousel
    setInterval(nextSlide, 5000);
});
</script>
@endpush