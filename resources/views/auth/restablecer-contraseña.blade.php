<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
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
        .form-group input[type="password"]::placeholder { font-size: 13px; }
        .btn { width: 100%; padding: 11px; background: #005a87; color: white; border: none; border-radius: 6px; font-weight: 600; font-size: 14px; cursor: pointer; transition: background 0.3s; }
        .btn:hover { background: #003d5c; }
        .password-requirements { background: #f0f7ff; border-left: 4px solid #005a87; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 12px; color: #333; }
        .password-requirements h4 { margin-bottom: 8px; color: #005a87; }
        .password-requirements ul { margin-left: 18px; }
        .password-requirements li { margin: 4px 0; }
        .requirement { display: flex; align-items: center; margin: 6px 0; font-size: 12px; }
        .requirement.met { color: #28a745; }
        .requirement.unmet { color: #dc3545; }
        .requirement-icon { margin-right: 8px; }
        .alert { padding: 12px 15px; border-radius: 6px; margin-bottom: 20px; font-size: 13px; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-warning { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
        .back-link { text-align: center; margin-top: 15px; }
        .back-link a { color: #005a87; text-decoration: none; font-size: 13px; }
        .back-link a:hover { text-decoration: underline; }
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
