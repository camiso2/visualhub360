export const capitalizeWords = (str) => {
    if (!str) return '';

    return str
        .toLowerCase()
        .split(' ')
        .map(word => {
            if (!word) return word;
            return word.charAt(0).toUpperCase() + word.slice(1);
        })
        .join(' ');
};

// Puedes añadir más funciones aquí
export const capitalize = (str) => {
    if (!str) return '';
    return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
};



export const openImageViewer = (imageUrl) => {
    console.log('imageUrl : ' + imageUrl);
    // Abre la imagen en una nueva pestaña (asumiendo que /storage/ es accesible públicamente)
    window.open(`${imageUrl}`, '_blank');
};

// export nombrado
export function getFormatDecimal(value) {
  if (value === null || value === undefined) return "";

  // Sólo dígitos y punto
  value = String(value).replace(/[^0-9.]/g, "");

  // dejar solo el primer punto
  const parts = value.split(".");
  if (parts.length > 2) {
    value = parts[0] + "." + parts.slice(1).join("");
  }

  // máximo 2 decimales
  if (value.includes(".")) {
    const [integer, decimal] = value.split(".");
    value = integer + "." + decimal.slice(0, 2);
  }

  return value;
}

/**
 * Limpia y formatea un valor de cadena para permitir exclusivamente números enteros (dígitos 0-9).
 * Se puede usar en el evento @input de un campo de formulario.
 * * @param {string | number} value El valor actual del input.
 * @returns {string} El valor limpiado, conteniendo solo dígitos.
 */
export function getFormatInteger(value) {
    // 1. Manejar valores nulos/indefinidos
    if (value === null || value === undefined) {
        return "";
    }

    // Convertir el valor a string para asegurar el uso de métodos de cadena
    const stringValue = String(value);

    // 2. 🎯 CLAVE: Reemplazar todo lo que NO sea un dígito (0-9) con una cadena vacía.
    // Esto elimina automáticamente letras, puntos, comas, símbolos, etc.
    const cleanedValue = stringValue.replace(/[^0-9]/g, "");

    // 3. Devolver el valor limpiado
    return cleanedValue;
}
export function getFormatCurrency (value) {
    // Función simple de formateo de moneda
    if (typeof value !== 'number') return '$0';
    return '$' + value.toLocaleString('es-CO', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
};



// ==================== SINCRONIZACIÓN GLOBAL DE PINIA ====================



