<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Exitoso</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; background-color:#f4f6f9; padding:40px 20px; margin:0;">
    <div style="max-width:600px; margin:auto; background:#ffffff; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.08); padding:40px;">

        <div style="text-align:center;">
            <h2 style="color:#2c3e50; margin-bottom:10px;">🎉 ¡Registro Exitoso!</h2>
            <p style="color:#7f8c8d; font-size:15px;">Bienvenido a la plataforma</p>
        </div>

        <hr style="border:none; border-top:1px solid #ecf0f1; margin:25px 0;">

        <p style="font-size:16px; color:#34495e;">
            Hola <strong style="color:#2c3e50;">{{ $nombre }} {{ $apellido }}</strong>,
        </p>

        <p style="font-size:15px; color:#555; line-height:1.6;">
            Nos complace informarte que tu cuenta fue creada correctamente en <strong>Bolsa de Proyecto SENA</strong>.
        </p>

        <p style="font-size:15px; color:#555; line-height:1.6;">
            Ahora puedes iniciar sesión y comenzar a explorar todas las funcionalidades disponibles para tu perfil.
        </p>

        <div style="text-align:center; margin:30px 0;">
            <a href="{{ url('/login') }}"
                style="background:linear-gradient(135deg,#39a900,#2d8500);
                    color:#ffffff;
                    padding:14px 28px;
                    text-decoration:none;
                    border-radius:30px;
                    font-size:15px;
                    font-weight:bold;
                    display:inline-block;">
                🚀 Iniciar Sesión
            </a>
        </div>

        <hr style="border:none; border-top:1px solid #ecf0f1; margin:25px 0;">

        <p style="font-size:13px; color:#95a5a6; text-align:center;">
            Si no realizaste este registro, puedes ignorar este mensaje.
        </p>

        <p style="font-size:14px; color:#2c3e50; text-align:center; margin-top:20px;">
            Con aprecio,<br>
            <strong>Equipo Bolsa de Proyecto — Inspírate SENA</strong>
        </p>
    </div>
</body>
</html>
