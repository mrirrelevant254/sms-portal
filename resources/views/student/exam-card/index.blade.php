<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Exam Card</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if(session('error'))
            <div class="p-4 bg-red-100 text-red-800 rounded-lg">{{ session('error') }}</div>
        @endif

        <div class="bg-white shadow rounded-lg p-6 border-l-4 {{ $isCleared ? 'border-green-500' : 'border-red-500' }}">
            <h3 class="font-bold text-lg mb-2 {{ $isCleared ? 'text-green-700' : 'text-red-700' }}">
                {{ $isCleared ? 'Cleared for Exams' : 'Not Cleared' }}
            </h3>
            <p class="text-sm text-gray-600 mb-4">
                @if($isCleared)
                    Your fees are fully paid. You can download your exam card below.
                @else
                    You have an outstanding balance of KES {{ number_format($balance, 2) }}. Please clear your fees to access the exam card.
                @endif
            </p>

            @if($isCleared && !$units->isEmpty())
                <a href="{{ route('student.exam-card.download') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Download Exam Card (PDF)
                </a>
            @elseif($units->isEmpty())
                <p class="text-sm text-yellow-600 font-semibold">You have not registered any units for this semester. You cannot generate an exam card.</p>
            @endif
        </div>

        @if($isCleared)
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="font-semibold mb-4">Registered Units for Exams</h3>
                <table class="w-full text-sm">
                    <thead><tr class="text-left border-b"><th class="py-2">Code</th><th class="py-2">Title</th></tr></thead>
                    <tbody>
                        @foreach($units as $reg)
                            <tr class="border-b">
                                <td class="py-2">{{ $reg->unit->code }}</td>
                                <td class="py-2">{{ $reg->unit->title }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>