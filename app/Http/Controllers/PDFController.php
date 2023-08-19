<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use PDF;
use App\Models\Kontrak;
use App\Models\MitraPerusahaan;
use App\Models\Pegawai;
use App\Models\Pensiun;
use App\Models\Riwayat;

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

    public function mitrapdf($id)
    {
    // Find the Kontrak by its ID
    $mitra = MitraPerusahaan::findOrFail($id);
    $pdf = PDF::loadView('mitraPDF', ['mitra' => $mitra]);

    // Return the PDF as a download
    return $pdf->download('mitra.pdf');
    }

    public function riwayatpdf($id)
    {
    // Find the Kontrak by its ID
    $riwayat = Riwayat::findOrFail($id);
    $pdf = PDF::loadView('riwayatPDF', ['riwayat' => $riwayat]);

    // Return the PDF as a download
    return $pdf->download('riwayat.pdf');
    }

    public function historypdf($id)
    {
    // Find the Kontrak by its ID
    $history = History::findOrFail($id);
    $pdf = PDF::loadView('historyPDF', ['history' => $history]);

    // Return the PDF as a download
    return $pdf->download('history.pdf');
    }
}