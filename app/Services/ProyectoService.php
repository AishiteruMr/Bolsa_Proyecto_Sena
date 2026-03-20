<?php

namespace App\Services;

use App\Models\Proyecto;
use Illuminate\Pagination\Paginator;

class ProyectoService
{
    /**
     * Obtener proyectos activos con filtros
     *
     * @param  string|null  $busqueda
     * @param  string|null  $categoria
     * @param  int  $paginate
     * @return Paginator
     */
    public function obtenerProyectosActivos(
        ?string $busqueda = null,
        ?string $categoria = null,
        int $paginate = 9
    ): Paginator {
        $query = Proyecto::with('empresa')
            ->activos();

        if ($busqueda) {
            $query->busqueda($busqueda);
        }

        if ($categoria) {
            $query->porCategoria($categoria);
        }

        return $query->recientes()->paginate($paginate);
    }

    /**
     * Obtener categorías disponibles
     *
     * @return \Illuminate\Support\Collection
     */
    public function obtenerCategorias()
    {
        return Proyecto::distinct()->pluck('pro_categoria');
    }

    /**
     * Obtener proyectos recientes
     *
     * @param  int  $limite
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function obtenerProyectosRecientes(int $limite = 6)
    {
        return Proyecto::with('empresa')
            ->activos()
            ->recientes()
            ->limit($limite)
            ->get();
    }

    /**
     * Obtener proyectos disponibles (activos y sin vencer)
     *
     * @param  int  $limite
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function obtenerProyectosDisponibles(int $limite = null)
    {
        $query = Proyecto::with('empresa')
            ->activos()
            ->where('pro_fecha_finalizacion', '>', now())
            ->recientes();

        if ($limite) {
            $query->limit($limite);
        }

        return $query->get();
    }

    /**
     * Contar proyectos activos
     *
     * @return int
     */
    public function contarProyectosActivos(): int
    {
        return Proyecto::activos()->count();
    }

    /**
     * Obtener proyecto con todas sus relaciones
     *
     * @param  int  $proyectoId
     * @return Proyecto|null
     */
    public function obtenerProyectoDetallado(int $proyectoId): ?Proyecto
    {
        return Proyecto::with([
            'empresa',
            'instructor',
            'etapas' => function ($query) {
                $query->orderBy('eta_orden');
            },
            'postulaciones' => function ($query) {
                $query->where('pos_estado', 'Aprobada');
            }
        ])->find($proyectoId);
    }

    /**
     * Obtener postulantes de un proyecto
     *
     * @param  int  $proyectoId
     * @param  string  $estado
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function obtenerPostulantes(int $proyectoId, string $estado = null)
    {
        $query = Proyecto::find($proyectoId)
            ->postulaciones()
            ->with('aprendiz');

        if ($estado) {
            $query->where('pos_estado', $estado);
        }

        return $query->get();
    }

    /**
     * Contar postulantes por estado
     *
     * @param  int  $proyectoId
     * @param  string  $estado
     * @return int
     */
    public function contarPostulantes(int $proyectoId, string $estado = null): int
    {
        $query = Proyecto::find($proyectoId)
            ->postulaciones();

        if ($estado) {
            $query->where('pos_estado', $estado);
        }

        return $query->count();
    }

    /**
     * Verificar si un proyecto está vencido
     *
     * @param  int  $proyectoId
     * @return bool
     */
    public function estaVencido(int $proyectoId): bool
    {
        $proyecto = Proyecto::find($proyectoId);
        return $proyecto ? $proyecto->isVencido() : false;
    }

    /**
     * Obtener días restantes de un proyecto
     *
     * @param  int  $proyectoId
     * @return int
     */
    public function diasRestantes(int $proyectoId): int
    {
        $proyecto = Proyecto::find($proyectoId);
        return $proyecto ? $proyecto->diasRestantes() : 0;
    }
}
