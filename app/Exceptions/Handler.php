<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Spatie\Permission\Exceptions\PermissionDoesNotExist; //NECESARIO
use Illuminate\Http\JsonResponse;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        // 🚨 1. CAPTURA: Permiso NO EXISTE en DB (ya lo tienes)
        if ($e instanceof PermissionDoesNotExist) {
            \Log::warning("Permiso de Spatie NO EXISTE en DB. URL: {$request->fullUrl()}");
            return new JsonResponse([
                'success' => false,
                'message' => 'Acceso Denegado: El recurso no está configurado correctamente en el sistema.',
                'error_type' => 'Permission Not Configured',
            ], 403);
        }

        // 🚨 2. NUEVA CAPTURA: Usuario NO TIENE el permiso (Tu error actual) 🚨
        if ($e instanceof UnauthorizedException) {
            \Log::info("Acceso no autorizado para ID: " . (\auth()->id() ?? 'N/A') . ". Permiso faltante: {$e->getMessage()}");

            return new JsonResponse([
                'success' => false,
                'message' => 'Usted no tiene los permisos requeridos para acceder a este recurso. Contacte al administrador.',
                'error_type' => 'Unauthorized Access',
            ], 403);
        }

        return parent::render($request, $e);
    }
}
