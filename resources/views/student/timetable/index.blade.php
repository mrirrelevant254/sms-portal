<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Timetable</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6">
            @if($slots->isEmpty())
                <p class="text-sm text-gray-500 italic">No timetable slots have been published for your registered units yet.</p>
            @else
                <table class="w-full text-sm text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-3">Day</th>
                            <th class="border p-3">Time</th>
                            <th class="border p-3">Code</th>
                            <th class="border p-3">Unit Title</th>
                            <th class="border p-3">Venue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($slots as $slot)
                            <tr class="hover:bg-gray-50">
                                <td class="border p-3 font-semibold">{{ $slot->day_of_week }}</td>
                                <td class="border p-3">{{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}</td>
                                <td class="border p-3">{{ $slot->unit->code }}</td>
                                <td class="border p-3">{{ $slot->unit->title }}</td>
                                <td class="border p-3">{{ $slot->venue }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>