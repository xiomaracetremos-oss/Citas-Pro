<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Especialista;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function index()
    {
        $citas = Cita::with(['user', 'especialista'])
            ->when(auth()->user()->role !== 'admin', fn ($query) => $query->where('user_id', auth()->id()))
            ->latest('created_at')
            ->get();

        $especialistas = Especialista::orderBy('nombre')->get();

        return view('citas.index', compact('citas', 'especialistas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'motivo' => ['required', 'string'],
        ]);

        $data['user_id'] = $request->user()->id;
        $data['estado'] = 'pendiente';

        Cita::create($data);

        return redirect()->route('citas.index')->with('status', 'Solicitud de cita enviada.');
    }

    public function edit(Cita $cita)
    {
        abort_unless(auth()->user()->role === 'admin', 403);

        $especialistas = Especialista::orderBy('nombre')->get();

        return view('citas.edit', compact('cita', 'especialistas'));
    }

    public function update(Request $request, Cita $cita)
    {
        abort_unless(auth()->user()->role === 'admin', 403);

        $data = $request->validate([
            'especialista_id' => ['required', 'exists:especialistas,id'],
            'fecha'           => ['required', 'date'],
            'hora'            => ['required'],
            'motivo'          => ['required', 'string'],
            'estado'          => ['required', 'string', 'max:30'],
        ]);

        $cita->update($data);

        return redirect()->route('citas.index')->with('status', 'Cita actualizada.');
    }

    public function destroy(Cita $cita)
    {
        abort_unless(
            auth()->user()->role === 'admin' || ($cita->user_id === auth()->id() && $cita->estado === 'pendiente'),
            403
        );

        $cita->delete();

        return redirect()->route('citas.index')->with('status', 'Cita eliminada.');
    }

    public function pdf(Cita $cita)
    {
        abort_unless(auth()->user()->role === 'admin' || $cita->user_id === auth()->id(), 403);

        $cita->load(['user', 'especialista']);

        $pdf = Pdf::loadView('pdf.cita', compact('cita'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('cita-' . $cita->id . '.pdf');
    }
}
