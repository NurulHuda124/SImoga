<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\Kontrak;
use App\Models\Pegawai;
use App\Models\Pensiun;

class PDFController extends Controller
{
    public function kontrakpdf($id)
    {
        // Find the Kontrak by its ID
        $kontrak = Kontrak::findOrFail($id);
        $pegawai = Pegawai::findOrFail($id);

        // Generate PDF using the view 'kontrakPDF'
        $pdf = PDF::loadView('kontrakPDF', ['kontrak' => $kontrak, 'pegawai'=>$pegawai]);

        // Return the PDF as a download
        return $pdf->download('kontrak.pdf');
    }
}
