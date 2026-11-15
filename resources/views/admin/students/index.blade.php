@extends('layouts.lecturer') {{-- Reusing the blue admin layout we made earlier --}}

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Enrolled Students</h2>
        <a href="{{ route('admin.students.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add New Student</a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
    @endif

    <div class="bg-white shadow rounded-lg p-6">
        <table class="w-full text-sm">
            <thead><tr class="text-left border-b"><th class="py-2">Reg No</th><th class="py-2">Name</th><th class="py-2">Programme</th><th class="py-2">Year</th><th class="py-2">Status</th></tr></thead>
            <tbody>
                @foreach($students as $student)
                    <tr class="border-b">
                        <td class="py-2">{{ $student->reg_no }}</td>
                        <td class="py-2">{{ $student->full_name }}</td>
                        <td class="py-2">{{ $student->programme->name }}</td>
                        <td class="py-2">Y{{ $student->year_of_study }}</td>
                        <td class="py-2"><span class="px-2 py-1 bg-green-100 text-green-800 rounded">{{ ucfirst($student->status) }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection