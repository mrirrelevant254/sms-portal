<x-app-layout>
    <x-slot name="header">
        <h3 class="font-semibold mb-4">
            Available Units for {{ $semester->academic_year }} (Semester {{ $studentSemester }})
        </h3>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="font-semibold mb-4">
                Available Units for {{ $semester->academic_year }} (Semester {{ auth()->user()->student->semester_of_study }})
            </h3>

            <form action="{{ route('student.units.store') }}" method="POST">
                @csrf
                <table class="w-full text-sm mb-4">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="py-2">Select</th>
                            <th class="py-2">Code</th>
                            <th class="py-2">Title</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($availableUnits as $unit)
                            <tr class="border-b">
                                <td class="py-2">
                                    <input type="checkbox" name="unit_ids[]" value="{{ $unit->id }}"
                                        {{ in_array($unit->id, $registeredUnitIds) ? 'checked disabled' : '' }}>
                                </td>
                                <td class="py-2">{{ $unit->code }}</td>
                                <td class="py-2">{{ $unit->title }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Register Selected Units
                </button>
            </form>
        </div>
    </div>
</x-app-layout>