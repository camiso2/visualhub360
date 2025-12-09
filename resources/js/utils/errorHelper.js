// src/utils/errorHelper.js

/**
 * Procesa el objeto de error de Axios y extrae un mensaje de error legible.
 * Maneja errores de conexión, validación (422) y otros códigos de estado comunes.
 * * @param {object} error - El objeto de error completo de Axios.
 * @returns {string} El mensaje de error más relevante o un mensaje por defecto.
 */
export function getErrorMessage(error) {

    // --- 1. Error de Conexión o Petición Fallida (Sin respuesta del servidor) ---
    if (!error.response) {
        // Esto cubre errores de red, CORS, o servidor totalmente caído/inaccesible.
        return "Error de conexión: El servidor no responde o hay un problema de red.";
    }

    const { status, data } = error.response;
    let message = data?.message || `Error del servidor: ${status}`;

    // --- 2. Manejo de Errores de Cliente (4xx) ---
    switch (status) {

        case 401:
            // No autorizado (Token inválido o expirado)
            return data.message || "Acceso denegado. Por favor, inicia sesión de nuevo.";

        case 403:
            // Prohibido (El usuario no tiene permisos para realizar esta acción)
            return data.message || "No tienes permiso para realizar esta acción.";

        case 404:
            // No encontrado (El endpoint o recurso no existe)
            return "El recurso solicitado no fue encontrado. Verifica la ruta de la API.";

        case 422:
            // Error de Validación (Unprocessable Content)

            // Intenta acceder a la estructura de errores anidada (ej: data.data.errors)
            const validationErrors = data?.data?.errors ?? data?.errors;

            if (validationErrors) {
                // Obtenemos la primera clave de error (ej: 'items.0.quantity')
                const firstKey = Object.keys(validationErrors)[0];

                // Devolvemos el primer mensaje de ese error
                return validationErrors[firstKey][0];
            }

            // Fallback si la respuesta 422 no tiene el objeto 'errors'
            return data.message || 'Error de validación: Datos incompletos o incorrectos.';

        case 409:
            // Conflicto (Como el número de factura duplicado)
            return data.message || "Conflicto de datos: El registro ya existe o choca con otra información.";

        default:
            // Errores 400 genéricos, 408, u otros que no se manejan explícitamente
            if (status >= 400 && status < 500) {
                 return message;
            }
            break;
    }

    // --- 3. Manejo de Errores del Servidor (5xx) ---
    if (status >= 500) {
        // 500 Internal Server Error, 503 Service Unavailable, etc.
        return "Error interno del servidor. Inténtalo de nuevo más tarde.";
    }

    // Fallback para cualquier otro caso
    return message;
}
