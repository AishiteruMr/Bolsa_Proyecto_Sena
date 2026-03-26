<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¿Olvidaste tu Contraseña?</title>
    @section('styles')
        <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    @endsection

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
