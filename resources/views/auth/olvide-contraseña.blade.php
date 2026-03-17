<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¿Olvidaste tu Contraseña?</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .container { width: 100%; max-width: 420px; }
        .card { background: white; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); overflow: hidden; }
        .header { background: linear-gradient(135deg, #005a87 0%, #003d5c 100%); padding: 30px 20px; text-align: center; color: white; }
        .header h1 { font-size: 24px; margin-bottom: 5px; }
        .header p { font-size: 13px; opacity: 0.9; }
        .content { padding: 30px 20px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 6px; font-weight: 600; color: #333; font-size: 14px; }
        .form-group input { width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; transition: border-color 0.3s; }
        .form-group input:focus { outline: none; border-color: #005a87; box-shadow: 0 0 0 3px rgba(0,90,135,0.1); }
        .btn { width: 100%; padding: 11px; background: #005a87; color: white; border: none; border-radius: 6px; font-weight: 600; font-size: 14px; cursor: pointer; transition: background 0.3s; }
        .btn:hover { background: #003d5c; }
        .back-link { text-align: center; margin-top: 15px; }
        .back-link a { color: #005a87; text-decoration: none; font-size: 13px; }
        .back-link a:hover { text-decoration: underline; }
        .alert { padding: 12px 15px; border-radius: 6px; margin-bottom: 20px; font-size: 13px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-warning { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
        .info-box { background: #f0f7ff; border-left: 4px solid #005a87; padding: 15px; border-radius: 6px; margin-bottom: 20px; font-size: 13px; color: #333; line-height: 1.6; }
        .info-box strong { color: #005a87; }
        @media (max-width: 480px) {
            .container { margin: 20px; }
            .header { padding: 20px 15px; }
            .header h1 { font-size: 20px; }
            .content { padding: 20px 15px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <!-- Header -->
            <div class="header">
                <h1>🔐 Recuperar Contraseña</h1>
                <p>Bolsa de Proyectos SENA</p>
            </div>

            <!-- Content -->
            <div class="content">
                <!-- Mensajes -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Error:</strong> {{ $errors->first() }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('warning'))
                    <div class="alert alert-warning">
                        {{ session('warning') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Info Box -->
                <div class="info-box">
                    <strong>📧 ¿Olvidaste tu contraseña?</strong><br>
                    Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña. El enlace expirará en 30 minutos.
                </div>

                <!-- Formulario -->
                <form action="{{ route('auth.enviar-recuperacion') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="correo">Correo Electrónico</label>
                        <input 
                            type="email" 
                            id="correo" 
                            name="correo" 
                            placeholder="tu@correo.com" 
                            required
                            value="{{ old('correo') }}"
                        >
                        @error('correo')
                            <small style="color: #dc3545;">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn">
                        🔗 Enviar Enlace de Recuperación
                    </button>
                </form>

                <!-- Back Link -->
                <div class="back-link">
                    ¿Recordaste tu contraseña? 
                    <a href="{{ route('login') }}">Inicia sesión aquí</a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div style="text-align: center; color: rgba(255,255,255,0.8); margin-top: 20px; font-size: 12px;">
            <p>© 2026 Bolsa de Proyectos SENA. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
