<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desasignado de Proyecto</title>
</head>
<body style="font-family: 'Segoe UI', Arial, sans-serif; background:#f4f6f9; padding:40px 20px; margin:0;">
    <div style="max-width:600px; margin:auto; background:#ffffff; border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,0.08); overflow:hidden;">

        <!-- Header -->
        <div style="background:linear-gradient(135deg,#f39c12,#d68910); padding:36px 40px; text-align:center;">
            <div style="font-size:52px; margin-bottom:12px;">⚠️</div>
            <h1 style="color:#ffffff; margin:0; font-size:22px; font-weight:700;">Desasignado de Proyecto</h1>
            <p style="color:rgba(255,255,255,0.85); margin:8px 0 0; font-size:14px;">El proyecto ha sido desactivado o reasignado</p>
        </div>

        <!-- Body -->
        <div style="padding:36px 40px;">
            <p style="font-size:16px; color:#2c3e50; margin:0 0 20px;">
                Hola <strong>{{ $instructorNombre }}</strong>,
            </p>
            <p style="font-size:15px; color:#555; line-height:1.7; margin:0 0 24px;">
                Te informamos que has sido <strong style="color:#e67e22;">desasignado</strong> del siguiente proyecto:
            </p>

            <!-- Project Card -->
            <div style="background:#fff8f0; border:1px solid #fde8c8; border-radius:12px; padding:24px; margin-bottom:24px;">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
                    <div style="font-size:28px;">📁</div>
                    <div>
                        <h2 style="color:#2c3e50; font-size:17px; margin:0 0 4px;">{{ $proyectoTitulo }}</h2>
                        <p style="color:#777; font-size:13px; margin:0;">🏢 {{ $empresaNombre }}</p>
                    </div>
                </div>
                <div style="background:#fcf3e8; border-radius:8px; padding:12px 16px; border-left:3px solid #f39c12;">
                    <p style="font-size:13px; color:#7d5a00; margin:0;">
                        Este proyecto ha sido <strong>desactivado</strong> o fue reasignado a otro instructor por decisión del administrador.
                    </p>
                </div>
            </div>

            <!-- Info box -->
            <div style="background:#eaf5ff; border:1px solid #bee3f8; border-radius:10px; padding:16px 20px; margin-bottom:24px;">
                <p style="font-size:14px; color:#2b6cb0; font-weight:700; margin:0 0 8px;">ℹ️ ¿Qué significa esto?</p>
                <ul style="margin:0; padding-left:18px; color:#555; font-size:13px; line-height:1.9;">
                    <li>Ya no tienes acceso a gestionar este proyecto</li>
                    <li>Tu historial de actividad en él se conserva</li>
                    <li>Puedes seguir gestionando tus otros proyectos asignados</li>
                </ul>
            </div>

            <div style="text-align:center; margin:24px 0 10px;">
                <a href="{{ url('/instructor/dashboard') }}"
                   style="background:linear-gradient(135deg,#39a900,#2d8500);
                          color:#ffffff;
                          padding:14px 32px;
                          text-decoration:none;
                          border-radius:30px;
                          font-size:15px;
                          font-weight:bold;
                          display:inline-block;">
                    📊 Ver Mis Proyectos
                </a>
            </div>

            <p style="font-size:13px; color:#888; text-align:center; margin:16px 0 0;">
                Si tienes alguna duda sobre esta decisión, por favor contacta al administrador.
            </p>
        </div>

        <!-- Footer -->
        <div style="background:#f8f9fa; padding:20px 40px; border-top:1px solid #ecf0f1; text-align:center;">
            <p style="font-size:14px; color:#39a900; margin:0; font-weight:600;">Equipo Bolsa de Proyecto — Inspírate SENA</p>
        </div>
    </div>
</body>
</html>
