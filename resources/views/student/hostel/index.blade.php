<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Hostel Booking</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        @if(session('success'))
            <div class="p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="p-4 bg-red-100 text-red-800 rounded-lg">{{ session('error') }}</div>
        @endif

        {{-- If already booked, show summary --}}
        @if($currentBooking)
            <div class="bg-white shadow rounded-lg p-6 border-l-4 border-green-500">
                <h3 class="font-semibold text-lg mb-4 text-green-700">Your Booking is Confirmed</h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div><dt class="text-gray-500">Hostel</dt><dd class="font-bold">{{ $currentBooking->room->hostel->name }}</dd></div>
                    <div><dt class="text-gray-500">Room</dt><dd class="font-bold">{{ $currentBooking->room->room_no }}</dd></div>
                    <div><dt class="text-gray-500">Status</dt><dd class="uppercase text-green-600">{{ $currentBooking->status }}</dd></div>
                    <div><dt class="text-gray-500">Booked On</dt><dd>{{ $currentBooking->booked_at->format('d M Y') }}</dd></div>
                </dl>
                <div class="mt-4 pt-4 border-t text-sm text-gray-600">
                    Note: The hostel fee has been added to your fee statement. Please check the Finances tab.
                </div>
            </div>
        @else
            {{-- Show available hostels --}}
            @foreach($hostels as $hostel)
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-1">{{ $hostel->name }} ({{ ucfirst($hostel->gender) }})</h3>
                    <p class="text-sm text-gray-500 mb-4">Location: {{ $hostel->location }}</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($hostel->rooms as $room)
                            <div class="border rounded-lg p-4 flex flex-col justify-between {{ $room->isFull() ? 'bg-gray-50' : 'bg-white' }}">
                                <div>
                                    <h4 class="font-bold text-gray-800">Room {{ $room->room_no }}</h4>
                                    <p class="text-xs text-gray-500">Capacity: {{ $room->capacity }} students</p>
                                    <p class="text-lg font-semibold mt-2">KES {{ number_format($room->fee) }} <span class="text-xs text-gray-500 font-normal">/ semester</span></p>
                                </div>
                                <div class="mt-4">
                                    @if($room->isFull())
                                        <button disabled class="w-full bg-gray-300 text-gray-600 px-4 py-2 rounded cursor-not-allowed">Full</button>
                                    @else
                                        <form action="{{ route('student.hostel.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                                            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Book Room</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</x-app-layout>