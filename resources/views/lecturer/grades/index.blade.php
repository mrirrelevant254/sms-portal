@extends('layouts.lecturer')

@section('content')
    <div class="bg-white shadow rounded-lg p-6 overflow-x-auto">
        <h2 class="text-xl font-semibold mb-4">Grade Entry</h2>
        <!-- ... keep the existing table code here ... -->

            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b">
                        <th class="py-2">Student</th>
                        <th class="py-2">Unit</th>
                        <th class="py-2">CAT (30)</th>
                        <th class="py-2">Exam (70)</th>
                        <th class="py-2">Total</th>
                        <th class="py-2">Grade</th>
                        <th class="py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registrations as $reg)
                        <tr class="border-b">
                            <td class="py-2">{{ $reg->student->full_name }}<br><span class="text-xs text-gray-500">{{ $reg->student->reg_no }}</span></td>
                            <td class="py-2">{{ $reg->unit->code }}</td>
                            <form action="{{ route('lecturer.grades.store', $reg->id) }}" method="POST">
                                @csrf
                                <td class="py-2"><input type="number" name="cat_mark" value="{{ $reg->result->cat_mark ?? 0 }}" class="w-16 border rounded px-1 py-1" required></td>
                                <td class="py-2"><input type="number" name="exam_mark" value="{{ $reg->result->exam_mark ?? 0 }}" class="w-16 border rounded px-1 py-1" required></td>
                                <td class="py-2 font-bold">{{ $reg->result->total ?? '-' }}</td>
                                <td class="py-2 font-bold">{{ $reg->result->grade ?? '-' }}</td>
                                <td class="py-2">
                                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">Save</button>
                                </td>
                            </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection