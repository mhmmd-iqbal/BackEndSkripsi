<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PDF;

class PdfGeneratorController extends Controller
{
    public function generate()
    {
        $pdf = PDF::loadView('documents.audit.index');
        $pdf->setPaper('A4', 'portrait'); 
        $result = $pdf->stream();

        return response($result, 200)
              ->header('Content-Type', 'application/pdf');
    }
}
