<?php

namespace App\Http\Controllers;

use App\Models\AuditForm;
use Illuminate\Http\Request;

use PDF;

class PdfGeneratorController extends Controller
{
    public function generate($audit_id)
    {
        $audit = AuditForm::with(['auditee', 'reject', 'results'])->find($audit_id);

        $pdf = PDF::loadView('documents.audit.index', compact('audit'));
        $pdf->setPaper('A4', 'portrait'); 
        return $pdf->stream('Dokumen.pdf');
    }
}
