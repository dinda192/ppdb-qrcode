<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StudentController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $students = Student::when($user->jenjang, function ($query) use ($user) {
                $query->where('jenjang', $user->jenjang);
            })->get();
            $student = null;
        } else {
            $student = $user->student ?: Student::where('email', $user->email)->first();
            if ($student && !$student->user_id) {
                $student->update(['user_id' => $user->id]);
            }
            $students = $student ? collect([$student]) : collect();
        }

        return view('index', compact('students', 'student'));
    }
     public function create()
    {
        return view('create');
    }

     private function authorizeStudentAccess(Student $student): void
     {
         $user = auth()->user();
         $allowed = $user->isAdmin()
             && (!$user->jenjang || $student->jenjang === $user->jenjang);

         abort_unless($allowed || $student->user_id === $user->id, 403);
     }

     public function edit($id)
     {
         $student = Student::findOrFail($id);
          $this->authorizeStudentAccess($student);

         return view('edit', compact('student'));
     }

     public function update(Request $request, $id)
     {
         $student = Student::findOrFail($id);
         $this->authorizeStudentAccess($student);

         $data = $request->validate([
             'jenjang' => ['required', 'in:MTs,MA,SMK'],
             'nama' => ['required', 'string', 'max:255'],
             'nisn' => ['required', 'string', 'max:255'],
             'email' => ['required', 'email', 'max:255'],
             'alamat' => ['required', 'string'],
             'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
             'kartu_keluarga' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
             'akte_lahir' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
             'ktp' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
             'ijazah' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
         ]);

         if (!auth()->user()->isAdmin() && $data['jenjang'] !== auth()->user()->jenjang) {
             abort(403, 'Jenjang pendaftaran tidak sesuai dengan akun.');
         }
         if (auth()->user()->isAdmin() && auth()->user()->jenjang !== null && $data['jenjang'] !== auth()->user()->jenjang) {
             abort(403, 'Admin hanya dapat mengelola jenjang '.auth()->user()->jenjang.'.');
         }

         $student->update(collect($data)->except([
             'kartu_keluarga', 'akte_lahir', 'ktp', 'ijazah',
         ])->all());

         foreach (['kartu_keluarga', 'akte_lahir', 'ktp', 'ijazah'] as $document) {
             if ($request->hasFile($document)) {
                 $oldPath = $student->{$document};
                 $newPath = $request->file($document)->store('documents/'.$student->id, 'public');
                 $student->update([$document => $newPath]);

                 if ($oldPath) {
                     Storage::disk('public')->delete($oldPath);
                 }
             }
         }

         return redirect()->route('dashboard')->with('success', 'Data pendaftaran berhasil diperbarui.');
     }

     public function store(Request $request)
    {
        $data = $request->validate([
            'jenjang' => ['required', 'in:MTs,MA,SMK'],
            'nama' => ['required', 'string', 'max:255'],
            'nisn' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'alamat' => ['required', 'string'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'kartu_keluarga' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'akte_lahir' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'ktp' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'ijazah' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        if (!auth()->user()->isAdmin() && $data['jenjang'] !== auth()->user()->jenjang) {
            abort(403, 'Jenjang pendaftaran tidak sesuai dengan akun.');
        }

        if (auth()->user()->isAdmin() && auth()->user()->jenjang && $data['jenjang'] !== auth()->user()->jenjang) {
            abort(403, 'Admin hanya dapat mengelola jenjang '.$auth()->user()->jenjang.'.');
        }

        $student = Student::create(collect($data)->except([
            'kartu_keluarga', 'akte_lahir', 'ktp', 'ijazah',
        ])->put('user_id', auth()->user()->isAdmin() ? null : auth()->id())->all());

        foreach (['kartu_keluarga', 'akte_lahir', 'ktp', 'ijazah'] as $document) {
            $data[$document] = $request->file($document)->store('documents/'.$student->id, 'public');
        }
        $student->update(collect($data)->only([
            'kartu_keluarga', 'akte_lahir', 'ktp', 'ijazah',
        ])->all());

        $qrName = 'qrcode-'.$student->id.'.svg';
        if (!is_dir(public_path('qrcodes'))) {
            mkdir(public_path('qrcodes'), 0755, true);
        }
        QrCode::size(200)
            ->generate(route('students.scan', ['id' => $student->id]), public_path('qrcodes/'.$qrName));

        $student->update([
            'qr_code' => $qrName
        ]);

        return redirect()->route('dashboard')->with('success', 'Pendaftar dan QR Code berhasil dibuat.');
    }

    public function verify($id)
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        $student = Student::findOrFail($id);
        $this->authorizeStudentAccess($student);

        $student->update([
            'status' => 'Terverifikasi'
        ]);
         return back();
    }

    public function graduate($id)
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        $student = Student::findOrFail($id);
        $this->authorizeStudentAccess($student);

        $student->update([
            'status_kelulusan' => 'Lulus',
        ]);

        return back()->with('success', 'Status kelulusan siswa berhasil disimpan.');
    }

    public function exportGraduates()
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $students = Student::where('status_kelulusan', 'Lulus')
            ->when(auth()->user()->jenjang, function ($query) {
                $query->where('jenjang', auth()->user()->jenjang);
            })
            ->orderBy('nama')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Siswa Lulus');
        $sheet->fromArray([
            ['No', 'Nama', 'Jenjang', 'NISN', 'Email', 'Jenis Kelamin', 'Alamat', 'Status Verifikasi', 'Status Kelulusan', 'Tanggal Daftar'],
        ], null, 'A1');

        $rows = [];
        foreach ($students as $index => $student) {
            $rows[] = [
                $index + 1,
                $student->nama,
                $student->jenjang,
                $student->nisn,
                $student->email,
                $student->jenis_kelamin,
                $student->alamat,
                $student->status,
                $student->status_kelulusan,
                optional($student->created_at)->format('d-m-Y'),
            ];
        }
        if ($rows) {
            $sheet->fromArray($rows, null, 'A2');
        }

        foreach (range('A', 'J') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        $sheet->getStyle('A1:J1')->getFont()->setBold(true);
        $sheet->freezePane('A2');

        return response()->streamDownload(function () use ($spreadsheet) {
            (new Xlsx($spreadsheet))->save('php://output');
            $spreadsheet->disconnectWorksheets();
        }, 'data-siswa-lulus-'.now()->format('Y-m-d').'.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function scan($id)
    {
        $student = Student::findOrFail($id);

        return view('scan', compact('student'));
    }

    public function showQr($id)
    {
        $student = Student::findOrFail($id);
        $this->authorizeStudentAccess($student);
        $svg = QrCode::size(300)->generate(route('students.scan', ['id' => $student->id]));

        return view('qrcode', compact('student', 'svg'));
    }

    public function downloadDocument($id, $document)
    {
        $allowedDocuments = ['kartu_keluarga', 'akte_lahir', 'ktp', 'ijazah'];
        abort_unless(in_array($document, $allowedDocuments, true), 404);

        $student = Student::findOrFail($id);
        $this->authorizeStudentAccess($student);
        $path = $student->{$document};
        abort_unless($path && Storage::disk('public')->exists($path), 404);

        return Storage::disk('public')->download($path);
    }
}