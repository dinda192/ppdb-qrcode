<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data PPDB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <div class="mb-4">
        <a href="{{ route('dashboard') }}" class="text-decoration-none">&larr; Kembali ke Dashboard</a>
    </div>
    <div class="card p-4">
        <h2>Edit Data Pendaftaran</h2>
        <p class="text-muted">{{ auth()->user()->isAdmin() ? 'Admin dapat memperbarui data siswa atau mengganti berkas yang diperlukan.' : 'Perbarui data diri atau ganti berkas yang diperlukan.' }}</p>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('students.update', ['id' => $student->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="jenjang" class="form-label">Jenjang</label>
                <select id="jenjang" name="jenjang" class="form-control" required>
                    @foreach(['MTs', 'MA', 'SMK'] as $jenjang)
                        @if(auth()->user()->isAdmin() && auth()->user()->jenjang && auth()->user()->jenjang !== $jenjang)
                            @continue
                        @endif
                        <option value="{{ $jenjang }}" @selected(old('jenjang', $student->jenjang) === $jenjang)>{{ $jenjang }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input id="nama" type="text" name="nama" class="form-control" value="{{ old('nama', $student->nama) }}" required>
            </div>
            <div class="mb-3">
                <label for="nisn" class="form-label">NISN</label>
                <input id="nisn" type="text" name="nisn" class="form-control" value="{{ old('nisn', $student->nisn) }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" class="form-control" value="{{ old('email', $student->email) }}" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea id="alamat" name="alamat" class="form-control" required>{{ old('alamat', $student->alamat) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select id="jenis_kelamin" name="jenis_kelamin" class="form-control" required>
                    <option value="Laki-laki" @selected(old('jenis_kelamin', $student->jenis_kelamin) === 'Laki-laki')>Laki-laki</option>
                    <option value="Perempuan" @selected(old('jenis_kelamin', $student->jenis_kelamin) === 'Perempuan')>Perempuan</option>
                </select>
            </div>

            <hr class="my-4">
            <h4 class="mb-1">Ganti Berkas</h4>
            <p class="text-muted small">Kosongkan jika berkas lama tetap digunakan. Format PDF, JPG, JPEG, atau PNG; maksimal 2 MB.</p>
            <div class="row g-3">
                @foreach(['kartu_keluarga' => 'Kartu Keluarga', 'akte_lahir' => 'Akta Kelahiran', 'ktp' => 'KTP', 'ijazah' => 'Ijazah'] as $key => $label)
                    <div class="col-md-6">
                        <label for="{{ $key }}" class="form-label">{{ $label }}</label>
                        <input id="{{ $key }}" type="file" name="{{ $key }}" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                    </div>
                @endforeach
            </div>

            <button class="btn btn-primary mt-4">Simpan Perubahan</button>
        </form>
    </div>
</div>
</body>
</html>
