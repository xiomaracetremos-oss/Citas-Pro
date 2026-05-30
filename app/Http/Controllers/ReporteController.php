<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    public function pdf()
    {
        $citas = Cita::with(['user', 'especialista'])->orderByDesc('fecha')->get();

        $pdf = Pdf::loadView('pdf.citas', compact('citas'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('reporte-citas.pdf');
    }
}
