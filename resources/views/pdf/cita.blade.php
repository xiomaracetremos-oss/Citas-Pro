<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
  body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1a1a1a; margin: 0; padding: 0; }
  .header { background: #0f6e56; color: #fff; padding: 20px 30px; margin-bottom: 24px; }
  .header h1 { margin: 0 0 4px; font-size: 20px; font-weight: bold; }
  .header p { margin: 0; font-size: 11px; opacity: 0.85; }
  .content { padding: 0 30px 30px; }
  .badge { display: inline-block; padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: bold; text-transform: uppercase; }
  .badge-pendiente  { background: #FAEEDA; color: #854F0B; }
  .badge-confirmada { background: #EAF3DE; color: #3B6D11; }
  .badge-cancelada  { background: #FCEBEB; color: #A32D2D; }
  .badge-completada { background: #E1F5EE; color: #0F6E56; }
  table { width: 100%; border-collapse: collapse; margin-top: 16px; }
  td { padding: 10px 12px; border-bottom: 0.5px solid #e0e0e0; vertical-align: top; }
  td:first-child { width: 40%; color: #555; font-weight: bold; }
  .section-title { font-size: 11px; text-transform: uppercase; color: #888; letter-spacing: 0.05em; margin: 20px 0 4px; }
  .divider { border: none; border-top: 1px solid #e0e0e0; margin: 16px 0; }
  .footer { margin-top: 30px; padding-top: 12px; border-top: 1px solid #e0e0e0; font-size: 10px; color: #999; text-align: center; }
</style>
</head>
<body>

<div class="header">
  <h1>Comprobante de Cita</h1>
  <p>Sistema de Gestión de Citas &mdash; Generado el {{ now()->format('d/m/Y H:i') }}</p>
</div>

<div class="content">

  <p class="section-title">Información del paciente</p>
  <table>
    <tr><td>Nombre</td><td>{{ $cita->user->name }}</td></tr>
    <tr><td>Correo</td><td>{{ $cita->user->email }}</td></tr>
  </table>

  <hr class="divider">
  <p class="section-title">Datos de la cita</p>
  <table>
    <tr><td>Código de cita</td><td>#{{ $cita->id }}</td></tr>
    <tr>
      <td>Estado</td>
      <td><span class="badge badge-{{ $cita->estado }}">{{ ucfirst($cita->estado) }}</span></td>
    </tr>
    <tr><td>Motivo</td><td>{{ $cita->motivo }}</td></tr>
    <tr><td>Fecha</td><td>{{ $cita->fecha ? $cita->fecha->format('d/m/Y') : 'Por asignar' }}</td></tr>
    <tr><td>Hora</td><td>{{ $cita->hora ? substr($cita->hora, 0, 5) : 'Por asignar' }}</td></tr>
    <tr><td>Fecha de solicitud</td><td>{{ $cita->created_at?->format('d/m/Y H:i') }}</td></tr>
  </table>

  <hr class="divider">
  <p class="section-title">Especialista asignado</p>
  <table>
    <tr><td>Nombre</td><td>{{ $cita->especialista?->nombre ?? 'Por asignar' }}</td></tr>
    <tr><td>Especialidad</td><td>{{ $cita->especialista?->especialidad ?? 'Por asignar' }}</td></tr>
    <tr><td>Teléfono</td><td>{{ $cita->especialista?->telefono ?? 'Por asignar' }}</td></tr>
  </table>

  <div class="footer">
    Este documento es un comprobante oficial generado automáticamente por el sistema.
  </div>

</div>
</body>
</html>
