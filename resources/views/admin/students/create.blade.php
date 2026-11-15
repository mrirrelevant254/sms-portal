@extends('layouts.lecturer')

@section('content')
    <div class="bg-white shadow rounded-lg p-6 max-w-2xl mx-auto">
        <h2 class="text-xl font-semibold mb-4">Enroll New Student</h2>
        
        <form action="{{ route('admin.students.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">First Name</label>
                    <input type="text" name="first_name" class="mt-1 w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Last Name</label>
                    <input type="text" name="last_name" class="mt-1 w-full border rounded px-3 py-2" required>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium">Email Address</label>
                <input type="email" name="email" class="mt-1 w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium">Registration Number</label>
                <input type="text" name="reg_no" placeholder="SC200/0001/2026" class="mt-1 w-full border rounded px-3 py-2" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">Programme</label>
                    <select name="programme_id" class="mt-1 w-full border rounded px-3 py-2" required>
                        @foreach($programmes as $prog)
                            <option value="{{ $prog->id }}">{{ $prog->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Campus</label>
                    <select name="campus_id" class="mt-1 w-full border rounded px-3 py-2" required>
                        @foreach($campuses as $campus)
                            <option value="{{ $campus->id }}">{{ $campus->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium">Year of Study</label>
                <input type="number" name="year_of_study" value="1" min="1" max="6" class="mt-1 w-full border rounded px-3 py-2" required>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Enroll Student</button>
        </form>
    </div>
@endsection