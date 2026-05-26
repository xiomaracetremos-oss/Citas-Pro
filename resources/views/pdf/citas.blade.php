<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Citas</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #4a90d9; color: white; }
        h1 { color: #333; }
    </style>
</head>
<body>
    <h1>Reporte de Citas</h1>
    <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Usuario</th>
                <th>Especialista</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Estado</th>
                <th>Motivo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($citas as $cita)
            <tr>
                <td>{{ $cita->id }}</td>
                <td>{{ $cita->user->name ?? 'N/A' }}</td>
                <td>{{ $cita->especialista?->nombre ?? 'Por asignar' }}</td>
                <td>{{ $cita->fecha ? $cita->fecha->format('d/m/Y') : 'Por asignar' }}</td>
                <td>{{ $cita->hora ? substr($cita->hora, 0, 5) : 'Por asignar' }}</td>
                <td>{{ ucfirst($cita->estado) }}</td>
                <td>{{ $cita->motivo }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
