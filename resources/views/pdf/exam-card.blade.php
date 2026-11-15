<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Exam Card</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #065f46; padding-bottom: 10px; }
        .details td { padding: 6px; }
        .units-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .units-table th, .units-table td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        .units-table th { background-color: #f3f4f6; }
    </style>
</head>
<body>
    <div class="header">
        <h1>University Student Portal</h1>
        <h2>Official Examination Card</h2>
    </div>
    <table class="details">
        <tr><td><strong>Student Name:</strong> {{ $student->full_name }}</td><td><strong>Reg No:</strong> {{ $student->reg_no }}</td></tr>
        <tr><td><strong>Programme:</strong> {{ $student->programme->name }}</td><td><strong>Semester:</strong> {{ $semester->academic_year }} (Sem {{ $semester->semester_no }})</td></tr>
    </table>
    
    <table class="units-table">
        <thead><tr><th>Code</th><th>Unit Title</th></tr></thead>
        <tbody>
            @foreach($units as $reg)
                <tr><td>{{ $reg->unit->code }}</td><td>{{ $reg->unit->title }}</td></tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 50px; text-align: center; font-size: 10px; color: #666;">
        <p>This card must be presented during the examination. A valid student ID is also required.</p>
    </div>
</body>
</html>