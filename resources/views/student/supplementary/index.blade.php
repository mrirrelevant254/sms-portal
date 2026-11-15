<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Supplementary & Special Exams</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if(session('success'))
            <div class="p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
        @endif

        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="font-semibold text-lg mb-4 text-red-600">Units Eligible for Supplementary Exam</h3>
            @if($failedUnits->isEmpty())
                <p class="text-sm text-gray-500">You have no failed units eligible for a supplementary exam.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($failedUnits as $reg)
                        <div class="border rounded-lg p-4">
                            <h4 class="font-bold">{{ $reg->unit->code }} - {{ $reg->unit->title }}</h4>
                            <p class="text-xs text-gray-500 mb-3">Grade Achieved: <span class="text-red-600 font-bold">{{ $reg->result->grade }}</span></p>
                            
                            <form action="{{ route('student.supplementary.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="unit_id" value="{{ $reg->unit->id }}">
                                <input type="text" name="reason" placeholder="Reason (optional)" class="w-full border rounded px-2 py-1 text-sm mb-2">
                                <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">Apply for Supplementary</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="font-semibold mb-4">My Applications</h3>
            @if($applications->isEmpty())
                <p class="text-sm text-gray-500">You have not applied for any special/supplementary exams.</p>
            @else
                <table class="w-full text-sm">
                    <thead><tr class="text-left border-b"><th class="py-2">Unit</th><th class="py-2">Type</th><th class="py-2">Status</th></tr></thead>
                    <tbody>
                        @foreach($applications as $app)
                            <tr class="border-b">
                                <td class="py-2">{{ $app->unit->code }}</td>
                                <td class="py-2 uppercase">{{ $app->type }}</td>
                                <td class="py-2">
                                    <span class="px-2 py-1 rounded text-xs {{ $app->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($app->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>