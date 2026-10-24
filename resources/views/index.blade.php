<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda | PPDB Darul Ihsan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="dashboard-page">
<div class="dashboard-shell">
    <aside class="sidebar">
        <a class="brand" href="{{ route('dashboard') }}" aria-label="PPDB Darul Ihsan"><span class="brand-mark">YDI</span><span class="brand-name">Darul Ihsan<small>PPDB ONLINE</small></span></a>
        <nav class="sidebar-nav" aria-label="Navigasi utama">
            <a class="nav-item active" href="{{ route('dashboard') }}"><span class="nav-icon">⌂</span>Beranda</a>
            <a class="nav-item" href="#profil"><span class="nav-icon">♙</span>Profil</a>
            <a class="nav-item" href="{{ route('students.create') }}"><span class="nav-icon">▣</span>Pendaftaran</a>
            @if(auth()->user()->isAdmin())<button type="button" class="nav-item" id="open-qr-scanner"><span class="nav-icon">▦</span>Scan QR</button>@endif
        </nav>
        <form action="{{ route('logout') }}" method="POST" class="logout-form">@csrf<button type="submit" class="nav-item logout-button"><span class="nav-icon">↪</span>Logout</button></form>
    </aside>
    <main class="dashboard-content">
        <header class="topbar"><div><p class="eyebrow">PORTAL PPDB DARUL IHSAN</p><h1>Selamat Datang, {{ auth()->user()->name }}</h1></div><div class="profile-chip" id="profil"><span>{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span><strong>{{ auth()->user()->name }}</strong></div></header>
        <section class="welcome-card"><div><p class="eyebrow">TAHUN AJARAN 2026/2027</p><h2>PPDB Darul Ihsan</h2><p>{{ auth()->user()->isAdmin() ? 'Kelola data '.(auth()->user()->jenjang ?: 'semua jenjang').' dengan mudah dan terarah.' : 'Lengkapi data pendaftaran dan pantau proses verifikasi Anda.' }}</p><a href="{{ route('students.create') }}" class="primary-button">{{ $student ? 'Lihat pendaftaran saya' : 'Mulai Pendaftaran' }} <span>→</span></a></div><div class="welcome-seal" aria-hidden="true">YDI</div></section>
        @if(session('success'))<div class="success-message">{{ session('success') }}</div>@endif
        @if(auth()->user()->isAdmin())
        <div class="section-heading"><div><p class="eyebrow">RINGKASAN</p><h2>Dashboard Ringkas</h2></div><span class="date-label">26 September 2026</span></div>
        <section class="summary-grid">
            <article class="summary-card"><div class="card-icon green">◌</div><div><span>Total Pendaftar</span><strong>{{ $students->count() }}</strong><small>Data masuk keseluruhan</small></div></article>
            <article class="summary-card"><div class="card-icon amber">◷</div><div><span>Menunggu Verifikasi</span><strong>{{ $students->where('status', 'Menunggu')->count() }}</strong><small>Perlu ditinjau</small></div></article>
            <article class="summary-card"><div class="card-icon blue">✓</div><div><span>Terverifikasi</span><strong>{{ $students->where('status', 'Terverifikasi')->count() }}</strong><small>Data telah disetujui</small></div></article>
        </section>
        <section class="progress-grid">
            <article class="panel timeline-panel"><div class="panel-title"><div><p class="eyebrow">ALUR PENDAFTARAN</p><h2>Timeline Pendaftaran</h2></div><span class="status-pill">Aktif</span></div><div class="timeline"><div class="timeline-step done"><span>1</span><b>Isi Formulir</b></div><div class="timeline-step done"><span>2</span><b>Unggah Berkas</b></div><div class="timeline-step current"><span>3</span><b>Verifikasi</b></div><div class="timeline-step"><span>4</span><b>Selesai</b></div></div></article>
            <article class="panel status-panel"><div class="panel-title"><div><p class="eyebrow">PEMANTAUAN</p><h2>Status Pendaftaran</h2></div><span class="pulse"></span></div><div class="status-copy"><strong>{{ $students->where('status', 'Terverifikasi')->count() }} pendaftar</strong><span>telah terverifikasi</span></div><div class="progress-track"><span style="width: {{ $students->count() ? round(($students->where('status', 'Terverifikasi')->count() / $students->count()) * 100) : 0 }}%"></span></div></article>
        </section>
        <section class="records-panel" id="scan"><div class="section-heading"><div><p class="eyebrow">DATA {{ auth()->user()->jenjang ?: 'SEMUA JENJANG' }}</p><h2>Pengumuman terbaru</h2></div><div><a href="{{ route('students.export.graduates') }}" class="secondary-button">Export Excel Siswa Lulus</a> <a href="{{ route('students.create') }}" class="secondary-button">+ Pendaftar baru</a></div></div><div class="table-wrap"><table><thead><tr><th>Nama Pendaftar</th><th>Jenjang</th><th>NISN</th><th>Status</th><th>Berkas</th><th>QR Code</th><th>Aksi</th></tr></thead><tbody>
            @forelse($students as $student)
                <tr><td>{{ $student->nama }}</td><td>{{ $student->jenjang ?: '-' }}</td><td>{{ $student->nisn }}</td><td><span class="record-status {{ $student->status === 'Terverifikasi' ? 'verified' : 'waiting' }}">{{ $student->status }}</span>@if($student->status_kelulusan === 'Lulus')<br><span class="record-status verified">Lulus</span>@endif</td><td><div class="document-links">@foreach(['kartu_keluarga' => 'KK', 'akte_lahir' => 'Akta', 'ktp' => 'KTP', 'ijazah' => 'Ijazah'] as $document => $label)@if($student->{$document})<a href="{{ route('students.document', ['id' => $student->id, 'document' => $document]) }}">{{ $label }}</a>@endif @endforeach</div></td><td><a class="qr-link" href="{{ route('student.qrcode', ['id' => $student->id]) }}">Lihat QR →</a></td><td><a href="{{ route('students.edit', ['id' => $student->id]) }}" class="verify-button">Edit</a> @if($student->status !== 'Terverifikasi')<form action="{{ route('students.verify', ['id' => $student->id]) }}" method="POST" class="d-inline">@csrf<button type="submit" class="verify-button">Verifikasi</button></form>@else<span class="finished-label">Selesai</span>@endif @if($student->status_kelulusan !== 'Lulus')<form action="{{ route('students.graduate', ['id' => $student->id]) }}" method="POST" class="d-inline">@csrf<button type="submit" class="verify-button">Lulus</button></form>@else<span class="finished-label">Sudah Lulus</span>@endif</td></tr>
            @empty
                <tr><td colspan="7" class="empty-state">Belum ada data pendaftar.</td></tr>
            @endforelse
        </tbody></table></div></section>
        @else
        <section class="records-panel applicant-panel"><div class="section-heading"><div><p class="eyebrow">AKUN CALON SISWA</p><h2>Pendaftaran Saya</h2></div>@if($student)<span class="record-status {{ $student->status_kelulusan === 'Lulus' ? 'verified' : ($student->status === 'Terverifikasi' ? 'verified' : 'waiting') }}">{{ $student->status_kelulusan === 'Lulus' ? 'Lulus' : $student->status }}</span>@endif</div>
            @if($student)
                @if($student->status_kelulusan === 'Lulus')<div class="success-message"><strong>Selamat!</strong> Anda dinyatakan <strong>LULUS</strong> PPDB Darul Ihsan.</div>@endif
                <dl class="applicant-details"><dt>Nama</dt><dd>{{ $student->nama }}</dd><dt>Jenjang</dt><dd>{{ $student->jenjang ?: '-' }}</dd><dt>NISN</dt><dd>{{ $student->nisn }}</dd><dt>Email</dt><dd>{{ $student->email }}</dd><dt>Jenis Kelamin</dt><dd>{{ $student->jenis_kelamin }}</dd><dt>Alamat</dt><dd>{{ $student->alamat }}</dd></dl>
                <div class="document-links applicant-documents">@foreach(['kartu_keluarga' => 'KK', 'akte_lahir' => 'Akta', 'ktp' => 'KTP', 'ijazah' => 'Ijazah'] as $document => $label)@if($student->{$document})<a href="{{ route('students.document', ['id' => $student->id, 'document' => $document]) }}">{{ $label }}</a>@endif @endforeach</div>
                <a href="{{ route('students.edit', ['id' => $student->id]) }}" class="secondary-button">Edit Data</a>
                <a href="{{ route('student.qrcode', ['id' => $student->id]) }}" class="primary-button applicant-qr">Lihat QR Pendaftaran <span>→</span></a>
            @else
                <p class="empty-state">Anda belum memiliki data pendaftaran. Silakan mulai pendaftaran untuk mengunggah data dan berkas.</p>
            @endif
        </section>
        @endif
    </main>
</div>
@if(auth()->user()->isAdmin())
<div class="scanner-modal" id="qr-scanner-modal" hidden>
    <div class="scanner-dialog" role="dialog" aria-modal="true" aria-labelledby="scanner-title">
        <div class="scanner-header"><div><p class="eyebrow">PEMINDAI QR</p><h2 id="scanner-title">Scan QR Code Siswa</h2></div><button type="button" class="scanner-close" id="close-qr-scanner" aria-label="Tutup scanner">&times;</button></div>
        <div class="scanner-frame"><div id="qr-reader"></div></div>
        <p class="scanner-status" id="qr-scanner-status">Mengaktifkan kamera...</p>
        <button type="button" class="secondary-button scanner-cancel" id="cancel-qr-scanner">Tutup</button>
    </div>
</div>
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    (() => {
        const modal = document.getElementById('qr-scanner-modal');
        const openButton = document.getElementById('open-qr-scanner');
        const closeButtons = [document.getElementById('close-qr-scanner'), document.getElementById('cancel-qr-scanner')];
        const status = document.getElementById('qr-scanner-status');
        let scanner;
        let scannerRunning = false;

        const stopScanner = async () => {
            if (scanner && scannerRunning) {
                await scanner.stop();
                scanner.clear();
                scannerRunning = false;
            }
        };

        const closeScanner = async () => {
            await stopScanner();
            modal.hidden = true;
        };

        const handleScan = async (decodedText) => {
            let target;
            try {
                target = new URL(decodedText, window.location.origin);
            } catch {
                status.textContent = 'QR Code tidak valid.';
                return;
            }

            if (target.origin !== window.location.origin || !target.pathname.startsWith('/scan/')) {
                status.textContent = 'QR Code bukan QR Code pendaftar PPDB.';
                return;
            }

            status.textContent = 'QR terbaca. Membuka data siswa...';
            await stopScanner();
            window.location.assign(target.href);
        };

        const startScanner = async () => {
            if (typeof Html5Qrcode === 'undefined') {
                status.textContent = 'Pemindai tidak dapat dimuat. Periksa koneksi internet.';
                return;
            }

            scanner = new Html5Qrcode('qr-reader');
            try {
                await scanner.start(
                    { facingMode: 'environment' },
                    { fps: 10, qrbox: { width: 250, height: 250 } },
                    handleScan,
                    () => {}
                );
                scannerRunning = true;
                status.textContent = 'Arahkan kamera ke QR Code siswa.';
            } catch {
                status.textContent = 'Kamera tidak dapat dibuka. Izinkan akses kamera lalu coba lagi.';
            }
        };

        openButton.addEventListener('click', () => {
            modal.hidden = false;
            status.textContent = 'Mengaktifkan kamera...';
            startScanner();
        });
        closeButtons.forEach((button) => button.addEventListener('click', closeScanner));
        modal.addEventListener('click', (event) => {
            if (event.target === modal) closeScanner();
        });
    })();
</script>
@endif
</body>
</html>
