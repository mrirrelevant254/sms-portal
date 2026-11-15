<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>


    

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Stage + semester badges --}}
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                {{ $stage }}
            </span>
            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                {{ $semester }}
            </span>
        </div>

        {{-- Fee cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white shadow rounded-lg p-6">
                <p class="text-sm text-gray-500">Fees Billed</p>
                <p class="text-2xl font-bold">KES {{ number_format($billed, 2) }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6">
                <p class="text-sm text-gray-500">Total Paid</p>
                <p class="text-2xl font-bold text-green-600">KES {{ number_format($paid, 2) }}</p>
                <p class="text-xs text-gray-500">{{ $paid_pct }}%</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6">
                <p class="text-sm text-gray-500">Balance</p>
                <p class="text-2xl font-bold {{ $balance < 0 ? 'text-green-600' : 'text-red-600' }}">
                    KES {{ number_format($balance, 2) }}
                </p>
                <p class="text-xs text-gray-500">{{ $bal_pct }}% {{ $balance < 0 ? 'credit' : 'outstanding' }}</p>
            </div>
        </div>

        {{-- Fee statement button --}}
        <div class="flex justify-end">
            <a href="{{ route('student.fees.statement') }}"
               class="text-sm bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                View Full Fee Statement
            </a>
        </div>

        {{-- Personal info --}}
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="font-semibold mb-4">Personal Information</h3>
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div><dt class="text-gray-500">Full Name</dt><dd>{{ $student->full_name }}</dd></div>
                <div><dt class="text-gray-500">Reg No</dt><dd>{{ $student->reg_no }}</dd></div>
                <div><dt class="text-gray-500">Programme</dt><dd>{{ $student->programme->name }}</dd></div>
                <div><dt class="text-gray-500">Campus</dt><dd>{{ $student->campus->name }}</dd></div>
                <div><dt class="text-gray-500">Email</dt><dd>{{ $student->user->email }}</dd></div>
                <div><dt class="text-gray-500">Phone</dt><dd>{{ $student->phone ?? 'Not set' }}</dd></div>
            </dl>
        </div>

        {{-- Registered units --}}
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-semibold">Registered Units</h3>
                <a href="{{ route('student.units.index') }}"
                   class="text-sm bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                    + Register Units
                </a>
            </div>

            @if($units->isEmpty())
                <p class="text-sm text-gray-500">No units registered yet.</p>
            @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="py-2">#</th>
                            <th class="py-2">Code</th>
                            <th class="py-2">Title</th>
                            <th class="py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($units as $i => $reg)
                            <tr class="border-b">
                                <td class="py-2">{{ $i + 1 }}</td>
                                <td class="py-2">{{ $reg->unit->code }}</td>
                                <td class="py-2">{{ $reg->unit->title }}</td>
                                <td class="py-2">{{ ucfirst($reg->status) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>