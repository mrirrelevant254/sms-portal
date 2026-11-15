<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <nav class="bg-blue-900 border-b border-blue-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Left Side: Logo & Links -->
                <div class="flex items-center space-x-6">
                    <span class="text-white font-bold text-lg">
                        @role('admin|registrar')
                            Admin Portal
                        @else
                            Lecturer Portal
                        @endrole
                    </span>
                    
                        @role('admin|registrar')
                            <a href="{{ route('admin.students.index') }}" class="text-white hover:text-gray-300 text-sm font-medium">Manage Students</a>
                            <a href="{{ route('admin.lecturers.index') }}" class="text-white hover:text-gray-300 text-sm font-medium">Manage Lecturers</a>
                            <a href="{{ route('admin.timetable.index') }}" class="text-white hover:text-gray-300 text-sm font-medium">Manage Timetable</a>
                            <a href="{{ route('admin.requests.index') }}" class="text-white hover:text-gray-300 text-sm font-medium">Student Requests</a>
                        @endrole
                </div>
                
                <!-- Right Side: User Name & Logout -->
                <div class="flex items-center">
                    <span class="text-white text-sm me-4">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-white text-sm underline hover:text-gray-300">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @yield('content')
    </div>
</body>
</html>