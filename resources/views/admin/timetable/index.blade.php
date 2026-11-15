@extends('layouts.lecturer')

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-4">Manage Timetable</h2>
        @if(session('success'))
            <div class="p-4 bg-green-100 text-green-800 rounded mb-4">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.timetable.store') }}" method="POST" class="bg-white shadow rounded-lg p-4 flex gap-4 items-end flex-wrap">
            @csrf
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-medium">Unit</label>
                <select name="unit_id" class="w-full border rounded p-2 text-sm" required>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->code }} - {{ $unit->title }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium">Day</label>
                <select name="day_of_week" class="border rounded p-2 text-sm" required>
                    <option>Monday</option><option>Tuesday</option><option>Wednesday</option>
                    <option>Thursday</option><option>Friday</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium">Start Time</label>
                <input type="time" name="start_time" class="border rounded p-2 text-sm" required>
            </div>
            <div>
                <label class="block text-xs font-medium">End Time</label>
                <input type="time" name="end_time" class="border rounded p-2 text-sm" required>
            </div>
            <div>
                <label class="block text-xs font-medium">Venue</label>
                <input type="text" name="venue" placeholder="e.g., LT-1" class="border rounded p-2 text-sm" required>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">Add Slot</button>
        </form>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <table class="w-full text-sm text-left">
            <thead><tr class="border-b"><th class="py-2">Day</th><th>Time</th><th>Unit</th><th>Venue</th></tr></thead>
            <tbody>
                @foreach($slots as $slot)
                    <tr class="border-b">
                        <td class="py-2">{{ $slot->day_of_week }}</td>
                        <td>{{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}</td>
                        <td>{{ $slot->unit->code }}</td>
                        <td>{{ $slot->venue }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection