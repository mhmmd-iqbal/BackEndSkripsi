<?php

namespace App\Http\Controllers;

use App\Models\AuditForm;
use Illuminate\Http\Request;

use PDF;

class PdfGeneratorController extends Controller
{
    public function generate($audit_id)
    {
        $audit = AuditForm::with(['reject', 'results.instrumentOrigin.subTopic.topic'])->find($audit_id);

        // return response()->json($audit);
        $pdf = PDF::loadView('documents.audit.index', compact('audit'));
        $pdf->setPaper('A4', 'portrait'); 
        return $pdf->stream('Dokumen.pdf');

        // retrun $pdf->download('invoice.pdf');

        // return response($result, 200)
        //       ->header('Content-Type', 'application/pdf');
    }
}
