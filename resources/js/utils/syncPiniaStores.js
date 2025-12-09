/*export function syncPiniaStoresAcrossTabs(pinia) {
  window.addEventListener('storage', (event) => {
    if (!event.key || !event.newValue) return;

    try {
      const parsed = JSON.parse(event.newValue);
      // iterar por todos los stores en Pinia
      pinia._s.forEach(store => {
        if (parsed[store.$id]) {
          store.$patch(parsed[store.$id]);
        }
      });
    } catch (error) {
      console.error('Error sincronizando stores:', error);
    }
  });
}*/
