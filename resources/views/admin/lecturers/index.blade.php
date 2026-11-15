@extends('layouts.lecturer')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Manage Lecturers</h2>
        <a href="{{ route('admin.lecturers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add New Lecturer</a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
    @endif

    <div class="bg-white shadow rounded-lg p-6">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b">
                    <th class="py-2">Name</th>
                    <th class="py-2">Email</th>
                    <th class="py-2">Date Added</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lecturers as $lecturer)
                    <tr class="border-b">
                        <td class="py-2 font-medium">{{ $lecturer->name }}</td>
                        <td class="py-2">{{ $lecturer->email }}</td>
                        <td class="py-2 text-gray-500">{{ $lecturer->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-4 text-center text-gray-500 italic">No lecturers registered yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection