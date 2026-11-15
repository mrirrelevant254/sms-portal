<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Provisional Transcript</h2>
            <a href="{{ route('student.transcript.download') }}" class="text-sm bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Download PDF
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="font-semibold text-lg mb-1">{{ $student->full_name }}</h3>
            <p class="text-sm text-gray-500">Reg No: {{ $student->reg_no }} | Programme: {{ $student->programme->name }}</p>
            
            <div class="mt-4 grid grid-cols-3 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-xs text-gray-500 uppercase">Units Graded</p>
                    <p class="text-2xl font-bold">{{ $registrations->count() }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <p class="text-xs text-gray-500 uppercase">GPA</p>
                    <p class="text-2xl font-bold text-green-700">{{ number_format($gpa, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="font-semibold mb-4">Academic Records</h3>
            @if($registrations->isEmpty())
                <p class="text-sm text-gray-500 italic">No grades have been recorded yet.</p>
            @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left border-b bg-gray-50">
                            <th class="py-2 px-2">Semester</th>
                            <th class="py-2 px-2">Code</th>
                            <th class="py-2 px-2">Unit Title</th>
                            <th class="py-2 px-2">CAT (30)</th>
                            <th class="py-2 px-2">Exam (70)</th>
                            <th class="py-2 px-2">Total</th>
                            <th class="py-2 px-2">Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations as $reg)
                            <tr class="border-b">
                                <td class="py-2 px-2">{{ $reg->semester->academic_year }} S{{ $reg->semester->semester_no }}</td>
                                <td class="py-2 px-2">{{ $reg->unit->code }}</td>
                                <td class="py-2 px-2">{{ $reg->unit->title }}</td>
                                <td class="py-2 px-2">{{ $reg->result->cat_mark }}</td>
                                <td class="py-2 px-2">{{ $reg->result->exam_mark }}</td>
                                <td class="py-2 px-2 font-semibold">{{ $reg->result->total }}</td>
                                <td class="py-2 px-2">
                                    <span class="px-2 py-1 rounded text-xs font-bold {{ $reg->result->grade == 'A' ? 'bg-green-100 text-green-800' : ($reg->result->grade == 'E' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ $reg->result->grade }}
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