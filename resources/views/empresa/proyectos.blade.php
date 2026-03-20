@extends('layouts.dashboard')
@section('title', 'Mis Proyectos')
@section('page-title', 'Mis Proyectos')

@section('sidebar-nav')
    <a href="{{ route('empresa.dashboard') }}" class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i> Principal</a>
    <a href="{{ route('empresa.proyectos') }}" class="nav-item {{ request()->routeIs('empresa.proyectos') ? 'active' : '' }}"><i class="fas fa-project-diagram"></i> Mis Proyectos</a>
    <a href="{{ route('empresa.proyectos.crear') }}" class="nav-item {{ request()->routeIs('empresa.proyectos.crear') ? 'active' : '' }}"><i class="fas fa-plus-circle"></i> Publicar Proyecto</a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('empresa.perfil') }}" class="nav-item {{ request()->routeIs('empresa.perfil') ? 'active' : '' }}"><i class="fas fa-building"></i> Perfil Empresa</a>
@endsection

@section('content')
    <div style="margin-bottom:24px;">
        <h2 style="font-size:22px; font-weight:700;">Mis Proyectos</h2>
        <p style="color:#666; font-size:14px;">Gestiona todos tus proyectos publicados.</p>
    </div>

    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <div></div>
            <a href="{{ route('empresa.proyectos.crear') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nuevo Proyecto</a>
        </div>

        @if($proyectos->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Categoría</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Duración</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proyectos as $proyecto)
                        <tr>
                            <td style="font-weight:500;">
                                {{ Str::limit($proyecto->pro_titulo_proyecto, 45) }}
                            </td>
                            <td>{{ $proyecto->pro_categoria }}</td>
                            <td>
                                <span class="badge {{ $proyecto->pro_estado === 'Activo' ? 'badge-success' : 'badge-warning' }}">
                                    {{ $proyecto->pro_estado }}
                                </span>
                            </td>
                            <td style="font-size:12px; color:#666;">{{ \Carbon\Carbon::parse($proyecto->pro_fecha_publi)->format('d/m/Y') }}</td>
                            <td style="font-size:12px;">{{ $proyecto->pro_duracion_estimada }} días</td>
                            <td>
                                <div style="display:flex; gap:6px; align-items:center;">
                                    <a href="{{ route('empresa.proyectos.edit', $proyecto->pro_id) }}" class="btn btn-outline btn-sm" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('empresa.proyectos.destroy', $proyecto->pro_id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar este proyecto?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div style="text-align:center; padding:48px 24px; color:#999;">
                <i class="fas fa-folder-open" style="font-size:48px; margin-bottom:16px; opacity:0.5;"></i>
                <p style="font-size:14px;">No hay proyectos publicados aún.</p>
                <p style="font-size:12px; margin-top:8px;">
                    <a href="{{ route('empresa.proyectos.crear') }}" style="color:#39a900; text-decoration:none; font-weight:600;">
                        ¡Publica tu primer proyecto!
                    </a>
                </p>
            </div>
        @endif
    </div>

    <style>
        .btn-danger {
            background-color: #e74c3c;
            color: white;
            border: 1px solid #e74c3c;
        }

        .btn-danger:hover {
            background-color: #c0392b;
            border-color: #c0392b;
        }
    </style>
@endsection
