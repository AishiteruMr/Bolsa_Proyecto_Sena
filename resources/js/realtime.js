const ROL = {
    APRENDIZ: 1,
    INSTRUCTOR: 2,
    EMPRESA: 3,
    ADMIN: 4,
};

const CHANNELS = {
    [ROL.ADMIN]: 'role.admin',
    [ROL.APRENDIZ]: 'role.aprendiz',
    [ROL.INSTRUCTOR]: 'role.instructor',
    [ROL.EMPRESA]: 'role.empresa',
};

function handleEvent(eventName, data) {
    if (typeof window.showToast === 'function') {
        let type = 'info';
        if (data.action?.includes('creado') || data.action?.includes('aprobado') || data.action?.includes('aceptada')) type = 'success';
        if (data.action?.includes('rechazado') || data.action?.includes('error')) type = 'error';
        window.showToast(type, data.message || data.mensaje || 'Nueva actualización');
    }

    const evt = new CustomEvent('realtime:' + eventName, { detail: data });
    window.dispatchEvent(evt);
}

function subscribeRoleChannel(echo, rol) {
    const channelName = CHANNELS[rol];
    if (!channelName || !echo) return;

    const channel = echo.private(channelName);

    if (rol === ROL.ADMIN) {
        channel.listen('.proyecto', (d) => handleEvent('proyecto', d));
        channel.listen('.usuario', (d) => handleEvent('usuario', d));
        channel.listen('.audit', (d) => handleEvent('audit', d));
        channel.listen('.soporte', (d) => handleEvent('soporte', d));
    }

    if (rol === ROL.APRENDIZ) {
        channel.listen('.proyecto', (d) => handleEvent('proyecto', d));
        channel.listen('.etapa', (d) => handleEvent('etapa', d));
    }

    if (rol === ROL.INSTRUCTOR) {
        channel.listen('.proyecto', (d) => handleEvent('proyecto', d));
        channel.listen('.postulacion', (d) => handleEvent('postulacion', d));
        channel.listen('.evidencia', (d) => handleEvent('evidencia', d));
        channel.listen('.etapa', (d) => handleEvent('etapa', d));
    }

    if (rol === ROL.EMPRESA) {
        channel.listen('.proyecto', (d) => handleEvent('proyecto', d));
        channel.listen('.postulacion', (d) => handleEvent('postulacion', d));
    }

    channel.listen('.notificacion', (d) => {
        if (typeof window.addNotificationToast === 'function') {
            window.addNotificationToast(d);
        }
        const badge = document.querySelector('.notification-badge');
        if (badge) {
            const count = parseInt(badge.textContent || '0') + 1;
            badge.textContent = count;
            badge.style.display = 'flex';
        }
    });

    channel.notification((n) => {
        if (typeof window.addNotificationToast === 'function') {
            window.addNotificationToast(n);
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const usrId = window.Laravel?.user?.id;
    const rol = window.Laravel?.user?.rol;
    if (!usrId || !rol || typeof window.Echo === 'undefined') return;

    subscribeRoleChannel(window.Echo, rol);
});
