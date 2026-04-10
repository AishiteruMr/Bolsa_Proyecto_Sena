<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demasiadas solicitudes - 429</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }
        .error-container {
            background: white;
            padding: 60px 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 500px;
        }
        h1 { font-size: 72px; color: #fa709a; margin-bottom: 20px; }
        h2 { font-size: 24px; color: #333; margin-bottom: 20px; }
        p { font-size: 16px; color: #666; margin-bottom: 30px; }
        a { 
            display: inline-block;
            padding: 12px 30px;
            background: #fa709a;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        a:hover { background: #fee140; color: #333; }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>429</h1>
        <h2>Demasiadas solicitudes</h2>
        <p>Has realizado demasiadas solicitudes. Por favor, espera un momento antes de intentar de nuevo.</p>
        <a href="/">Volver al inicio</a>
    </div>
</body>
</html>