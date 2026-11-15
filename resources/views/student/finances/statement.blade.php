<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Fee Statement
            </h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('student.fees.download') }}" class="text-sm bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Download PDF
                </a>
                <a href="{{ route('student.dashboard') }}" class="text-sm text-blue-600 hover:underline">
                    &larr; Back to Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white shadow rounded-lg p-6">
                <p class="text-sm text-gray-500">Total Billed</p>
                <p class="text-2xl font-bold">KES {{ number_format($totalBilled, 2) }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6">
                <p class="text-sm text-gray-500">Total Paid</p>
                <p class="text-2xl font-bold text-green-600">KES {{ number_format($totalPaid, 2) }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6">
                <p class="text-sm text-gray-500">Balance</p>
                <p class="text-2xl font-bold {{ $balance < 0 ? 'text-green-600' : 'text-red-600' }}">
                    KES {{ number_format($balance, 2) }}
                </p>
            </div>
        </div>

        {{-- Detailed Invoices --}}
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="font-semibold mb-4">Invoices for {{ $semester->academic_year }} (Semester {{ $semester->semester_no }})</h3>

            @if($invoices->isEmpty())
                <p class="text-sm text-gray-500">No invoices found for this semester.</p>
            @else
                @foreach($invoices as $invoice)
                    <div class="mb-6 border rounded-lg overflow-hidden">
                        <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                            <div>
                                <span class="font-semibold text-sm">Invoice #{{ $invoice->id }}</span>
                                <span class="ml-2 text-xs px-2 py-1 rounded bg-{{ $invoice->status === 'paid' ? 'green' : 'yellow' }}-100 text-{{ $invoice->status === 'paid' ? 'green' : 'yellow' }}-800">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </div>
                            <span class="font-bold">KES {{ number_format($invoice->total, 2) }}</span>
                        </div>

                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left border-b bg-white">
                                    <th class="px-4 py-2">Date</th>
                                    <th class="px-4 py-2">Method</th>
                                    <th class="px-4 py-2">Reference</th>
                                    <th class="px-4 py-2 text-right">Amount (KES)</th>
                                    <th class="px-4 py-2">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoice->payments as $payment)
                                    <tr class="border-b">
                                        <td class="px-4 py-2">{{ $payment->created_at->format('d M Y') }}</td>
                                        <td class="px-4 py-2 uppercase">{{ $payment->method }}</td>
                                        <td class="px-4 py-2">{{ $payment->reference }}</td>
                                        <td class="px-4 py-2 text-right">{{ number_format($payment->amount, 2) }}</td>
                                        <td class="px-4 py-2">
                                            <span class="text-xs px-2 py-1 rounded bg-{{ $payment->status === 'success' ? 'green' : 'red' }}-100 text-{{ $payment->status === 'success' ? 'green' : 'red' }}-800">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-4 text-center text-gray-500 italic">No payments made yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>