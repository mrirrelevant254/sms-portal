@extends('layouts.lecturer')

@section('content')
    <div class="bg-white shadow rounded-lg p-6 max-w-2xl mx-auto">
        <h2 class="text-xl font-semibold mb-4">Register New Lecturer</h2>
        
        <form action="{{ route('admin.lecturers.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium">Full Name</label>
                <input type="text" name="name" class="mt-1 w-full border rounded px-3 py-2" placeholder="e.g., Dr. John Doe" required>
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Email Address</label>
                <input type="email" name="email" class="mt-1 w-full border rounded px-3 py-2" placeholder="lecturer@university.ac.ke" required>
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Password</label>
                <input type="text" name="password" class="mt-1 w-full border rounded px-3 py-2" placeholder="Set a temporary password" required>
                <p class="text-xs text-gray-500 mt-1">The lecturer will use this password to log in.</p>
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('admin.lecturers.index') }}" class="px-4 py-2 text-gray-600 hover:underline">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Create Lecturer Account</button>
            </div>
        </form>
    </div>
@endsection