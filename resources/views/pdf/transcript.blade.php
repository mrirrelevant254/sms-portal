<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Provisional Transcript</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        .header { text-align: center; border-bottom: 2px solid #065f46; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { color: #065f46; margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background-color: #f3f4f6; }
        .gpa-box { margin-top: 20px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>University Student Portal</h1>
        <h3>Provisional Academic Transcript</h3>
    </div>

    <table>
        <tr><td><strong>Student Name:</strong></td><td>{{ $student->full_name }}</td></tr>
        <tr><td><strong>Reg No:</strong></td><td>{{ $student->reg_no }}</td></tr>
        <tr><td><strong>Programme:</strong></td><td>{{ $student->programme->name }}</td></tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Semester</th><th>Code</th><th>Unit Title</th>
                <th>CAT</th><th>Exam</th><th>Total</th><th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $reg)
                <tr>
                    <td>{{ $reg->semester->academic_year }} S{{ $reg->semester->semester_no }}</td>
                    <td>{{ $reg->unit->code }}</td>
                    <td>{{ $reg->unit->title }}</td>
                    <td>{{ $reg->result->cat_mark }}</td>
                    <td>{{ $reg->result->exam_mark }}</td>
                    <td>{{ $reg->result->total }}</td>
                    <td><strong>{{ $reg->result->grade }}</strong></td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center;">No grades recorded.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="gpa-box">
        <h3>Cumulative GPA: {{ number_format($gpa, 2) }}</h3>
    </div>
</body>
</html>