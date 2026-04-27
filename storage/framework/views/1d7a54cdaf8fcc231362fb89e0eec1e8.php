<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Roboto, sans-serif; line-height: 1.7; color: #334155; background-color: #f1f5f9; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 30px auto; background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border: 1px solid #e2e8f0; }
        .header { background: #0f172a; color: white; padding: 40px 30px; text-align: center; }
        .header h2 { margin: 0; font-size: 26px; font-weight: 700; letter-spacing: -0.5px; }
        .content { padding: 40px 30px; }
        .card { background: #f8fafc; padding: 25px; border-radius: 16px; margin-bottom: 25px; border: 1px solid #e2e8f0; }
        .card h4 { margin: 0 0 12px 0; color: #475569; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; }
        .message-text { font-size: 16px; color: #1e293b; margin: 0; }
        .response-text { font-size: 16px; color: #1e293b; margin: 0; font-weight: 500; }
        .footer { text-align: center; padding: 25px; font-size: 12px; color: #94a3b8; background: #f8fafc; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Actualización de Soporte</h2>
        </div>
        <div class="content">
            <p>Hola <strong><?php echo e($nombre); ?></strong>,</p>
            <p>Hemos procesado tu consulta sobre <strong><?php echo e($motivo); ?></strong> y tenemos una respuesta para ti.</p>
            
            <div class="card">
                <h4>Tu consulta original</h4>
                <p class="message-text">"<?php echo e($mensaje); ?>"</p>
            </div>
            
            <div class="card" style="border-left: 5px solid #2563eb; background: #eff6ff;">
                <h4>Nuestra respuesta</h4>
                <p class="response-text"><?php echo e($respuesta); ?></p>
            </div>
            
            <p>Gracias por tu paciencia y por confiar en nosotros.</p>
            <p>Atentamente,<br><strong>Equipo de Bolsa de Empleo</strong></p>
        </div>
        <div class="footer">
            &copy; 2026 Bolsa de Empleo SENA. Mensaje automático.
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\Bolsa_Proyecto_Sena\resources\views/emails/respuesta-soporte.blade.php ENDPATH**/ ?>