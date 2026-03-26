<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    @section('styles')
        <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    @endsection
</head>
<body>
    <div class="container">
        <div class="card">
            <!-- Header -->
            <div class="header">
                <h1>🔑 Nueva Contraseña</h1>
                <p>Bolsa de Proyectos SENA</p>
            </div>

            <!-- Content -->
            <div class="content">
                <!-- Mensajes de Error -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Error:</strong>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('warning'))
                    <div class="alert alert-warning">
                        {{ session('warning') }}
                    </div>
                @endif

                <!-- Requisitos de Contraseña -->
                <div class="password-requirements">
                    <h4>📋 Requisitos:</h4>
                    <ul style="list-style: none; margin: 0; padding: 0;">
                        <li class="requirement unmet" id="req-length">
                            <span class="requirement-icon">✓</span>
                            Mínimo 6 caracteres
                        </li>
                        <li class="requirement unmet" id="req-upper">
                            <span class="requirement-icon">✓</span>
                            Contener una letra mayúscula
                        </li>
                        <li class="requirement unmet" id="req-lower">
                            <span class="requirement-icon">✓</span>
                            Contener una letra minúscula
                        </li>
                        <li class="requirement unmet" id="req-number">
                            <span class="requirement-icon">✓</span>
                            Contener un número
                        </li>
                    </ul>
                </div>

                <!-- Formulario -->
                <form action="{{ route('auth.restablecer-contraseña') }}" method="POST" id="formRestablecer">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="correo" value="{{ $correo }}">

                    <div class="form-group">
                        <label for="password">Nueva Contraseña</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Ingresa tu nueva contraseña" 
                            required
                            autocomplete="new-password"
                            onkeyup="validarContraseña()"
                        >
                        @error('password')
                            <small style="color: #dc3545;">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirmar Contraseña</label>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            placeholder="Confirma tu nueva contraseña" 
                            required
                            autocomplete="new-password"
                            onkeyup="validarCoincidencia()"
                        >
                        @error('password_confirmation')
                            <small style="color: #dc3545;">{{ $message }}</small>
                        @enderror
                        <small id="coincidencia" style="display: none; color: #dc3545;">Las contraseñas no coinciden</small>
                    </div>

                    <button type="submit" class="btn" id="btnEnviar">
                        🔐 Restablecer Contraseña
                    </button>
                </form>

                <!-- Back Link -->
                <div class="back-link">
                    ¿Necesitas ayuda? 
                    <a href="{{ route('auth.olvide-contraseña') }}">Solicitar nuevo enlace</a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div style="text-align: center; color: rgba(255,255,255,0.8); margin-top: 20px; font-size: 12px;">
            <p>© 2026 Bolsa de Proyectos SENA. Todos los derechos reservados.</p>
        </div>
    </div>

    <script>
        function validarContraseña() {
            const password = document.getElementById('password').value;

            // Validaciones
            const length = password.length >= 6;
            const upper = /[A-Z]/.test(password);
            const lower = /[a-z]/.test(password);
            const number = /[0-9]/.test(password);

            // Actualizar estilos
            actualizar('req-length', length);
            actualizar('req-upper', upper);
            actualizar('req-lower', lower);
            actualizar('req-number', number);

            validarCoincidencia();
        }

        function validarCoincidencia() {
            const password = document.getElementById('password').value;
            const confirmation = document.getElementById('password_confirmation').value;
            const coincidencia = document.getElementById('coincidencia');

            if (confirmation && password !== confirmation) {
                coincidencia.style.display = 'inline';
            } else {
                coincidencia.style.display = 'none';
            }
        }

        function actualizar(id, met) {
            const element = document.getElementById(id);
            if (met) {
                element.classList.remove('unmet');
                element.classList.add('met');
                element.querySelector('.requirement-icon').textContent = '✓';
            } else {
                element.classList.remove('met');
                element.classList.add('unmet');
                element.querySelector('.requirement-icon').textContent = '✓';
            }
        }

        // Validación al cargar
        document.getElementById('formRestablecer').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmation = document.getElementById('password_confirmation').value;

            if (password !== confirmation) {
                e.preventDefault();
                document.getElementById('coincidencia').style.display = 'inline';
                return false;
            }
        });
    </script>
</body>
</html>
