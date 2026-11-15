<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fee Statement</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #065f46; padding-bottom: 10px; }
        .header h1 { color: #065f46; margin: 0; }
        .details { width: 100%; margin-bottom: 20px; }
        .details td { padding: 4px; }
        .summary-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .summary-table th, .summary-table td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        .summary-table th { background-color: #f3f4f6; }
        .text-right { text-align: right; }
        .text-green { color: #065f46; font-weight: bold; }
        .text-red { color: #991b1b; font-weight: bold; }
        .footer { margin-top: 50px; text-align: center; font-size: 10px; color: #666; }
    </style>
</head>
<body>

    <div class="header">
        <h1>University Student Portal</h1>
        <p>Official Fee Statement</p>
    </div>

    <table class="details">
        <tr>
            <td><strong>Student Name:</strong> {{ $student->full_name }}</td>
            <td><strong>Reg No:</strong> {{ $student->reg_no }}</td>
        </tr>
        <tr>
            <td><strong>Programme:</strong> {{ $student->programme->name }}</td>
            <td><strong>Semester:</strong> {{ $semester->academic_year }} (Sem {{ $semester->semester_no }})</td>
        </tr>
    </table>

    <table class="summary-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Reference</th>
                <th>Method</th>
                <th class="text-right">Amount (KES)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($invoices as $invoice)
                @foreach($invoice->payments as $payment)
                <tr>
                    <td>{{ $payment->created_at->format('d M Y') }}</td>
                    <td>{{ $payment->reference }}</td>
                    <td>{{ strtoupper($payment->method) }}</td>
                    <td class="text-right">{{ number_format($payment->amount, 2) }}</td>
                    <td>{{ ucfirst($payment->status) }}</td>
                </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;">No payments recorded.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="summary-table" style="width: 50%; float: right;">
        <tr>
            <th>Total Billed</th>
            <td class="text-right">KES {{ number_format($totalBilled, 2) }}</td>
        </tr>
        <tr>
            <th>Total Paid</th>
            <td class="text-right text-green">KES {{ number_format($totalPaid, 2) }}</td>
        </tr>
        <tr>
            <th>Balance</th>
            <td class="text-right {{ $balance < 0 ? 'text-green' : 'text-red' }}">
                KES {{ number_format($balance, 2) }}
            </td>
        </tr>
    </table>
    <div style="clear: both;"></div>

    <div class="footer">
        <p>This is a computer-generated statement and does not require a signature.</p>
        <p>Generated on {{ now()->format('d M Y, H:i A') }}</p>
    </div>

</body>
</html>