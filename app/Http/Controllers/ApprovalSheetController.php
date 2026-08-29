<?php

namespace App\Http\Controllers;

use App\Models\ApprovalSheet;
use App\Services\AiApprovalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class ApprovalSheetController extends Controller
{
    /**
     * Tampilkan daftar seluruh Approval Sheet dan Form Interactive.
     */
    public function index(Request $request)
    {
        $sheets = ApprovalSheet::latest()->get();

        $activeSheet = null;
        if ($request->has('active_id')) {
            $activeSheet = ApprovalSheet::find($request->active_id);
        } elseif ($sheets->isNotEmpty()) {
            $activeSheet = $sheets->first();
        }

        return view('approval.approvalSheet', compact('sheets', 'activeSheet'));
    }

    /**
     * Tampilkan form upload CSV dan pembuatan sheet.
     */
    public function create()
    {
        return view('approval.create');
    }

    /**
     * Proses file CSV via AI Engine (Gemini) dan simpan ke database.
     */
    public function store(Request $request, AiApprovalService $aiService)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'line_name'    => 'required|string',
            'machine_type' => 'required|string',
            'csv_file'     => 'required|file|mimes:csv,txt|max:5120',
        ]);

        try {
            $path = $request->file('csv_file')->getRealPath();
            
            // Parsing CSV menjadi Indexed Array yang Rapi untuk AI Service & Blade
            $csvData = [];
            if (($handle = fopen($path, 'r')) !== FALSE) {
                while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
                    if (!empty($row[0])) {
                        $csvData[] = [
                            'parameter' => trim($row[0]),
                            'value'     => isset($row[1]) && trim($row[1]) !== '' ? trim($row[1]) : 'N/A'
                        ];
                    }
                }
                fclose($handle);
            }

            if (empty($csvData)) {
                return back()->with('error', 'File CSV kosong atau format tidak valid.');
            }

            // Memproses AI Service langsung
            $aiResult = $aiService->generateSheetFromCsv(
                $csvData, 
                $request->line_name, 
                $request->machine_type
            );

            // Simpan ke Database
            $sheet = ApprovalSheet::create([
                'title'        => $request->title,
                'line_name'    => $request->line_name,
                'machine_type' => $request->machine_type,
                'ai_result'    => $aiResult,
                'status'       => 'pending',
                'created_by'   => Auth::id() ?? 1,
            ]);

            return redirect()->route('approval.index', ['active_id' => $sheet->id])
                ->with('success', 'Form Sheet Approval berhasil digenerate!');

        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Gagal memproses file: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan detail spesifik Approval Sheet.
     */
    public function show($id)
    {
        $sheet = ApprovalSheet::findOrFail($id);
        
        return view('approval.show', compact('sheet'));
    }

    /**
     * Generasi Tampilan Printable Form Approval menggunakan view printApproval.blade.php
     */
    public function print($id)
    {
        $sheet = ApprovalSheet::findOrFail($id);
        
        return view('approval.printApproval', compact('sheet'));
    }

    /**
     * Update status Approval Sheet menjadi Approved.
     */
    public function approve($id)
    {
        $sheet = ApprovalSheet::findOrFail($id);
        $sheet->update(['status' => 'approved']);

        return back()->with('success', 'Approval Sheet berhasil disetujui (Approved)!');
    }

    /**
     * Update status Approval Sheet menjadi Rejected.
     */
    public function reject($id)
    {
        $sheet = ApprovalSheet::findOrFail($id);
        $sheet->update(['status' => 'rejected']);

        return back()->with('success', 'Approval Sheet berhasil ditolak (Rejected)!');
    }
}