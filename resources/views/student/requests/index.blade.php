<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Requests</h2>
            <a href="{{ route('student.requests.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">+ New Request</a>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
        @endif

        <div class="bg-white shadow rounded-lg p-6">
            @if($requests->isEmpty())
                <p class="text-gray-500">You have not submitted any requests.</p>
            @else
                <table class="w-full text-sm">
                    <thead><tr class="text-left border-b"><th class="py-2">Date</th><th class="py-2">Type</th><th class="py-2">Status</th><th class="py-2">Current Step</th></tr></thead>
                    <tbody>
                        @foreach($requests as $req)
                            <tr class="border-b">
                                <td class="py-2">{{ $req->created_at->format('d M Y') }}</td>
                                <td class="py-2 uppercase">{{ $req->type }}</td>
                                <td class="py-2">
                                    <span class="px-2 py-1 rounded text-xs {{ $req->status === 'approved' ? 'bg-green-100 text-green-800' : ($req->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($req->status) }}
                                    </span>
                                </td>
                                <td class="py-2 uppercase">{{ $req->current_step }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>