<?php

namespace App\Custom;

trait ApiResponseTrait
{

    /**
     * Respuesta genérica para mensajes de error con estructura estándar.
     *
     * @param int $code
     * @param string $message
     * @param mixed|null $payload
     * @return array
     */
    protected function errorMessage(
        int $code,
        string $message,
        mixed $payload = null
    ): array {
        return [
            'code' => $code,
            'message' => $message,
            'success' => false,
            'data' => $payload,
        ];
    }

    /**
     * Respuesta para éxito genérico.
     *
     * @param int $code
     * @param string $message
     * @param bool $status
     * @param int $count
     * @param array|null $payload
     * @return array
     */
    protected function successfullMessage(
        int $code,
        string $message,
        bool $status,
        int $count,
        array|null $payload = null
    ): array {
        return [
            'code' => $code,
            'message' => $message,
            'success' => $status,
            'count' => $count,
            'data' => $payload,
        ];
    }

    /**
     * Respuesta para error de validación.
     *
     * @param mixed $errors
     * @return array
     */
    protected function validationError($errors): array
    {
        return [
            'code' => 422,
            'message' => 'Error de validación',
            'success' => false,
            'errors' => $errors,
        ];
    }

    /**
     * Respuesta para error no autorizado (sin permisos).
     *
     * @param string $message
     * @return array
     */
    protected function unauthorized(string $message = 'Acceso no autorizado'): array
    {
        return [
            'code' => 403,
            'message' => $message,
            'success' => false,
        ];
    }

    /**
     * Respuesta para recurso no encontrado.
     *
     * @param string $message
     * @return array
     */
    protected function notFound(string $message = 'Recurso no encontrado'): array
    {
        return [
            'code' => 404,
            'message' => $message,
            'success' => false,
        ];
    }

    /**
     * Respuesta para errores internos del servidor.
     *
     * @param string $error
     * @param string|null $context
     * @return array
     */
    protected function eMessageError(string $error, string|null $context = null): array
    {
        return [
            'code' => 500,
            'message' => 'Error interno del servidor',
            'success' => false,
            'error' => $error,
            'context' => $context,
        ];
    }

    /**
     * Respuesta genérica para errores de proceso o lógica de negocio
     *
     * @param string $message
     * @param int $code
     * @return array
     */
    public function errorGeneric(string $message, int $code): array
    {
        return [
            'code' => $code,
            'message' => $message,
            'success' => false,
            'data' => null,
        ];
    }

    protected function errorValidator($errors, $code = 422, $message = 'Error de validación')
    {
        // Transforma el objeto $errors (MessageBag) en un array asociativo simple
        return [
            "code" => $code,
            "message" => $message,
            "success" => false,
            "data" => [
                "errors" => $errors // Laravel MessageBag ya es formateable a JSON
            ]
        ];
    }

}
