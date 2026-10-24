<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code - {{ $student->nama }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .student-data dt { color:#6c757d; font-weight:600; }
        .student-data dd { font-weight:600; }
        @media print {
            body { background:#fff !important; }
            .no-print { display:none !important; }
            .print-sheet { box-shadow:none !important; border:0 !important; }
            .qr-image { max-height:260px; }
        }
    </style>
</head>
<body class="bg-light">
<main class="container py-4">
<div class="print-sheet card border-0 shadow-sm mx-auto" style="max-width:760px">
    <div class="card-body p-4 p-md-5">
        <div class="text-center">
            <h1 class="h3">QR Code Pendaftar</h1>
            <p class="text-muted">PPDB Darul Ihsan</p>
        </div>

        <dl class="student-data row gy-2 text-start border-top border-bottom py-3 mb-4">
            <dt class="col-sm-3">Nama</dt><dd class="col-sm-9">{{ $student->nama }}</dd>
            <dt class="col-sm-3">NISN</dt><dd class="col-sm-9">{{ $student->nisn }}</dd>
            <dt class="col-sm-3">Email</dt><dd class="col-sm-9">{{ $student->email }}</dd>
            <dt class="col-sm-3">Jenis Kelamin</dt><dd class="col-sm-9">{{ $student->jenis_kelamin }}</dd>
            <dt class="col-sm-3">Alamat</dt><dd class="col-sm-9">{{ $student->alamat }}</dd>
            <dt class="col-sm-3">Status</dt><dd class="col-sm-9">{{ $student->status }}</dd>
        </dl>

    <div class="text-center my-4">
        @if(!empty($svg))
            <div class="qr-image">{!! $svg !!}</div>
        @elseif($student->qr_code)
            <img class="qr-image" src="{{ asset('qrcodes/' . $student->qr_code) }}" alt="QR Code" style="width:300px;height:300px">
        @else
            <div class="alert alert-warning">QR code belum tersedia.</div>
        @endif
    </div>

    <p class="text-center text-muted small">Scan QR Code untuk melihat data dan berkas pendaftar.</p>

    <div class="no-print text-center">
        <button type="button" onclick="window.print()" class="btn btn-primary">Cetak data siswa</button>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
</main>
</body>
</html>