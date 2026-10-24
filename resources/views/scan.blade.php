<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data {{ $student->nama }} | PPDB Darul Ihsan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<main class="container py-4 py-md-5">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
                        <div>
                            <p class="text-primary fw-semibold mb-2">PPDB Darul Ihsan</p>
                            <h1 class="h3 mb-1">Data Pendaftar</h1>
                            <p class="text-muted mb-0">Data terhubung dari QR Code resmi siswa.</p>
                        </div>
                        <span class="badge text-bg-{{ $student->status === 'Terverifikasi' ? 'success' : 'warning' }} fs-6">{{ $student->status }}</span>
                    </div>

                    @auth
                        @if (auth()->user()->isAdmin())
                            <div class="mb-4">
                                @if ($student->status !== 'Terverifikasi')
                                    <form action="{{ route('students.verify', ['id' => $student->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success w-100">Setujui / Verifikasi Siswa</button>
                                    </form>
                                @else
                                    <div class="alert alert-success mb-0">Siswa sudah disetujui dan terverifikasi.</div>
                                @endif
                            </div>
                        @endif
                    @endauth

                    <dl class="row gy-2 mb-4">
                        <dt class="col-sm-4">Nama</dt><dd class="col-sm-8">{{ $student->nama }}</dd>
                        <dt class="col-sm-4">NISN</dt><dd class="col-sm-8">{{ $student->nisn }}</dd>
                        <dt class="col-sm-4">Email</dt><dd class="col-sm-8">{{ $student->email }}</dd>
                        <dt class="col-sm-4">Jenis Kelamin</dt><dd class="col-sm-8">{{ $student->jenis_kelamin }}</dd>
                        <dt class="col-sm-4">Alamat</dt><dd class="col-sm-8">{{ $student->alamat }}</dd>
                        <dt class="col-sm-4">Tanggal Daftar</dt><dd class="col-sm-8">{{ $student->created_at->format('d M Y') }}</dd>
                    </dl>

                    <h2 class="h5 border-top pt-4 mb-3">Berkas yang diunggah</h2>
                    <div class="list-group mb-4">
                        @foreach(['kartu_keluarga' => 'Kartu Keluarga', 'akte_lahir' => 'Akta Kelahiran', 'ktp' => 'KTP', 'ijazah' => 'Ijazah'] as $key => $label)
                            <div class="list-group-item d-flex flex-wrap justify-content-between align-items-center gap-2">
                                <span><strong>{{ $label }}</strong><br><small class="text-muted">{{ $student->{$key} ? basename($student->{$key}) : 'Belum tersedia' }}</small></span>
                                @if ($student->{$key})
                                    <a class="btn btn-sm btn-outline-primary" href="{{ route('students.scan.document', ['id' => $student->id, 'document' => $key]) }}">Buka berkas</a>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <p class="text-muted small mb-0">Informasi ini ditampilkan melalui QR Code pendaftar.</p>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
