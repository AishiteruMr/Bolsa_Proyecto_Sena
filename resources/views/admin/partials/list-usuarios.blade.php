    @foreach($usuariosRecientes as $u)
        <div class="user-incorporation-item">
            <div style="width: 44px; height: 44px; border-radius: 12px; background: #eff6ff; display: flex; align-items: center; justify-content: center; color: #3b82f6; font-weight: 800; font-size: 16px; border: 1px solid #dbeafe;">
                {{ strtoupper(substr($u->correo, 0, 1)) }}
            </div>
            <div style="flex: 1; overflow: hidden;">
                <p style="font-size: 13px; font-weight: 800; color: var(--text); margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $u->correo }}</p>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 10px; font-weight: 800; color: var(--primary); text-transform: uppercase;">{{ $u->nombre_rol }}</span>
                    <span style="width: 3px; height: 3px; background: #cbd5e1; border-radius: 50%;"></span>
                    <span style="font-size: 10px; color: #94a3b8; font-weight: 600;">{{ $u->created_at ? \Carbon\Carbon::parse($u->created_at)->diffForHumans() : 'N/A' }}</span>
                </div>
            </div>
        </div>
    @endforeach
