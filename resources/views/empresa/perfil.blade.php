@extends('layouts.dashboard')

@section('title', 'Perfil Empresa - Inspírate SENA')
@section('page-title', 'Perfil Corporativo')

@section('sidebar-nav')
    <span class="nav-label">Portal Empresa</span>
    <a href="{{ route('empresa.dashboard') }}" class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Dashboard
    </a>
    <a href="{{ route('empresa.proyectos') }}" class="nav-item {{ request()->routeIs('empresa.proyectos') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Mis Proyectos
    </a>
    <a href="{{ route('empresa.proyectos.crear') }}" class="nav-item {{ request()->routeIs('empresa.proyectos.crear') ? 'active' : '' }}">
        <i class="fas fa-plus-circle"></i> Publicar Proyecto
    </a>
    <span class="nav-label">Configuración</span>
    <a href="{{ route('empresa.perfil') }}" class="nav-item {{ request()->routeIs('empresa.perfil') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Perfil Empresa
    </a>
@endsection

@section('content')
<div style="max-width: 1200px; margin: 0 auto; animation: slideUp 0.8s ease-out;">
    
    <!-- HEADER BENTO -->
    <div style="display: grid; grid-template-columns: 2.5fr 1fr; gap: 24px; margin-bottom: 32px;">
        
        <!-- Company Info Card -->
        <div class="glass-card" style="display: flex; align-items: center; gap: 40px; padding: 48px; background: linear-gradient(135deg, #1e293b, #0f172a); color: white; border: none; overflow: hidden; position: relative;">
            <div style="position: absolute; right: -50px; top: -50px; font-size: 200px; color: rgba(255,255,255,0.03); transform: rotate(-15deg);">
                <i class="fas fa-building"></i>
            </div>
            
            <div class="company-logo-wrapper" style="position: relative; z-index: 2;">
                <div style="width: 160px; height: 160px; border-radius: 32px; background: rgba(255,255,255,0.1); backdrop-filter: blur(20px); display: flex; align-items: center; justify-content: center; border: 1.5px solid rgba(255,255,255,0.2); box-shadow: 0 25px 50px rgba(0,0,0,0.4);">
                    <i class="fas fa-building" style="font-size: 80px; color: var(--primary);"></i>
                </div>
            </div>
            
            <div style="flex: 1; position: relative; z-index: 2;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                    <span style="background: var(--primary); color: white; padding: 5px 16px; border-radius: 20px; font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px;">Socio Estratégico</span>
                    <span style="color: rgba(255,255,255,0.5); font-size: 13px; font-weight: 600; letter-spacing: 0.5px;">IDENTIFICADOR: {{ $empresa->emp_nit }}</span>
                </div>
                <h2 style="font-size: 42px; font-weight: 900; letter-spacing: -2px; margin-bottom: 24px;">{{ $empresa->emp_nombre }}</h2>
                
                <!-- Perfil Integrity Bar -->
                <div style="max-width: 450px; background: rgba(255,255,255,0.05); padding: 16px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.1);">
                    @php
                        $camposCompletos = 0;
                        if(!empty($empresa->emp_nombre)) $camposCompletos++;
                        if(!empty($empresa->emp_representante)) $camposCompletos++;
                        if(!empty($empresa->emp_nit)) $camposCompletos++;
                        if(!empty($empresa->emp_correo)) $camposCompletos++;
                        $progresoPerfil = ($camposCompletos / 4) * 100;
                    @endphp
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <span style="font-size: 11px; font-weight: 800; color: rgba(255,255,255,0.6); text-transform: uppercase; letter-spacing: 1px;">Integridad del Perfil</span>
                        <span style="font-size: 13px; font-weight: 900; color: var(--primary);">{{ $progresoPerfil }}%</span>
                    </div>
                    <div style="width: 100%; height: 8px; background: rgba(255,255,255,0.1); border-radius: 10px; overflow: hidden;">
                        <div style="width: {{ $progresoPerfil }}%; height: 100%; background: linear-gradient(to right, var(--primary), var(--primary-glow)); border-radius: 10px; box-shadow: 0 0 15px var(--primary-glow);"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Summary Bento -->
        <div style="display: grid; gap: 24px;">
            <div class="glass-card" style="padding: 28px; display: flex; flex-direction: column; justify-content: center; align-items: center; gap: 12px; background: white; text-align: center;">
                <div style="width: 50px; height: 50px; border-radius: 14px; background: var(--primary-soft); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-project-diagram"></i>
                </div>
                <span style="font-size: 12px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Convocatorias</span>
                <span style="font-size: 32px; font-weight: 900; color: var(--text);">{{ $empresa->proyectos()->count() }}</span>
            </div>
            <div class="glass-card" style="padding: 24px; background: var(--primary-soft); border-color: var(--primary-glow); display: flex; align-items: center; gap: 16px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: white; color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 18px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                    <i class="fas fa-check-double"></i>
                </div>
                <div>
                    <span style="font-size: 10px; font-weight: 800; color: var(--primary-dark); text-transform: uppercase; letter-spacing: 1px; display: block;">Estado Cuenta</span>
                    <span style="font-size: 15px; font-weight: 800; color: var(--text);">Verificada</span>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN FORM GRID -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 32px;">
        
        <!-- Editable Content -->
        <div class="glass-card" style="padding: 48px; background: white;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 40px; border-bottom: 1px solid #f1f5f9; padding-bottom: 24px;">
                <div>
                    <h3 style="font-size: 24px; font-weight: 800; color: var(--text); letter-spacing: -0.5px;">Información <span style="color: var(--primary);">Corporativa</span></h3>
                    <p style="color: var(--text-light); font-size: 14px; font-weight: 500; margin-top: 4px;">Mantén tus datos actualizados para mejorar la confianza.</p>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 14px; background: #f8fafc; color: #94a3b8; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fas fa-pen-to-square"></i>
                </div>
            </div>

            <form action="{{ route('empresa.perfil.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div style="display: grid; gap: 32px; margin-bottom: 48px;">
                    <div class="form-group">
                        <label style="font-size: 13px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; display: block;">Razón Social / Nombre Comercial</label>
                        <div style="position: relative;">
                            <i class="fas fa-building" style="position: absolute; left: 18px; top: 18px; color: #94a3b8;"></i>
                            <input type="text" name="nombre_empresa" value="{{ old('nombre_empresa', $empresa->emp_nombre) }}" required class="form-control" style="padding-left: 50px; height: 56px; border-radius: 16px; border: 1.5px solid #e2e8f0; font-weight: 600;">
                        </div>
                    </div>

                    <div class="form-group">
                        <label style="font-size: 13px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; display: block;">Representante Legal Certificado</label>
                        <div style="position: relative;">
                            <i class="fas fa-user-tie" style="position: absolute; left: 18px; top: 18px; color: #94a3b8;"></i>
                            <input type="text" name="representante" value="{{ old('representante', $empresa->emp_representante) }}" required class="form-control" style="padding-left: 50px; height: 56px; border-radius: 16px; border: 1.5px solid #e2e8f0; font-weight: 600;">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px;">
                        <div class="form-group">
                            <label style="font-size: 13px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; display: block;">NIT (Fijo por Seguridad)</label>
                            <div style="position: relative;">
                                <i class="fas fa-id-card" style="position: absolute; left: 18px; top: 18px; color: #cbd5e1;"></i>
                                <input type="text" value="{{ $empresa->emp_nit }}" disabled class="form-control" style="padding-left: 50px; height: 56px; border-radius: 16px; border: 1.5px dashed #e2e8f0; background: #f8fafc; color: #94a3b8; font-weight: 600;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label style="font-size: 13px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; display: block;">Email (Fijo por Seguridad)</label>
                            <div style="position: relative;">
                                <i class="fas fa-envelope" style="position: absolute; left: 18px; top: 18px; color: #cbd5e1;"></i>
                                <input type="email" value="{{ $empresa->emp_correo }}" disabled class="form-control" style="padding-left: 50px; height: 56px; border-radius: 16px; border: 1.5px dashed #e2e8f0; background: #f8fafc; color: #94a3b8; font-weight: 600;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Password Reset -->
                <div style="background: #f8fafc; border: 2px dashed #e2e8f0; border-radius: 24px; padding: 32px; position: relative;">
                    <div style="position: absolute; right: 24px; top: 24px; font-size: 40px; color: #e2e8f0;">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h4 style="font-size: 16px; font-weight: 800; color: var(--text); margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                        Credenciales de Seguridad
                    </h4>
                    <div class="form-group">
                        <label style="font-size: 12px; font-weight: 700; color: var(--text-light); margin-bottom: 8px; display: block;">Nueva Contraseña</label>
                        <div style="position: relative; max-width: 400px;">
                            <i class="fas fa-key" style="position: absolute; left: 16px; top: 14px; color: #94a3b8;"></i>
                            <input type="password" name="password" placeholder="Mín. 6 caracteres para actualizar" class="form-control" style="padding-left: 44px; height: 46px; border-radius: 12px;">
                        </div>
                        <p style="font-size: 11px; color: #64748b; margin-top: 8px; font-weight: 600;"><i class="fas fa-info-circle"></i> Solo completa este campo si deseas cambiar tu clave actual.</p>
                    </div>
                </div>

                <div style="margin-top: 48px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn-premium" style="padding: 18px 56px; font-size: 16px; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);">
                        <i class="fas fa-cloud-arrow-up"></i> Actualizar Perfil Corporativo
                    </button>
                </div>
            </form>
        </div>

        <!-- Sidebar Components -->
        <div style="display: grid; gap: 32px; align-content: start;">
            
            <!-- Contact Info Bento -->
            <div class="glass-card" style="padding: 32px; background: white;">
                <h4 style="font-size: 13px; font-weight: 800; color: var(--text-light); margin-bottom: 24px; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">Puntos de Contacto</h4>
                
                <div style="display: grid; gap: 20px;">
                    <div style="display: flex; align-items: flex-start; gap: 16px;">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #eff6ff; color: #3b82f6; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div>
                            <span style="display: block; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Representante</span>
                            <span style="font-size: 14px; font-weight: 700; color: var(--text);">{{ $empresa->emp_representante }}</span>
                        </div>
                    </div>
                    <div style="display: flex; align-items: flex-start; gap: 16px;">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #fef2f2; color: #ef4444; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fas fa-envelope-open-text"></i>
                        </div>
                        <div>
                            <span style="display: block; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Email Oficial</span>
                            <span style="font-size: 14px; font-weight: 700; color: var(--text); word-break: break-all;">{{ $empresa->emp_correo }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Promotion Card -->
            <div class="glass-card" style="background: linear-gradient(135deg, #1e293b, #0f172a); border: none; padding: 40px; color: white; position: relative; overflow: hidden;">
                <div style="position: absolute; right: -20px; bottom: -20px; font-size: 100px; color: rgba(255,255,255,0.05);">
                    <i class="fas fa-award"></i>
                </div>
                <h4 style="font-size: 20px; font-weight: 900; margin-bottom: 12px; position: relative;">Certificación de Impacto</h4>
                <p style="font-size: 14px; color: rgba(255,255,255,0.6); line-height: 1.6; margin-bottom: 28px; font-weight: 500; position: relative;">Has vinculado talento local en todos tus proyectos. Descarga tu insignia de Aliado SENA.</p>
                <button class="btn-premium" style="background: rgba(255,255,255,0.1); border: 1.5px solid rgba(255,255,255,0.2); color: white; width: 100%; justify-content: center; backdrop-filter: blur(10px); position: relative; box-shadow: none;">
                    <i class="fas fa-download"></i> Próximamente
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    .glass-card:hover { transform: translateY(-4px); box-shadow: 0 15px 35px rgba(0,0,0,0.06); }
</style>
@endsection
