@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Welcome back, {{ Auth::user()->name }}</h1>

    <!-- Stats Grid - First Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Parishes -->
        <div class="bg-white rounded-lg p-6 shadow-sm">
            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-100 text-blue-600 mb-4">
                <i class="fas fa-church"></i>
            </div>
            <div class="text-2xl font-semibold mb-1">{{ $totalParishes }}</div>
            <div class="text-gray-600 text-sm">Total Parishes</div>
        </div>

        <!-- Total Requests -->
        <div class="bg-white rounded-lg p-6 shadow-sm">
            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-purple-100 text-purple-600 mb-4">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="text-2xl font-semibold mb-1">{{ $totalRequests }}</div>
            <div class="text-gray-600 text-sm">Total Requests</div>
        </div>

        <!-- Active Parishioners -->
        <div class="bg-white rounded-lg p-6 shadow-sm">
            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-green-100 text-green-600 mb-4">
                <i class="fas fa-users"></i>
            </div>
            <div class="text-2xl font-semibold mb-1">{{ $totalParishioners }}</div>
            <div class="text-gray-600 text-sm">Active Parishioners</div>
        </div>

        <!-- Total Certificates -->
        <div class="bg-white rounded-lg p-6 shadow-sm">
            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-orange-100 text-orange-600 mb-4">
                <i class="fas fa-certificate"></i>
            </div>
            <div class="text-2xl font-semibold mb-1">{{ $totalCertificates }}</div>
            <div class="text-gray-600 text-sm">Total Certificates</div>
        </div>
    </div>

    <!-- Stats Grid - Second Row (Certificate Types) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Baptismal Certificates -->
        <div class="bg-white rounded-lg p-6 shadow-sm">
            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-100 text-blue-600 mb-4">
                <i class="fas fa-baby"></i>
            </div>
            <div class="text-2xl font-semibold mb-1">{{ $baptismalCount }}</div>
            <div class="text-gray-600 text-sm">Baptismal Certificates</div>
        </div>

        <!-- Death Certificates -->
        <div class="bg-white rounded-lg p-6 shadow-sm">
            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-gray-100 text-gray-600 mb-4">
                <i class="fas fa-cross"></i>
            </div>
            <div class="text-2xl font-semibold mb-1">{{ $deathCount }}</div>
            <div class="text-gray-600 text-sm">Death Certificates</div>
        </div>

        <!-- Confirmation Certificates -->
        <div class="bg-white rounded-lg p-6 shadow-sm">
            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-purple-100 text-purple-600 mb-4">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="text-2xl font-semibold mb-1">{{ $confirmationCount }}</div>
            <div class="text-gray-600 text-sm">Confirmation Certificates</div>
        </div>
    </div>
@endsection
