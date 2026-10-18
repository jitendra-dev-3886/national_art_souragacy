<?php
use App\Imports\PatientArtclinicImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use DB;

class PatientUploadController extends Controller
{
    public function showUpload()
    {
        return view('patient.bulk-upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx|max:2048'
        ]);

        DB::beginTransaction();

        try {
            Excel::import(new PatientArtclinicImport, $request->file('file'));
            DB::commit();

            return back()->with('success', 'Patients uploaded successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function downloadTemplate()
    {
        return response()->download(public_path('templates/patient_template.xlsx'));
    }
}
