@extends('layouts.app-with-navbar')

@section('title', 'Professional Service - Turf Crew Alabama')

@section('content')
<!-- Page Header -->
<div class="bg-green-600 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Professional Service</h1>
        <p class="text-xl text-green-100">Commercial-grade expertise for your lawn</p>
    </div>
</div>

<!-- Page Content -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Image Column -->
            <div class="order-2 lg:order-1">
                <div class="bg-gray-100 rounded-lg p-8 text-center h-96 flex items-center justify-center">
                    <div>
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                        </svg>
                        <p class="text-gray-500">Image Placeholder<br>400px height</p>
                    </div>
                </div>
            </div>

            <!-- Content Column -->
            <div class="order-1 lg:order-2">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Excellence in Every Detail</h2>
                
                <div class="space-y-6 text-gray-600">
                    <p class="text-lg">
                        At Turf Crew Alabama, professionalism isn't just a promise – it's our foundation. Our trained and experienced team brings commercial-grade expertise to every lawn, treating your property with the same care and attention we'd give our own.
                    </p>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-green-600 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Expert Training & Education</h3>
                                <p>Our crew receives ongoing training in the latest lawn care techniques, safety protocols, and customer service standards.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-green-600 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Commercial-Grade Equipment</h3>
                                <p>We use professional equipment that delivers superior results compared to typical residential tools.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-green-600 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Reliable Service</h3>
                                <p>We arrive on schedule, in uniform, with properly maintained equipment and respect for your property.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8">
                        <button class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg transition-colors duration-300" onclick="openRequestModal()">
                            Experience Professional Service
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection