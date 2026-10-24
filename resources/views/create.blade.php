<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form PPDB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-5">
    <div class="mb-4">
        <a href="{{ route('dashboard') }}" class="text-decoration-none">&larr; Kembali ke Dashboard</a>
    </div>
    <div class="card p-4">
        <h2>Form Pendaftaran PPDB</h2>
        <p class="text-muted">Lengkapi data diri dan unggah semua berkas persyaratan.</p>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="jenjang">Jenjang</label>
                <select id="jenjang" name="jenjang" class="form-control" required>
                    @foreach(['MTs', 'MA', 'SMK'] as $jenjang)
                        @if(!auth()->user()->isAdmin() && auth()->user()->jenjang !== $jenjang)
                            @continue
                        @endif
                        <option value="{{ $jenjang }}" @selected(old('jenjang', auth()->user()->jenjang) === $jenjang)>{{ $jenjang }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control">
            </div>

            <div class="mb-3">
                <label>NISN</label>
                <input type="text" name="nisn" class="form-control">
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
            </div>

            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control">
                    <option>Laki-laki</option>
                    <option>Perempuan</option>
                </select>
            </div>

            <hr class="my-4">
            <h4 class="mb-1">Berkas Persyaratan</h4>
            <p class="text-muted small">Format PDF, JPG, JPEG, atau PNG. Ukuran maksimal 2 MB per berkas.</p>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="kartu_keluarga" class="form-label">Kartu Keluarga</label>
                    <input id="kartu_keluarga" type="file" name="kartu_keluarga" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                </div>
                <div class="col-md-6">
                    <label for="akte_lahir" class="form-label">Akta Kelahiran</label>
                    <input id="akte_lahir" type="file" name="akte_lahir" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                </div>
                <div class="col-md-6">
                    <label for="ktp" class="form-label">KTP</label>
                    <input id="ktp" type="file" name="ktp" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                </div>
                <div class="col-md-6">
                    <label for="ijazah" class="form-label">Ijazah</label>
                    <input id="ijazah" type="file" name="ijazah" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                </div>
            </div>

            <button class="btn btn-primary mt-4">Daftar dan Simpan Berkas</button>
        </form>
    </div>
</div>

</body>
</html>