<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
  body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #1a1a1a; margin: 0; padding: 0; }
  .header { background: #0f6e56; color: #fff; padding: 16px 24px; margin-bottom: 20px; }
  .header h1 { margin: 0 0 3px; font-size: 16px; font-weight: bold; }
  .header p  { margin: 0; font-size: 10px; opacity: 0.85; }
  .content { padding: 0 24px 24px; }
  .stats { margin-bottom: 16px; }
  .stat { display: inline-block; background: #f5f5f5; border-left: 3px solid #0f6e56; padding: 6px 14px; margin-right: 12px; }
  .stat-num   { font-size: 16px; font-weight: bold; color: #0f6e56; display: block; }
  .stat-label { font-size: 9px; color: #666; display: block; }
  table { width: 100%; border-collapse: collapse; }
  th { background: #0f6e56; color: #fff; padding: 7px 8px; text-align: left; font-size: 10px; }
  td { padding: 6px 8px; border-bottom: 0.5px solid #e8e8e8; vertical-align: middle; }
  tr:nth-child(even) td { background: #f9f9f9; }
  .badge { display: inline-block; padding: 2px 7px; border-radius: 10px; font-size: 9px; font-weight: bold; text-transform: uppercase; }
  .badge-pendiente  { background: #FAEEDA; color: #854F0B; }
  .badge-confirmada { background: #EAF3DE; color: #3B6D11; }
  .badge-cancelada  { background: #FCEBEB; color: #A32D2D; }
  .badge-completada { background: #E1F5EE; color: #0F6E56; }
  .footer { margin-top: 20px; padding-top: 10px; border-top: 1px solid #e0e0e0; font-size: 9px; color: #999; text-align: center; }
</style>
</head>
<body>

<div class="header">
  <h1>Reporte General de Citas</h1>
  <p>Sistema de Gestión de Citas &mdash; Generado el {{ now()->format('d/m/Y H:i') }}</p>
</div>

<div class="content">

  @php
    $total       = $citas->count();
    $pendientes  = $citas->where('estado', 'pendiente')->count();
    $confirmadas = $citas->where('estado', 'confirmada')->count();
    $completadas = $citas->where('estado', 'completada')->count();
  @endphp

  <div class="stats">
    <div class="stat"><span class="stat-num">{{ $total }}</span><span class="stat-label">Total</span></div>
    <div class="stat"><span class="stat-num">{{ $pendientes }}</span><span class="stat-label">Pendientes</span></div>
    <div class="stat"><span class="stat-num">{{ $confirmadas }}</span><span class="stat-label">Confirmadas</span></div>
    <div class="stat"><span class="stat-num">{{ $completadas }}</span><span class="stat-label">Completadas</span></div>
  </div>

  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Paciente</th>
        <th>Especialista</th>
        <th>Especialidad</th>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Estado</th>
        <th>Motivo</th>
      </tr>
    </thead>
    <tbody>
      @forelse($citas as $cita)
      <tr>
        <td>{{ $cita->id }}</td>
        <td>{{ $cita->user?->name ?? '-' }}</td>
        <td>{{ $cita->especialista?->nombre ?? 'Por asignar' }}</td>
        <td>{{ $cita->especialista?->especialidad ?? '-' }}</td>
        <td>{{ $cita->fecha ? $cita->fecha->format('d/m/Y') : '-' }}</td>
        <td>{{ $cita->hora ? substr($cita->hora, 0, 5) : '-' }}</td>
        <td><span class="badge badge-{{ $cita->estado }}">{{ ucfirst($cita->estado) }}</span></td>
        <td>{{ \Str::limit($cita->motivo, 40) }}</td>
      </tr>
      @empty
      <tr><td colspan="8" style="text-align:center; color:#999; padding:20px;">No hay citas registradas.</td></tr>
      @endforelse
    </tbody>
  </table>

  <div class="footer">
    Reporte generado automáticamente &mdash; Total de registros: {{ $total }}
  </div>

</div>
</body>
</html>
